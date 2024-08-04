<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;


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

        if ($req->query('start') && $req->query('end')) {
            $absen->whereBetween('date', [$req->query('start'), $req->query('end')]);
        }

        $absen = $absen->paginate(50);
        $absen->appends($req->all());

        return view('dashboard.reports.index', [
            "title" => "Dashboard | Reports",
            'active' => 'dashboard',
            'absensis' => $absen,
        ]);
    }

    public function myreports()
    {
        $user_id = auth()->user()->id;
        $absensis = Absensi::where('user_id', $user_id)->paginate(10);
        return view('dashboard.reports.myreport', ['title' => 'AbsenKu', 'absensis' => $absensis]);
    }
    public function print(Request $req)
    {
        $absen = Absensi::select('*');

        if ($req->input('start') && $req->input('end')) {
            $absen->whereBetween('date', [$req->input('start'), $req->input('end')]);
        }
        $s = $req->input('start') ;
        $e = $req->input('end') ;


        $absensis = $absen->paginate(50);
        $title = 'cetak laporan';
        $pdf = Pdf::loadView('dashboard.reports.print', compact('absensis', 'title','s','e'));
        return $pdf->download('report.pdf');
    }
}
