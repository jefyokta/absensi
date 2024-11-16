<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absensi;
use App\Models\Division;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubDivisions;
use App\Services\QrCodeGen;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $users = User::select('users.*')->where('is_superadmin', null);
        if (auth()->user()->divisions_id) {
            $users = $users->where('divisions_id', auth()->user()->divisions_id);
        }


        $q = $request->query('search');
        if ($q) {
            $users->where('name', 'like', '%' . $q . '%');
        }
        $users = $users->get();
        return view('dashboard.employee.index', [
            'title' => 'Dashboard | Empolyees',
            'divisions' => SubDivisions::all(),
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.employee.create', [
            'title' => 'Dashboard | Add Empolyees',
            'divisions' => SubDivisions::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $val =    Validator::make($request->all(), [
            'name' => 'required|max:255',
            'divisions_id' => 'required|max:255',
            'address' => 'required',
            'phonenumber' => 'required|unique:users|max:255',
            'email' => 'required|unique:users|email|max:255',
            'password' => 'required|min:5|max:255|confirmed',
            "role" => "nullable",
            "nik" => "required|unique:users|max:12"
        ], [
            'name.required' => 'Nama harus diisi.',
            'address.required' => 'Alamat harus diisi.',
            'phonenumber.required' => 'Nomor telepon harus diisi.',
            'phonenumber.unique' => 'Nomor telepon sudah digunakan.',
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.confirmed' => 'Password konfirmasi tidak sesuai.',
            'nik.required' => 'NIK harus diisi.',
            'nik.unique' => 'NIK sudah digunakan.',
            "nik.max" => "NIK tidak boleh lebih dari 12 karakter"

        ]);
        if ($val->fails()) {
            return back()->withErrors($val)->withInput();
        }
        try {
            $validatedData = $request->all();
            $validatedData['phonenumber'] = $this->parsePhoneNumber($validatedData['phonenumber']);
            if (!$validatedData['phonenumber']) {
                return back()->with('error', 'nomor telepon harus dimulai dengan 0 atau 62');
            }
            $validatedData['qrcode'] = QrCodeGen::generate();
            $validatedData['password'] = Hash::make($request->input('password'));

            User::create($validatedData);

            return redirect('/dashboard/employees')->with('success', 'Users have been added!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

        if (auth()->user()->is_superadmin) {
            return view('dashboard.profile.index', [
                "title" => "Dashboard | $user->name",
                'active' => 'dashboard',
                'user' => $user
            ]);
        }

        if ($user->is_admin) {
            if (auth()->user()->id !== $user->id) {
                return back()->with('error', "Kamu gabisa Melihat detail admin lain");
            }
        }


        return view('dashboard.profile.index', [
            "title" => "Dashboard | $user->name",
            'active' => 'dashboard',
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('dashboard.employee.edit', [
            'title' => 'Dashboard | Edit Empolyees',
            'divisions' => SubDivisions::all(),
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {


        $userid = $request->input('id') ?? back()->with('error', "Kamu mau update siapa?");
        $val =   Validator::make($request->all(), [
            'name' => 'required|max:255',
            'divisions_id' => 'required|max:255',
            'address' => 'required',
            'phonenumber' => 'required|unique:users,phonenumber,' . $userid . '|max:255',
            'email' => 'required|unique:users,email,' . $userid . '|email|max:255',
            'password' => 'required|min:5|max:255|confirmed',
            "role" => "nullable",
            "nik" => 'required|unique:users,nik,' . $userid . '|max:12',
            "id" => "required"
        ], [
            'name.required' => 'Nama harus diisi.',
            'address.required' => 'Alamat harus diisi.',
            'phonenumber.required' => 'Nomor telepon harus diisi.',
            'phonenumber.unique' => 'Nomor telepon sudah digunakan.',
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.confirmed' => 'Password konfirmasi tidak sesuai.',
            'nik.required' => 'NIK harus diisi.',
            'nik.unique' => 'NIK sudah digunakan.',
            "nik.max" => "NIK tidak boleh lebih dari 12 karakter"

        ]);
        try {
            $validatedData = $request->all();

            $validatedData['phonenumber'] = $this->parsePhoneNumber($validatedData['phonenumber']);
            if (!$validatedData['phonenumber']) {
                return back()->with('error', 'nomor telepon harus dimulai dengan 0 atau 62');
            }

            $user = User::findOrFail($validatedData['id']);

            if ($user->is_admin || $user->is_superadmin) {
                if (auth()->user()->id !== $user->id || !auth()->user()->is_superadmin) {
                    return back()->with('error', "Kamu gabisa update admin lain");
                }
            }

            $u = User::where('email', $validatedData['email'])->first();

            if ($u && $u->id !== $user->id) {
                return redirect()->back()->with('error', 'Email Sudah Dipakai');
            }

            $a = User::where('phonenumber', $validatedData['phonenumber'])->first();
            if ($a && $a->id !== $user->id) {
                return redirect()->back()->with('error', 'Nomor Hp Sudah Dipakai');
            }

            if (is_null($validatedData['password']) || $validatedData['password'] === '') {
                $validatedData['password'] = $user->password;
            } else {
                $validatedData['password'] = bcrypt($validatedData['password']);
            }

            $user->update($validatedData);

            if (auth()->user()->is_admin && auth()->user()->divisions_id) {
                return redirect('/dashboard/mydivision')->with('success', 'User data has been updated!');
            } else {
                return redirect('/dashboard/employees')->with('success', 'User data has been updated!');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan, silakan coba lagi.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {

        if ($user->is_admin || $user->is_superadmin) {
            return back()->with('error', "kamu gabisa ngehapus admin!");
        }
        User::destroy($user->id);

        return redirect('/dashboard/employees')->with('success', 'User has been deleted!');
    }

    private function parsePhoneNumber($phonenumber): string|false
    {


        if (str_starts_with($phonenumber, '62')) {
            if (str_contains($phonenumber, ' ')) {
                $phonenumber = str_replace(' ', '', $phonenumber);
            }
            return $phonenumber;
        } elseif (str_starts_with($phonenumber, '0')) {

            if (str_contains($phonenumber, ' ')) {
                $phonenumber = str_replace(' ', '', $phonenumber);
            }
            return '62' . substr($phonenumber, 1);
        }

        return false;
    }
}
