<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\RondaPeriode;
use App\Models\RondaTermin;

class RondaTerminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RondaTermin::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'ronda_periode_id' => RondaPeriode::factory(),
            'name' => fake()->name(),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'max_petugas' => fake()->numberBetween(-10000, 10000),
        ];
    }
}
