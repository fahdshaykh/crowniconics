<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\User;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;
use App\Enums\BooleanEnum;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition()
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'type_id'     => Type::inRandomOrder()->first()->id ?? Type::factory(),
            'user_id'     => User::inRandomOrder()->first()->id ?? User::factory(),

            'title'       => $this->faker->sentence(4),
            'slug'        => $this->faker->unique()->slug(),
            'meta_title'  => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(),
            'status'      => $this->faker->randomElement(['draft', 'available', 'sold', 'rented', 'active', 'inactive', 'approved', 'rejected']),

            'country_id'     => 167,//$this->faker->randomElement(Country::pluck('id')),
            'state_id'       => 3052, //$this->faker->randomElement(State::pluck('id')),
            'city_id'        => 80454, //$this->faker->randomElement(City::pluck('id')),
            'zip_code'    => $this->faker->postcode(),
            'address'     => $this->faker->address(),
            'price'       => $this->faker->randomFloat(2, 50000, 5000000),
            'currency'    => $this->faker->randomElement(['USD', 'EUR', 'GBP', 'PKR']),
            'reference_number' => strtoupper(Str::random(10)),

            'price_type'  => $this->faker->randomElement(['fixed', 'negotiable', 'per_month']),
            'beds'        => $this->faker->numberBetween(1, 10),
            'bathrooms'   => $this->faker->numberBetween(1, 6),
            'area_sqft'   => $this->faker->numberBetween(500, 10000),
            'parking'     => $this->faker->numberBetween(0, 5),

            // 'featured_image' => $this->faker->imageUrl(800, 600, 'house', true),
            'images'         => json_encode([$this->faker->imageUrl(800, 600, 'house', true), $this->faker->imageUrl(800, 600, 'house', true)]),
            'features'       => implode(', ', $this->faker->randomElements([
                'Swimming Pool',
                'Gym',
                'Balcony',
                'Garden',
                'Security',
                'Play Area'
            ], 3)),
        ];
    }
}
