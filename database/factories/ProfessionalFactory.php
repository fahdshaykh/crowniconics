<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Professional>
 */
class ProfessionalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'country_id' => Country::inRandomOrder()->value('id'),
            'state_id'   => State::inRandomOrder()->value('id'),
            'city_id'    => City::inRandomOrder()->value('id'),
        ];
    }
}
