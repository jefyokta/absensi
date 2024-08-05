<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubDivisions;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('dashboard.division.index', [
            'title' => 'Dashboard | Add Divisions',
            'divisions' => Division::all(),
            'user' => User::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('dashboard.division.create', [
            'title' => 'Dashboard | Add Divisions',
            'divisions' => Division::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        Division::create($validatedData);
        return redirect('/dashboard/divisions')->with('success', 'Divisions have been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

        $id = $request->query('d') ?? abort(404);
        return view('dashboard.division.show', [
            'sub_divisions' => SubDivisions::select('*')->where('division_id','=',$id)->get(),
            'title' => Division::find($id)->name
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Division $division)
    {
        return view ('dashboard.division.edit', [
            'title' => 'Dashboard | Edit Divisions',
            'division' => $division,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Division $division)
    {
        $rules = [
            'name' => 'required|max:255',
        ];

        $validatedData = $request->validate($rules);

        Division::find($division->id)->update($validatedData);

        return redirect('/dashboard/divisions')->with('success', 'Divisions have been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Division $division)
    {
        Division::destroy($division->id);
        return redirect('/dashboard/divisions')->with('success', 'Division has been deleted!');
    }
}
