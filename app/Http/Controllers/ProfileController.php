<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->user()->id;

        if (auth()->user()->is_admin) {
            return view('dashboard.profile.admin', [
                "title" => "Dashboard | Profile",
                'active' => 'dashboard',
                'user' => User::find($user_id)
            ]);
        }

        return view('dashboard.profile.index', [
            "title" => "Dashboard | Profile",
            'active' => 'dashboard',
            'user' => User::find($user_id)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = User::find(auth()->user()->id);
        if ($user->is_admin) {
            return view('dashboard.profile.adminEdit', [
                "title" => "Dashboard | Profile Edit",
                'user' => $user
            ]);
        } else {
            return view('dashboard.profile.adminEdit', [
                "title" => "Dashboard | Profile Edit",
                'user' => $user
            ]);
        }
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
                'address' => 'required',
                'role' => 'required',
                'phonenumber' => 'required|max:255',
                'email' => 'required|email|max:255',
                'password' => 'nullable|min:5|max:255',

            ]);
            $user = User::find($validatedData['id']);
            if (!$user) {
                return redirect()->back()->with('error', 'User Tidak Ditemukan');
            }
            if ($user->id !== auth()->user()->id) redirect()->back()->with('error', 'Forbidden');
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

            return redirect('/dashboard/profile')->with('success', 'User data has been updated!');
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
        //
    }
}
