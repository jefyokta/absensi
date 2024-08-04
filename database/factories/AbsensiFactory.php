<?php

namespace Database\Factories;

use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Absensi>
 */
class AbsensiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Absensi::class;
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'date' => Carbon::now()->format('d/m/Y'),
            'in' => fake()->date('H:i'),
            'out' => fake()->date('H:i'),
            'status' => rand(0,1)
        ];
    }
}
