<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\PollingCode;
use App\Models\RondaSchedule;
use App\Models\RondaTermin;

class RondaScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RondaSchedule::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'ronda_termin_id' => RondaTermin::factory(),
            'polling_code_id' => PollingCode::factory(),
            'shift' => fake()->randomElement(["malam","siang"]),
            'is_leader' => fake()->boolean(),
        ];
    }
}
