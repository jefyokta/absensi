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

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $q = User::join('divisions', 'users.divisions_id', '=', 'divisions.id')
            ->join('sub_divisions', 'sub_divisions.id', '=', 'users.divisions_id')
            ->select('users.*', 'divisions.name as division_name', 'sub_divisions.name as sub_division_name');
        if ($request->query('div') ?? false) {
            # code...
        }

        $users = $q->get();
        return view('dashboard.employee.index', [
            'title' => 'Dashboard | Add Empolyees',
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
        try {

            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'divisions_id' => 'required|max:255',
                'address' => 'required',
                'phonenumber' => 'required|unique:users|max:255',
                'email' => 'required|unique:users|email|max:255',
                'password' => 'required|min:5|max:255',
                'confirmpassword' => 'required|min:5|max:255',

            ]);
            // dd($validatedData);

            if ($validatedData['password'] !== $validatedData['confirmpassword']) {
                return back()->with('error', 'Password Does`nt Match');

                # code...
            }
            $validatedData['qrcode'] = QrCodeGen::generate();
            $validatedData['password'] = Hash::make($request->input('password'));

            User::create($validatedData);

            return redirect('/dashboard/employees')->with('success', 'Users have been added!');
            //code...
        } catch (\Throwable $th) {
            // dd($th);
            return back()->with('error', $th->getMessage());
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

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
        try {
            $validatedData = $request->validate([
                'id' => "required",
                'name' => 'required|max:255',
                'divisions_id' => 'required|max:255',
                'address' => 'required',
                'phonenumber' => 'required|max:255',
                'email' => 'required|email|max:255',
                'password' => 'nullable|min:5|max:255',

            ]);
            $user = User::find($validatedData['id']);
            if (!$user) {
                return redirect()->back()->with('error', 'User Tidak Ditemukan');
            }
            $u = User::where('email', $validatedData['email'])->first();

            // dd($u->email && $u->id !== $user->id);
            if ($u->email && $u->id !== $user->id) {
                return redirect()->back()->with('error', 'Email Sudah DiPakai');
            }
            $a = User::where('phonenumber', $validatedData['phonenumber'])->first();
            if ($a->phonenumber && $a->id !== $user->id) {
                return redirect()->back()->with('error', 'Nomor Hp Sudah DiPakai');
            }


            if (is_null($validatedData['password']) || $validatedData['password'] === '') {
                $validatedData['password'] = $user->password;
            } else {
                $validatedData['password'] = Hash::make($validatedData['password']);
            }

            User::find($user->id)->update($validatedData);

            return redirect('/dashboard/employees')->with('success', 'User data has been updated!');
        } catch (\Throwable $th) {
            // dd($th);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect('/dashboard/employees')->with('success', 'User has been deleted!');
    }
}
