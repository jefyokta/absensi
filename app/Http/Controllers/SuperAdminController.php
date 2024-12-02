<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\QrCodeGen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuperAdminController extends Controller
{
    public function employees()
    {

        $users = User::where('is_superadmin', null)->paginate(20);
        $title = "Karyawan";
        return view("superadmin.employees.index", compact("users", "title"));
    }



    public function updateAdmin(Request $request)
    {
        try {

            $data = $request->validate(['id' => 'required']);
            $userid = $data['id'];

            $user =  User::findOrfail($userid);

            if (!$user->is_admin) {
                $user->update(['is_admin' => 1]);
                return back()->with('success', 'Berhasil Menjadikan Admin');
            } else {
                return back()->with('error', "User sudah jadi admin");
            }
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function storeAdmin(Request $request)
    {

        $val = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'divisions_id' => 'nullable|max:255',
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

            $data = $request->all();
            $data['password'] = bcrypt($data['password']);
            $data['is_admin'] = 1;
            $data['qrcode'] = QrCodeGen::generate();


            User::create($data);

            return redirect("/super/admin")->with("success", "Berhasil menambahkan admin");
        } catch (\Exception $e) {
            return back()->with("error", "" . $e->getMessage());
        }
    }

    public function deleteAdmin(Request $request)
    {
        try {

            $data = $request->validate(['id' => 'required']);
            $userid = $data['id'];

            $user =  User::findOrfail($userid);

            if ($user->is_admin) {
                $user->update(['is_admin' => null]);
                return back()->with('success', 'Berhasil Mencopot Admin');
            } else {
                return back()->with('error', "User Bukan admin");
            }
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    public function admin()
    {

        $users = User::where('is_admin', 1)->get();
        $title = "Admin";
        return view("superadmin.admin.index", compact("users", "title"));
    }

    public function deleteEmployees(Request $request)
    {
        try {

            $data = $request->validate(['id' => 'required']);
            $userid = $data['id'];

            $user =  User::findOrfail($userid);
            User::destroy($user->id);

            return back()->with('success', "berhasil menghapus user");
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }


    public function editEmployee(Request $request) {}


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
