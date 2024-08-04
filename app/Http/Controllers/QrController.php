<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\User;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;

class QrController extends Controller
{
    public function masuk()
    {
        return view('dashboard.qrabsen.index', ['title' => 'masuk', 'type' => 'masuk']);
    }
    public function keluar()
    {
        return view('dashboard.qrabsen.index', ['title' => 'keluar', 'type' => 'keluar']);
    }
    public function create(Request $request)
    {
        try {

            $data = $request->validate([
                'type' => 'required|string',
                'qrcode' => 'required|string'
            ]);
            // dd($data);
            $title = $data['type'];
            $type = $data['type'];

            $user = User::where('qrcode', $data['qrcode'] . '.png')->first();
            if (!$user) {
                return back()->with('error', 'User Not Found');
            }
            $today = date('d/m/Y');
            $userabsen = Absensi::where('user_id', $user->id)->where('date', $today)->first();

            if (!is_null($userabsen)) {

                if (!$userabsen->status) {
                    $error = 'Kamu Sudah Absen Tidak Hadir Hari Ini';
                    return view('dashboard.qrabsen.index', compact('user', 'title', 'type', 'error'))->with('error', 'Kamu Sudah Absen Tidak Hadir Hari Ini');
                }
                if ($userabsen->status && empty($userabsen->out) && $data['type'] === 'keluar') {

                    $userabsen->update(['out' => date('H:i')]);
                    $success = 'Kamu berhasil absen keluar';
                    return view('dashboard.qrabsen.index', compact('user', 'title', 'type', 'success'))->with('success', 'Kamu berhasil absen keluar');
                }
                if ($userabsen->status && $data['type'] !== 'keluar') {
                    $error = 'Kamu Sudah Absen Hadir Hari Ini';

                    return view('dashboard.qrabsen.index', compact('user', 'title', 'type', 'error'))->with('error', 'Kamu Sudah Absen Hadir Hari Ini');
                }
                if ($userabsen->in && $userabsen->out && $userabsen->status) {
                    $success = 'Kamu Sudah Absen , Silahkan Pulang';
                    return view('dashboard.qrabsen.index', compact('user', 'title', 'type', 'success'))->with('success', 'Kamu Sudah Absen , Silahkan Pulang');
                }
            } else {

                if ($data['type'] === 'keluar') {
                    $error = 'Kamu belum Absen Masuk Hari Ini';

                    return view('dashboard.qrabsen.index', compact('user', 'title', 'type', 'error'))->with('error', 'Kamu belum Absen Masuk Hari Ini');
                } else {
                    Absensi::create([
                        'user_id' => $user->id,
                        'in' => date('H:i'),
                        'date' => $today,
                        'status' => true
                    ]);
                    $success = 'Kamu berhasil absen masuk';
                    return view('dashboard.qrabsen.index', compact('user', 'title', 'type', 'success'))->with('success', 'Kamu berhasil absen masuk');
                }
            }
        } catch (\Throwable $th) {
            dd($th);
            return back()->with('error', $th->getMessage());
        }
    }
}
