<?php

namespace Database\Factories;

use App\Enums\BooleanEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionPlanFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->randomElement(['Basic', 'Professional', 'Enterprise', 'Agency', 'Business', 'Premium']);
        
        return [
            'name' => $name,
            'slug' => strtolower($name),
            'description' => $this->faker->sentence(10),
            'monthly_price' => $this->faker->randomElement([0, 19.99, 49.99, 79.99, 99.99]),
            'yearly_price' => $this->faker->randomElement([0, 199.99, 499.99, 799.99, 999.99]),
            'currency' => 'KES',
            'property_listings' => $this->faker->randomElement([5, 20, 50, 100, 200]),
            'featured_listings' => $this->faker->randomElement([1, 5, 10, 20, 50]),
            'premium_listings' => $this->faker->randomElement([0, 2, 5, 10, 20]),
            'analytics' => $this->faker->boolean(60),
            'trial_days' => $this->faker->randomElement([0, 7, 14, 30]),
            'billing_cycle_days' => 30,
            'auto_renew' => $this->faker->boolean(80),
            'is_active' => BooleanEnum::TRUE->value,
            'is_popular' => $this->faker->boolean(20),
            'sort_order' => $this->faker->numberBetween(1, 10),
        ];
    }

    public function basic(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Basic',
            'slug' => 'basic',
            'monthly_price' => 19.99,
            'yearly_price' => 199.99,
            'property_listings' => 10,
            'featured_listings' => 2,
            'premium_listings' => 0,
            'analytics' => false,
            'trial_days' => 7,
            'is_popular' => false,
            'sort_order' => 1,
        ]);
    }

    public function professional(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Professional',
            'slug' => 'professional',
            'monthly_price' => 49.99,
            'yearly_price' => 499.99,
            'property_listings' => 50,
            'featured_listings' => 10,
            'premium_listings' => 5,
            'analytics' => true,
            'trial_days' => 14,
            'is_popular' => BooleanEnum::TRUE->value,
            'sort_order' => 2,
        ]);
    }

    public function enterprise(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Enterprise',
            'slug' => 'enterprise',
            'monthly_price' => 99.99,
            'yearly_price' => 999.99,
            'property_listings' => 200,
            'featured_listings' => 50,
            'premium_listings' => 20,
            'analytics' => true,
            'trial_days' => 30,
            'is_popular' => false,
            'sort_order' => 3,
        ]);
    }

    public function free(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Free',
            'slug' => 'free',
            'monthly_price' => 0.00,
            'yearly_price' => 0.00,
            'property_listings' => 3,
            'featured_listings' => 0,
            'premium_listings' => 0,
            'analytics' => false,
            'trial_days' => 0,
            'is_popular' => false,
            'sort_order' => 0,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => BooleanEnum::FALSE->value,
        ]);
    }

    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_popular' => BooleanEnum::TRUE->value,
        ]);
    }
}