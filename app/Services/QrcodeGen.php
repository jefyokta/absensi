<?php
namespace App\Services;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeGen
{


    public static function generate()
    {
        $uniq = md5(uniqid());
        $path = 'qrcodes/' . $uniq . '.png';
        $qrcode =  QrCode::format('png')->size(200)->generate($uniq);
        Storage::put($path,$qrcode);
        return $uniq.'.png';
    }
}
