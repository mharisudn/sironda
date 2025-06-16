<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\PollingCode;
use App\Models\PollingSubmission;
use App\Models\RondaTermin;

class PollingSubmissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PollingSubmission::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'polling_code_id' => PollingCode::factory(),
            'ronda_termin_id' => RondaTermin::factory(),
            'submitted_at' => fake()->dateTime(),
        ];
    }
}
