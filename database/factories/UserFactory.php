<?php

namespace Database\Factories;

use App\Models\Division;
use App\Models\SubDivisions;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\User;
use FakerFactory;
use App\Services\QrCodeGen;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $name = fake()->name();
        $email = fake()->unique()->safeEmail();


        return [
            'name' => $name,
            'divisions_id' => SubDivisions::all()->random()->id,
            'address' => fake('id_ID')->address(),
            'phonenumber' => fake('id_ID')->phoneNumber(),
            'nik' => $this->faker->unique()->regexify('[1-9]{2}[0-9]{4}[0-4][0-9][0-1][0-9][7-9][0-9][0-9]{4}'),
            'email' => $email,
            'email_verified_at' => now(),
            'qrcode' => QrCodeGen::generate(),
            "role" => fake()->jobTitle(),
            'password' => bcrypt('karyawan'), // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
