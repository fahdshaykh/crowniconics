<?php

namespace Database\Seeders;

use App\Enums\SubscriptionStatusEnum;
use App\Models\Subscription;
use App\Models\User;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📊 Seeding subscriptions...');

        // Get plans and users
        $plans = SubscriptionPlan::where('is_active', true)->get();
        $users = User::whereIn('role', ['agent', 'professional', 'user'])->get();

        if ($plans->isEmpty() || $users->isEmpty()) {
            $this->command->warn('No active plans or users found. Skipping subscription seeding.');
            return;
        }

        $subscriptionsCreated = 0;

        foreach ($users as $user) {
            // 70% chance to have a subscription
            if (rand(1, 100) <= 70) {
                $plan = $plans->random();
                $billingCycle = rand(1, 100) <= 70 ? 'monthly' : 'yearly';
                $amount = $billingCycle === 'monthly' ? $plan->monthly_price : $plan->yearly_price;

                // Determine status
                $statusOptions = [
                    SubscriptionStatusEnum::ACTIVE->value => 60,
                    SubscriptionStatusEnum::TRIALING->value => 15,
                    SubscriptionStatusEnum::CANCELED->value => 10,
                    SubscriptionStatusEnum::PAST_DUE->value => 8,
                    SubscriptionStatusEnum::UNPAID->value => 5,
                    SubscriptionStatusEnum::EXPIRED->value => 2,
                ];

                $status = $this->getWeightedRandomStatus($statusOptions);

                // Calculate dates based on status
                $dates = $this->calculateSubscriptionDates($status);

                $subscription = Subscription::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'plan_id' => $plan->id,
                    ],
                    [
                        'stripe_subscription_id' => 'sub_' . Str::random(14),
                        'stripe_price_id' => 'price_' . Str::random(14),
                        'stripe_customer_id' => 'cus_' . Str::random(14),
                        'billing_cycle' => $billingCycle,
                        'amount' => $amount,
                        'currency' => 'USD',
                        'trial_ends_at' => $dates['trial_ends_at'],
                        'starts_at' => $dates['starts_at'],
                        'ends_at' => $dates['ends_at'],
                        'canceled_at' => $dates['canceled_at'],
                        'renewed_at' => $dates['renewed_at'],
                        'status' => $status,
                        'properties_used' => rand(0, $plan->property_listings),
                        'featured_used' => rand(0, $plan->featured_listings),
                        'premium_used' => rand(0, $plan->premium_listings),
                        'metadata' => [
                            'created_via' => 'seeder',
                            'plan_name' => $plan->name,
                            'user_email' => $user->email,
                        ],
                    ]
                );

                // Update user's current subscription if active
                if ($status === SubscriptionStatusEnum::ACTIVE->value || $status === SubscriptionStatusEnum::TRIALING->value) {
                    $user->update([
                        'current_subscription_id' => $subscription->id,
                        'subscription_status' => $status,
                        'subscription_expires_at' => $subscription->ends_at,
                        'properties_limit' => $plan->property_listings,
                        'featured_listings_limit' => $plan->featured_listings,
                        'premium_listings_limit' => $plan->premium_listings,
                        'storage_space_mb' => $plan->storage_space_mb,
                        'stripe_customer_id' => $subscription->stripe_customer_id,
                    ]);
                }

                $subscriptionsCreated++;
            }
        }

        // Create specific subscription scenarios for demo users
        $this->createDemoSubscriptions();

        $this->command->info("✅ {$subscriptionsCreated} subscriptions seeded successfully!");
    }

    private function getWeightedRandomStatus(array $statusOptions): string
    {
        $total = array_sum($statusOptions);
        $random = rand(1, $total);
        $current = 0;

        foreach ($statusOptions as $status => $weight) {
            $current += $weight;
            if ($random <= $current) {
                return $status;
            }
        }

        return SubscriptionStatusEnum::ACTIVE->value;
    }

    private function calculateSubscriptionDates(string $status): array
    {
        $now = now();
        $dates = [
            'trial_ends_at' => null,
            'starts_at' => null,
            'ends_at' => null,
            'canceled_at' => null,
            'renewed_at' => null,
        ];

        switch ($status) {
            case SubscriptionStatusEnum::ACTIVE->value:
                $dates['starts_at'] = $now->subDays(rand(1, 60));
                $dates['ends_at'] = $now->copy()->addDays(rand(1, 30));
                $dates['renewed_at'] = $now->subDays(rand(1, 30));
                break;

            case SubscriptionStatusEnum::TRIALING->value:
                $dates['trial_ends_at'] = $now->copy()->addDays(rand(1, 14));
                $dates['starts_at'] = $now->subDays(rand(1, 5));
                $dates['ends_at'] = $dates['trial_ends_at'];
                break;

            case SubscriptionStatusEnum::CANCELED->value:
                $dates['starts_at'] = $now->subDays(rand(31, 90));
                $dates['ends_at'] = $now->copy()->addDays(rand(1, 20));
                $dates['canceled_at'] = $now->subDays(rand(1, 10));
                break;

            case SubscriptionStatusEnum::PAST_DUE->value:
                $dates['starts_at'] = $now->subDays(rand(31, 60));
                $dates['ends_at'] = $now->subDays(rand(1, 10));
                break;

            case SubscriptionStatusEnum::UNPAID->value:
                $dates['starts_at'] = $now->subDays(rand(61, 120));
                $dates['ends_at'] = $now->subDays(rand(11, 30));
                break;

            case SubscriptionStatusEnum::EXPIRED->value:
                $dates['starts_at'] = $now->subDays(rand(91, 180));
                $dates['ends_at'] = $now->subDays(rand(31, 60));
                break;
        }

        return $dates;
    }

    private function createDemoSubscriptions(): void
    {
        $professionalPlan = SubscriptionPlan::where('slug', 'professional')->first();
        $agencyPlan = SubscriptionPlan::where('slug', 'agency')->first();
        $enterprisePlan = SubscriptionPlan::where('slug', 'enterprise')->first();

        // Agent with Professional Plan (Active)
        $agent = User::where('email', 'agent@example.com')->first();
        if ($agent && $professionalPlan) {
            Subscription::updateOrCreate(
                ['user_id' => $agent->id],
                [
                    'plan_id' => $professionalPlan->id,
                    'stripe_subscription_id' => 'sub_agentdemo123',
                    'stripe_price_id' => 'price_agentdemo123',
                    'stripe_customer_id' => 'cus_agentdemo123',
                    'billing_cycle' => 'monthly',
                    'amount' => $professionalPlan->monthly_price,
                    'currency' => 'USD',
                    'starts_at' => now()->subDays(45),
                    'ends_at' => now()->addDays(15),
                    'renewed_at' => now()->subDays(15),
                    'status' => SubscriptionStatusEnum::ACTIVE->value,
                    'properties_used' => 12,
                    'featured_used' => 3,
                    'premium_used' => 1,
                    'metadata' => ['demo_account' => true],
                ]
            );
        }

        // Professional with Agency Plan (Active)
        $professional = User::where('email', 'professional@example.com')->first();
        if ($professional && $agencyPlan) {
            Subscription::updateOrCreate(
                ['user_id' => $professional->id],
                [
                    'plan_id' => $agencyPlan->id,
                    'stripe_subscription_id' => 'sub_prodemo123',
                    'stripe_price_id' => 'price_prodemo123',
                    'stripe_customer_id' => 'cus_prodemo123',
                    'billing_cycle' => 'yearly',
                    'amount' => $agencyPlan->yearly_price,
                    'currency' => 'USD',
                    'starts_at' => now()->subDays(90),
                    'ends_at' => now()->addDays(275),
                    'renewed_at' => now()->subDays(90),
                    'status' => SubscriptionStatusEnum::ACTIVE->value,
                    'properties_used' => 4,
                    'featured_used' => 1,
                    'premium_used' => 0,
                    'metadata' => ['demo_account' => true],
                ]
            );
        }

        // User with Starter Plan (Free)
        $user = User::where('email', 'user@example.com')->first();
        if ($user) {
            // Free plan - no subscription record needed
            $user->update([
                'subscription_status' => null,
                'properties_limit' => 3,
                'featured_listings_limit' => 0,
                'premium_listings_limit' => 0,
                'storage_space_mb' => 100,
            ]);
        }
    }
}