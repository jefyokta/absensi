<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function show($filename)
    {
        $path = storage_path('app/bukti/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        $fileContent = file_get_contents($path);

        return response($fileContent, 200)->header('Content-Type', mime_content_type($path));
    }

    public function qrcode(Request $req)
    {
        $filename = $req->query('q') ?? abort(404);

        $user = User::where('qrcode', $filename,)->first();

        if ($user->id == auth()->user()->id || auth()->user()->is_admin || auth()->user()->is_superadmin) {
            $path = storage_path('app/qrcodes/' . $filename);
            if (!file_exists($path)) {
              return  abort(404);
            }
            if ($req->query('download')) {
                return  Storage::download('qrcodes/' . $filename, auth()->user()->name . '-qrcode.png');
            }
            $fileContent = file_get_contents($path);
            return response($fileContent, 200)->header('Content-Type', mime_content_type($path));
        }
        abort(401);
    }
    public function bukti(Request $request)
    {
        $filename = $request->query('q') ?? abort(404);
        $filename = explode('/',$filename)[1];
        $absen = Absensi::where('image', $filename)->first();

        if (auth()->user()->is_admin || auth()->user()->id == $absen->user_id) {
            $path = storage_path('app/bukti/' . $filename);
            if (!file_exists($path)) {
                return abort(404);
            }
            $fileContent = file_get_contents($path);
            return response($fileContent, 200)->header('Content-Type', mime_content_type($path));
        }
    }
}
