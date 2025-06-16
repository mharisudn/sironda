<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\RondaPeriode;

class RondaPeriodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RondaPeriode::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'is_locked' => fake()->boolean(),
            'is_active' => fake()->boolean(),
        ];
    }
}
