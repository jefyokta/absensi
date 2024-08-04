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
        return view('dashboard.profile.edit', [
            "title" => "Dashboard | Profile Edit",
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $rules = [
            'address' => 'required',
            'phonenumber' => 'required|numeric',
            'email' => 'required|email'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorMessages = $errors->all();
            $errorString = implode(', ', $errorMessages);
            return back()->with('error',$errorString);
        }
        $user = auth()->user()->id;
        User::find($user)->update([
            'address' => $request->address,
            'phonenumber' => $request->phonenumber,
            'email' => $request->email,
        ]);

        return redirect('/dashboard/profile')->with('success', 'User data has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
