<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class QrController extends Controller
{
    public function masuk()
    {
        $isSelfmasuk = Absensi::where('user_id', auth()->user()->id)->where('date', date('d/m/Y'))->whereNotNull('in')->get()->count() > 0 ? true : false;
        $employees = $this->userIn();
        return view('dashboard.qrabsen.index', ['title' => 'masuk', 'type' => 'masuk', 'users' => $employees , 'isSelfmasuk'=>$isSelfmasuk]);
    }
    public function keluar()
    {
        $today = date('d/m/Y');

        $employees = $this->userOut();
        return view('dashboard.qrabsen.index', [
            'title' => 'keluar',
            'type' => 'keluar',
            'users' => $employees
        ]);
    }

    public function create(Request $request)
    {
        try {

            $data = $request->validate([
                'type' => 'required|string',
                'qrcode' => 'required|string'
            ]);
            $title = $data['type'];
            $type = $data['type'];
            $users = $type === 'masuk' ? $this->userIn() : $this->userOut();

            $qrcode = explode('.', $data['qrcode']);
            if (end($qrcode) === "png") {
                $qrcode = $qrcode[0];
            } else {
                $qrcode = $data['qrcode'];
            }
            $user = User::where('qrcode', $qrcode . '.png')->first();
            if (!$user) {
                return back()->with('error', 'User Tidak ditemukan');
            }
            if ($user->divisions_id !== auth()->user()->divisions_id) {
                return back()->with('error', "Kamu Salah Tempat Absen, ini buat divisi " . auth()->user()->division . " :D");
            }
            $today = date('d/m/Y');
            $userabsen = Absensi::where('user_id', $user->id)->where('date', $today)->first();

            if (!is_null($userabsen)) {

                if (!$userabsen->status) {
                    $error = 'Kamu Sudah Absen Tidak Hadir Hari Ini';
                    return view('dashboard.qrabsen.index', compact('user', 'title', 'type', 'users', 'error'))->with('error', 'Kamu Sudah Absen Tidak Hadir Hari Ini');
                }
                if ($userabsen->status && empty($userabsen->out) && $data['type'] === 'keluar') {

                    $userabsen->update(['out' => date('H:i')]);
                    $success = 'Kamu berhasil absen keluar';
                    return view('dashboard.qrabsen.index', compact('user', 'title', 'type', 'users', 'success'))->with('success', 'Kamu berhasil absen keluar');
                }
                if ($userabsen->status && $data['type'] !== 'keluar') {
                    $error = 'Kamu Sudah Absen Hadir Hari Ini';

                    return view('dashboard.qrabsen.index', compact('user', 'title', 'type', 'users', 'error'))->with('error', 'Kamu Sudah Absen Hadir Hari Ini');
                }
                if ($userabsen->in && $userabsen->out && $userabsen->status) {
                    $success = 'Kamu Sudah Absen , Silahkan Pulang';
                    return view('dashboard.qrabsen.index', compact('user', 'title', 'type', 'users', 'success'))->with('success', 'Kamu Sudah Absen , Silahkan Pulang');
                }
            } else {

                if ($data['type'] === 'keluar') {
                    $error = 'Kamu belum Absen Masuk Hari Ini';

                    return view('dashboard.qrabsen.index', compact('user', 'title', 'type', 'users', 'error'))->with('error', 'Kamu belum Absen Masuk Hari Ini');
                } else {
                    Absensi::create([
                        'user_id' => $user->id,
                        'in' => date('H:i'),
                        'date' => $today,
                        'status' => true
                    ]);
                    $success = 'Kamu berhasil absen masuk';
                    return view('dashboard.qrabsen.index', compact('user', 'title', 'type', 'users', 'success'))->with('success', 'Kamu berhasil absen masuk');
                }
            }
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    private function userOut(): Collection
    {

        $today = date('d/m/Y');

        return User::where('divisions_id', auth()->user()->divisions_id)
            ->whereHas('absensis', function ($query) use ($today) {
                $query->whereNull('out')
                    ->whereNotNull('in')->where('status', 1)
                    ->where('date', $today);
            })->get();
    }

    private function userIn(): Collection
    {
        $today = date('d/m/Y');
        return   User::whereDoesntHave('absensis', function ($query) use ($today) {
            $query->where('date', $today);
        })->where('divisions_id', auth()->user()->divisions_id)->get();
    }
}
