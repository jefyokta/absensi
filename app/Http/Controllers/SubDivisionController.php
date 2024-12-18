<?php

namespace App\Http\Controllers;

use App\Exports\EmployeesExport;
use App\Models\SubDivisions;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Division;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

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
        $user = User::where('divisions_id', $id);
        if ($request->query('search') ?? false) {
            $user = $user->where('name', 'like', "%" . $request->query('search') . "%");
        }
        return view('dashboard.subdivision.show', [
            'title' => 'Dashboard | Empolyees',
            'divisions' => SubDivisions::find($id) ?? abort(404),
            'users' => $user->paginate(20)->withQueryString()
        ]);
    }


    public function print(Request $request)
    {
        $id = auth()->user()->division_id ?? $request->query('sd') ?? abort(404);
        $users = User::where('divisions_id', $id)->get();
        $sub = SubDivisions::find($id);
        $subdivision = $sub->name;
        $pdf =   Pdf::loadView("dashboard.subdivision.print", compact("users", "subdivision"));
        return $pdf->download("employees-$subdivision.pdf");
    }

    public function export(Request $request)
    {
        $id = auth()->user()->division_id ?? $request->query('sd') ?? abort(404);
        $users = User::select("name", "nik",  "role", "phonenumber")->where('divisions_id', $id)->get();
        $sub = SubDivisions::find($id);
        $subdivision = $sub->name;

        $x = new EmployeesExport($users, "Karyawan di $subdivision");

        return Excel::download($x, $subdivision . ".xlsx");
    }

    public function mydivision()
    {
        $id = auth()->user()->id;

        $user = User::find($id);
        $title = $user->division->name;
        $users = User::where("divisions_id", auth()->user()->divisions_id)->paginate(20)->withQueryString();
        $divisions = $user->division;

        return view("dashboard.subdivision.mydivision", compact("users", "divisions", "title"));
    }
}
