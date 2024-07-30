<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Division;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            [
                'name' => 'Administrator',
                'divisions_id' => mt_rand(1, 3),
                'address' => fake()->address(),
                'phonenumber' => fake()->phoneNumber(),
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin'),
                'is_admin' => '1'
            ],
            [
                'name' => 'SaumiShintia',
                'divisions_id' => mt_rand(1, 3),
                'address' => fake()->address(),
                'phonenumber' => fake()->phoneNumber(),
                'email' => 'Sintia@gmail.com',
                'password' => bcrypt('sintia123'),
                'is_admin' => true
            ],
            [
                'name' => 'Jepi Okta',
                'divisions_id' => mt_rand(1, 3),
                'address' => fake()->address(),
                'phonenumber' => fake()->phoneNumber(),
                'email' => 'jefyokta50@gmail.com',
                'password' => bcrypt('jepiokta'),
                'is_admin' => true
            ]
        ]);
        // User::create(

        // );


        User::factory(20)->create();

        Absensi::factory(10)->create();

        Division::create([
            'name' => 'Head Officer'
        ]);
        Division::create([
            'name' => 'Financial Director'
        ]);
        Division::create([
            'name' => 'Marketing Director'
        ]);
    }
}
