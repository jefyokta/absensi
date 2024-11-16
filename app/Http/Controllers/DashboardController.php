<?php

namespace App\Http\Controllers;

use App\Exports\AbsensiExport;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubDivisions;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        if (!auth()->user()->is_admin) {
            return redirect('/dashboard/absensi');
        }

        return view('dashboard.index', [
            "title" => "Dashboard",
            'active' => 'dashboard',
            'absensis' => Absensi::where('date', '=', date('d/m/Y'))->get(),
            'absensi_by_name' => Absensi::where('user_id', $user_id)->where('date', '=', date('d/m/Y'))->first(),
        ]);
    }

    public function reports(Request $req)
    {
        $absen = Absensi::select('*');
        $absensiDates = Absensi::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
        if ($req->query('start') && $req->query('end')) {
            $absen->whereBetween('date', [$req->query('start'), $req->query('end')]);
        }

        $absen = $absen->paginate(50);
        $absen->appends($req->all());

        $subdivision = SubDivisions::all();

        return view('dashboard.reports.index', [
            "title" => "Dashboard | Reports",
            'active' => 'dashboard',
            'absensis' => $absen,
            "months" => $absensiDates,
            "subdivision" => $subdivision
        ]);
    }

    public function myreports()
    {
        $user_id = auth()->user()->id;
        $absensis = Absensi::where('user_id', $user_id)->paginate(10);
        return view('dashboard.reports.myreport', ['title' => 'AbsenKu', 'absensis' => $absensis]);
    }
    public function print(Request $request)
    {
        $date = $request->input('date', date('m/Y'));

        if (auth()->user()->is_superadmin) {
            $sub = $request->input("subdivision", 1);
        } else {
            $sub = auth()->user()->divisions_id ?? $request->input("subdivision", 1);
        }

        [$month, $year] = explode('/', $date);

        $employees = User::where('divisions_id', $sub)
            ->with(['absensis' => function ($query) use ($month, $year) {
                $query->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year);
            }])
            ->get();


        $subdivision = SubDivisions::find($sub);

        $dates = collect();
        $daysInMonth = Carbon::createFromDate($year, $month)->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $carbonDate = Carbon::createFromDate($year, $month, $day);
            if (!$carbonDate->isWeekend()) {
                $dates->push($carbonDate);
            }
        }

        $pdf =  Pdf::loadView('dashboard.reports.print', compact('employees', 'dates', 'month', 'year', "subdivision"))
            ->setPaper("a4", 'landscape');

        return $pdf->download('report.pdf');
    }


    public function export(Request $request)
    {
        $date = $request->input('date', date('m/Y'));
        if (auth()->user()->is_superadmin) {
            $sub = $request->input("subdivision", 1);
        } else {
            if (!is_null(auth()->user()->divisions_id)) {

                $sub = auth()->user()->divisions_id;
            }
            $sub = $request->input("subdivision", 1);
        }
        [$month, $year] = explode('/', $date);

        $dates = collect();
        $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($year, $month, $day);
            if (!$date->isWeekend()) {
                $dates->push($date);
            }
        }

        $employees = User::where('divisions_id', $sub)->with(['absensis' => function ($query) use ($month, $year) {
            $query->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
        }])->get();
        $subdivision = SubDivisions::find($sub);

        return Excel::download(new AbsensiExport($employees, $dates, $month, $year, $subdivision), "Laporan_Absensi_{$month}_{$year}.xlsx");
    }
}
