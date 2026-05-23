<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name'        => $this->faker->words(2, true),
            'description' => $this->faker->optional()->sentence(),
            'status'      => $this->faker->boolean(), // true / false
            'parent_id'   => null, // root by default
        ];
    }

    /**
     * Indicate that the category has a parent.
     */
    public function withParent(?Category $parent = null): static
    {
        return $this->state(fn() => [
            'parent_id' => $parent?->id ?? Category::factory(),
        ]);
    }

    /**
     * Only active categories.
     */
    public function active(): static
    {
        return $this->state(fn() => ['status' => true]);
    }

    /**
     * Only inactive categories.
     */
    public function inactive(): static
    {
        return $this->state(fn() => ['status' => false]);
    }
}
