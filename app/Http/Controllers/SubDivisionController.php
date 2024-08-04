<?php

namespace App\Http\Controllers;

use App\Models\SubDivisions;
use Illuminate\Http\Request;


use App\Models\Division;
use App\Models\User;

class SubDivisionController extends Controller
{

    public function index()
    {
        return view('dashboard.subdivision.index', [
            'sub_divisions' => SubDivisions::all(),
            'title' => 'sub division'
        ]);
    }
    public function create()
    {

        return view('dashboard.subdivision.create', [
            'title' => 'Dashboard | Add Divisions',
            'divisions' => Division::all()
        ]);
    }
    public function store(Request $request)
    {
        try {
            $v = $request->validate([
                'name' => 'required|max:255',
                'division_id' => 'nullable'
            ]);
            if (!$v['division_id'] || !is_int($v['division_id'])) {
                $v['division_id'] = null;
            }
            SubDivisions::create($v);

            return redirect('/dashboard/sub_division')->with('success', 'Divisions have been added!');
        } catch (\Throwable $th) {
            return redirect('/dashboard/sub_division')->with('error', $th->getMessage());
        }
    }
    public function edit(Request $req)
    {
        if (!$req->query('id')) return abort(404);
        $id = $req->query('id');
        $s =  SubDivisions::find($id);
        if (!$s) return abort(404);

        return view('dashboard.subdivision.edit', [
            'title' => 'Dashboard | Edit Divisions',
            'sub_division' => $s,
            'divisions' => Division::all()

        ]);
    }
    public function update(Request $request)
    {

        try {
            $rules = [
                "id" => "required",
                'name' => 'required|max:255',
            ];

            $validatedData = $request->validate($rules);

            SubDivisions::find($validatedData['id'])->update($validatedData);

            return redirect('/dashboard/sub_division')->with('success', 'Divisions have been updated!');
        } catch (\Throwable $th) {
            return redirect('/dashboard/sub_division')->with('error', $th->getMessage());
        }
    }
    public function delete(Request $req)
    {
        $id = $req->input('id') ?? redirect('/dashboard/sub_division')->with('error', 'oops, id not found');
        try {
            SubDivisions::find($id)->delete();
            return   redirect('/dashboard/sub_division')->with('success', 'deleted');
        } catch (\Throwable $th) {
            return redirect('/dashboard/sub_division')->with('error', 'oops, Something Wrong, try again later');
        }
    }
    public function show(Request $request)
    {

        $id = $request->query('sd') ?? abort(404);
        return view('dashboard.subdivision.show', [
            'title' => 'Dashboard | Empolyees',
            'divisions' => SubDivisions::find($id) ?? abort(404),
            'users' => $users = User::where('divisions_id', $id)->get()
        ]);
    }
}
