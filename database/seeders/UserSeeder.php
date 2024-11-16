<?php

namespace Database\Seeders;

use App\Models\SubDivisions;
use App\Models\User;
use App\Services\QrCodeGen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        User::create([
            'name' => "KepalaCabang",
            'address' => fake('id_ID')->address(),
            'phonenumber' => fake('id_ID')->phoneNumber(),
            'nik' => "1234567830",
            'email' => "kepalacabang@gmail.com",
            'email_verified_at' => now(),
            'qrcode' => QrCodeGen::generate(),
            "role" => "Kepala Cabang",
            'password' => bcrypt('kpcabang'),
            "is_superadmin" => 1


        ]);
    }
}
