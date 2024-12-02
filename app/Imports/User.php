<?php

namespace App\Imports;

use App\Services\QrCodeGen;
use Illuminate\Support\Str;
use App\Models\User as ModelsUser;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithStartRow;

class User implements ToModel, WithStartRow,WithProgressBar
{
    use Importable;

    public function model(array $row)
    {
        $faker = fake('id_ID');

        return new ModelsUser([
            'name' => Str::ucfirst($row[2]),
            'nik' =>  $row[1],
            'address' => 'Teluk Panji',
            'phonenumber' => '62' . $faker->numerify('8#########'),
            'email' => $this->cek($row),
            'qrcode' => QrCodeGen::generate(),
            'password' => Hash::make('karyawan'),
            'divisions_id' => $row[3],
            "role" => $row[5]
        ]);
    }

    public function cek($row)
    {
       return str_replace(' ', '', Str::lower($row[1]))."@gmail.com";
    }

    public function startRow(): int
    {
        return 2;
    }

}
