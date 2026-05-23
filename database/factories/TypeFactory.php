<?php

namespace Database\Factories;

use App\Models\Type;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\BooleanEnum;

class TypeFactory extends Factory
{
    protected $model = Type::class;

    public function definition(): array
    {
        return [
            'name'        => $this->faker->words(2, true),
            'description' => $this->faker->optional()->sentence(),
            'status'      => BooleanEnum::TRUE,
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
        ];
    }

    /**
     * Only active types
     */
    public function active(): static
    {
        return $this->state(fn() => ['status' => BooleanEnum::TRUE]);
    }

    /**
     * Only inactive types
     */
    public function inactive(): static
    {
        return $this->state(fn() => ['status' => BooleanEnum::FALSE]);
    }
}
