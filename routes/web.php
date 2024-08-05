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
use App\Http\Controllers\UserController;

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


Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/bukti', [ImageController::class, 'bukti'])->middleware('auth');
Route::get('/qrcode', [ImageController::class, 'qrcode'])->middleware('auth');

Route::post('/dashboard/print', [DashboardController::class, 'print'])->middleware('admin');


Route::put('/dashboard/sub_division', [SubDivisionController::class, 'update'])->middleware('admin');
Route::get('/dashboard/sub_division', [SubDivisionController::class, 'index'])->middleware('admin');
Route::get('/dashboard/sub_division/employees', [SubDivisionController::class, 'show'])->middleware('admin');
Route::post('/dashboard/sub_division', [SubDivisionController::class, 'store'])->middleware('admin');
Route::delete('/dashboard/sub_division', [SubDivisionController::class, 'delete'])->middleware('admin');
Route::get('/dashboard/sub_division/create', [SubDivisionController::class, 'create'])->middleware('admin');
Route::get('/dashboard/sub_division/edit', [SubDivisionController::class, 'edit'])->middleware('admin');

Route::delete('/logout', [LoginController::class, 'logout']);
Route::get('/qrabsen/masuk', [QrController::class, 'masuk'])->middleware('admin');
Route::post('/qrabsen', [QrController::class, 'create'])->middleware('admin');
Route::get('/qrabsen/keluar', [QrController::class, 'keluar'])->middleware('admin');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard/reports', [DashboardController::class, 'reports'])->middleware('admin');
Route::get('/dashboard/myreports', [DashboardController::class, 'myreports'])->middleware('auth');
Route::get('/edit', [ProfileController::class, 'edit'])->middleware('auth');
Route::put('/dashboard/employee', [UserController::class, 'update'])->middleware('admin');
Route::get('/dashboard/divisions/sub', [DivisionController::class, 'show'])->middleware('admin');
Route::put('/dashboard/editprofile', [ProfileController::class, 'update'])->middleware('auth');
Route::resource('/dashboard/absensi', AbsensiController::class)->middleware('auth');
Route::resource('/dashboard/divisions', DivisionController::class)->middleware('admin');
Route::resource('/dashboard/profile', ProfileController::class, ['parameters' => ['profile' => 'user',]])->middleware('auth');
Route::resource('/dashboard/employees', UserController::class, ['parameters' => ['employees' => 'user',]])->middleware('admin');
