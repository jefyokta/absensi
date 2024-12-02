<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\SubDivisionController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminHasDivision;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsAdmins;
use App\Http\Middleware\isSuperAdmin;
use App\Livewire\Employees;
use App\Models\Absensi;
use App\Models\SubDivisions;
use App\Models\User;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/home', function () {

    return view('pages.home.index');
});
Route::get('/', function () {
    return view('pages.home.index');
});

Route::get('/about', function () {
    return view('pages.home.about');
});



Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/bukti', [ImageController::class, 'bukti'])->middleware('auth');
Route::get('/qrcode', [ImageController::class, 'qrcode'])->middleware('auth');

Route::post('/dashboard/print', [DashboardController::class, 'print'])->middleware(IsAdmins::class);
Route::post('/dashboard/export', [DashboardController::class, 'export'])->middleware(IsAdmins::class);



Route::put('/dashboard/sub_division', [SubDivisionController::class, 'update'])->middleware(isSuperAdmin::class);
Route::get('/dashboard/sub_division', [SubDivisionController::class, 'index'])->middleware(isSuperAdmin::class);
Route::get('/dashboard/sub_division/employees', [SubDivisionController::class, 'show'])->middleware(isSuperAdmin::class);
Route::get('/dashboard/sub_division/print', [SubDivisionController::class, 'print'])->middleware('admin');
Route::get('/dashboard/sub_division/export', [SubDivisionController::class, 'export'])->middleware('admin');
Route::get('/dashboard/mydivision', [SubDivisionController::class, 'mydivision'])->middleware(AdminHasDivision::class);



Route::post('/dashboard/sub_division', [SubDivisionController::class, 'store'])->middleware(isSuperAdmin::class);
Route::delete('/dashboard/sub_division', [SubDivisionController::class, 'delete'])->middleware(isSuperAdmin::class);
Route::get('/dashboard/sub_division/create', [SubDivisionController::class, 'create'])->middleware(isSuperAdmin::class);
Route::get('/dashboard/sub_division/edit', [SubDivisionController::class, 'edit'])->middleware(isSuperAdmin::class);

Route::delete('/logout', [LoginController::class, 'logout']);
Route::get('/qrabsen/masuk', [QrController::class, 'masuk'])->middleware('admin');
Route::post('/qrabsen', [QrController::class, 'create'])->middleware('admin');
Route::get('/qrabsen/keluar', [QrController::class, 'keluar'])->middleware('admin');
Route::get('/dashboard', function () {

    if (auth()->user()->is_admin || auth()->user()->is_superadmin) {
        $user =  User::select("*")->where('is_superadmin', null);

        $admin =  User::select("*")->where('is_admin', 1);
        $employees =  User::select("*")->where('is_superadmin', null)->where('is_admin', null);
        $subdivision = SubDivisions::select("*")->get()->count();
        $today = Absensi::where('date', '=', date('d/m/Y'))->count();
        $hadir = Absensi::where('date', '=', date('d/m/Y'))->where('status', 1)->count();

        // dd($hadir);
        if (auth()->user()->divisions_id) {
            $sub = auth()->user()->divisions_id;
            $user =  $user->where('divisions_id', $sub);
            $admin = $admin->where('divisions_id', $sub);
            $employees =  $employees->where('divisions_id', $sub);
            $absenQuery = Absensi::query();
            $today =  $absenQuery->whereHas('user', function ($query) {
                $query->where('divisions_id', auth()->user()->divisions_id);
            })
                ->where('date', '=', date('d/m/Y'))->get()->count();

            $hadir =  $absenQuery->whereHas('user', function ($query) {
                $query->where('divisions_id', auth()->user()->divisions_id);
            })->where('date', '=', date('d/m/Y'))->where('status', 1)->get()->count();
        }


        return view("dashboard.dashboard", [
            "title" => "Dashboard ",
            "users" => $user->get()->count(),
            "admin" => $admin->get()->count(),
            "employees" => $employees->get()->count(),
            "subdivision" => $subdivision,
            "presensi" => $today,
            "hadir" => $hadir,
            "tidakhadir" => $user->get()->count() - $hadir
        ]);
    } else {

        return (new AbsensiController)->index();
    }
})->middleware('auth');
Route::get('/dashboard/reports', [DashboardController::class, 'reports'])->middleware(IsAdmins::class);
Route::get('/dashboard/myreports', [DashboardController::class, 'myreports'])->middleware('auth');
Route::get('/edit', [ProfileController::class, 'edit'])->middleware('auth');
Route::get('/admin/edit', [ProfileController::class, 'edit'])->middleware('auth');

Route::put('/dashboard/employee', [UserController::class, 'update'])->middleware('admin');
Route::get('/dashboard/divisions/sub', [DivisionController::class, 'show'])->middleware('admin');
Route::put('/dashboard/editprofile', [ProfileController::class, 'update'])->middleware('auth');

Route::get('/dashboard/absen', [DashboardController::class, 'index'])->middleware('admin');

Route::get('/dashboard/subdivisions', function () {
    return response()->json(SubDivisions::all());
})->middleware(IsAdmins::class);
Route::get('/dashboard/absen/subdivisions', function (Request $request) {

    $id = $request->query("s", 1);
    $hadir = Absensi::select("*")->join("users", 'users.id', 'absensis.user_id')->where('users.divisions_id', $id)->where("absensis.date", date("d/m/Y"))->where('absensis.status', 1)->get()->count();

    $total = User::where('divisions_id', $id)->get()->count();

    return response()->json(['hadir' => $hadir ?? 0, "total" => $total]);
})->middleware(IsAdmins::class);


Route::resource('/dashboard/absensi', AbsensiController::class)->middleware('auth');
Route::resource('/dashboard/divisions', DivisionController::class)->middleware('admin');
Route::resource('/dashboard/profile', ProfileController::class, ['parameters' => ['profile' => 'user',]])->middleware('auth');
Route::resource('/dashboard/employees', UserController::class, ['parameters' => ['employees' => 'user',]])->middleware('admin');







Route::group(['prefix' => 'super', 'middleware' => isSuperAdmin::class], function () {
    Route::get('/employees', [SuperAdminController::class, 'employees']);
    Route::get('/employee/{user}', [UserController::class, 'show']);
    Route::delete('/employees', [SuperAdminController::class, 'deleteEmployees']);


    Route::put('/admin', [SuperAdminController::class, 'updateAdmin']);
    Route::delete('/admin', [SuperAdminController::class, 'deleteAdmin']);
    Route::get("/admin", [SuperAdminController::class, 'admin']);
    Route::post("/admin", [SuperAdminController::class, 'storeAdmin']);
    Route::get("/admin/create", function () {
        $divisions = SubDivisions::all();
        $title = "Tambah admin";
        return view("superadmin.admin.create", compact("divisions", "title"));
    });
    Route::get('/subdivisions', [SubDivisionController::class, 'index']);

    Route::delete('/sub_division', [SubDivisionController::class, 'delete']);
    Route::get('/subdivisions/create', [SubDivisionController::class, 'create']);
    Route::get("/sub_division/employees", [SubDivisionController::class, 'show']);
    Route::get('/subdivisions/edit', [SubDivisionController::class, 'edit']);
    Route::resource("/divisions", DivisionController::class);
});
