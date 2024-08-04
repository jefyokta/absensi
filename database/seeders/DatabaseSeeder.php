<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Division;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        DB::table('sub_divisions')->insert([
            "name" => "Staf Kantor dan Gudang",
        ]);
        DB::table('sub_divisions')->insert([
            "name" => "Satpam",
        ]);
        DB::table('sub_divisions')->insert([
            "name" => "Traksi",
        ]);
        DB::table('sub_divisions')->insert([
            "name" => "Civil Engineering",
        ]);
        DB::table('sub_divisions')->insert([
            "name" => "Bengkel",
        ]);
        DB::table('sub_divisions')->insert([
            "name" => "Bibit E38",
        ]);
        $div = Division::create(["name" => "TP 1"]);
        DB::table('sub_divisions')->insert([
            [
                "name" => "Divisi 1",
                "division_id" => $div->id
            ],
            [
                "name" => "Divisi 2",
                "division_id" => $div->id
            ],
            [
                "name" => "Divisi 3",
                "division_id" => $div->id
            ]
        ]);
        $div = Division::create(["name" => "TP 2"]);
        DB::table('sub_divisions')->insert([
            [
                "name" => "Divisi 4",
                "division_id" => $div->id
            ],
            [
                "name" => "Divisi 5",
                "division_id" => $div->id
            ],
            [
                "name" => "Divisi 6",
                "division_id" => $div->id
            ],
        ]);
        $div = Division::create(["name" => "TP 3"]);
        DB::table('sub_divisions')->insert([
            [
                "name" => "Divisi 7",
                "division_id" => $div->id
            ],
            [
                "name" => "Divisi 8",
                "division_id" => $div->id
            ],
            [
                "name" => "Divisi 9",
                "division_id" => $div->id
            ],
        ]);
        $div = Division::create(["name" => "TP 4"]);
        DB::table('sub_divisions')->insert([
            [
                "name" => "Divisi 10",
                "division_id" => $div->id
            ],
            [
                "name" => "Divisi 11",
                "division_id" => $div->id
            ],
            [
                "name" => "Divisi 12",
                "division_id" => $div->id
            ],
        ]);
        $div = Division::create(["name" => "TP 5"]);
        DB::table('sub_divisions')->insert([
            [
                "name" => "Divisi 13",
                "division_id" => $div->id
            ],
            [
                "name" => "Divisi 14",
                "division_id" => $div->id
            ],
            [
                "name" => "Divisi 15",
                "division_id" => $div->id
            ],
            [
                "name" => "Divisi 16",
                "division_id" => $div->id
            ],
        ]);
        $div = Division::create(["name" => "TP 6"]);
        DB::table('sub_divisions')->insert([
            [
                "name" => "Divisi 17",
                "division_id" => $div->id
            ],
            [
                "name" => "Divisi 18",
                "division_id" => $div->id
            ],
            [
                "name" => "Divisi 19",
                "division_id" => $div->id
            ],
            [
                "name" => "Divisi 20",
                "division_id" => $div->id
            ],
        ]);



        DB::table('users')->insert([
            [
                'name' => 'Administrator',
                'address' => fake('id_ID')->address(),
                'phonenumber' => fake('id_ID')->phoneNumber(),
                'email' => 'admin@gmail.com',
                'qrcode' => 'admin@gmail.com',

                'password' => bcrypt('admin'),
                'is_admin' => '1'
            ],
            [
                'name' => 'SaumiShintia',
                'address' => fake('id_ID')->address(),
                'phonenumber' => fake('id_ID')->phoneNumber(),
                'email' => 'Sintia@gmail.com',
                'qrcode' => 'Sintia@gmail.com',
                'password' => bcrypt('sintia123'),
                'is_admin' => true
            ],
            [
                'name' => 'Jepi Okta',
                'address' => fake('id_ID')->address(),
                'phonenumber' => fake('id_ID')->phoneNumber(),
                'email' => 'jefyokta50@gmail.com',
                'qrcode' => 'jefyokta50@gmail.com',
                'password' => bcrypt('jepiokta'),
                'is_admin' => true
            ]
        ]);

        User::factory(20)->create();

        Absensi::factory(10)->create();
    }
}
