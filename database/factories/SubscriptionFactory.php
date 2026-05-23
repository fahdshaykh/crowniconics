<?php

namespace Database\Factories;

use App\Enums\BillingCycleEnum;
use App\Enums\SubscriptionStatusEnum;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first() ?? User::factory()->create();
        $plan = \App\Models\SubscriptionPlan::inRandomOrder()->first() ?? SubscriptionPlan::factory()->create();
        
        $billingCycle = $this->faker->randomElement(['monthly', 'yearly']);
        $amount = $billingCycle === 'monthly' ? $plan->monthly_price : $plan->yearly_price;
        
        return [
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'stripe_subscription_id' => 'sub_' . str_random(14),
            'stripe_price_id' => 'price_' . str_random(14),
            'stripe_customer_id' => 'cus_' . str_random(14),
            'billing_cycle' => $billingCycle,
            'amount' => $amount,
            'currency' => 'USD',
            'trial_ends_at' => $this->faker->optional(0.3)->dateTimeBetween('now', '+30 days'),
            'starts_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'ends_at' => $this->faker->dateTimeBetween('now', '+1 year'),
            'status' => $this->faker->randomElement(array_column(SubscriptionStatusEnum::cases(), 'value')),
            'properties_used' => $this->faker->numberBetween(0, $plan->property_listings),
            'featured_used' => $this->faker->numberBetween(0, $plan->featured_listings),
            'premium_used' => $this->faker->numberBetween(0, $plan->premium_listings),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => SubscriptionStatusEnum::ACTIVE->value,
            'ends_at' => now()->addDays(30),
        ]);
    }

    public function trialing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => SubscriptionStatusEnum::TRIALING->value,
            'trial_ends_at' => now()->addDays(14),
            'ends_at' => now()->addDays(14),
        ]);
    }

    public function canceled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => SubscriptionStatusEnum::CANCELED->value,
            'canceled_at' => now()->subDays(5),
            'ends_at' => now()->addDays(25),
        ]);
    }

    public function pastDue(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => SubscriptionStatusEnum::PAST_DUE->value,
            'ends_at' => now()->subDays(5),
        ]);
    }

    public function monthly(): static
    {
        return $this->state(fn (array $attributes) => [
            'billing_cycle' => BillingCycleEnum::MONTHLY->value,
        ]);
    }

    public function yearly(): static
    {
        return $this->state(fn (array $attributes) => [
            'billing_cycle' => BillingCycleEnum::YEARLY->value,
        ]);
    }
}