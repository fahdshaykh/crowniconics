<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        // First, create specific predefined plans
        $predefinedPlans = [
            [
                'name' => 'Free',
                'slug' => 'free',
                'description' => 'Perfect for getting started with basic features',
                'monthly_price' => 0.00,
                'yearly_price' => 0.00,
                'currency' => 'KES',
                'property_listings' => 3,
                'featured_listings' => 0,
                'premium_listings' => 0,
                'analytics' => false,
                'trial_days' => 0,
                'billing_cycle_days' => 30,
                'auto_renew' => true,
                'is_active' => true,
                'is_popular' => false,
                'sort_order' => 0,
            ],
            [
                'name' => 'Basic',
                'slug' => 'basic',
                'description' => 'Ideal for individual agents and small businesses',
                'monthly_price' => 19.99,
                'yearly_price' => 199.99,
                'currency' => 'KES',
                'property_listings' => 10,
                'featured_listings' => 2,
                'premium_listings' => 0,
                'analytics' => false,
                'trial_days' => 7,
                'billing_cycle_days' => 30,
                'auto_renew' => true,
                'is_active' => true,
                'is_popular' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'Advanced features for growing real estate professionals',
                'monthly_price' => 49.99,
                'yearly_price' => 499.99,
                'currency' => 'KES',
                'property_listings' => 50,
                'featured_listings' => 10,
                'premium_listings' => 5,
                'analytics' => true,
                'trial_days' => 14,
                'billing_cycle_days' => 30,
                'auto_renew' => true,
                'is_active' => true,
                'is_popular' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'Complete solution for large agencies and teams',
                'monthly_price' => 99.99,
                'yearly_price' => 999.99,
                'currency' => 'KES',
                'property_listings' => 200,
                'featured_listings' => 50,
                'premium_listings' => 20,
                'analytics' => true,
                'trial_days' => 30,
                'billing_cycle_days' => 30,
                'auto_renew' => true,
                'is_active' => true,
                'is_popular' => false,
                'sort_order' => 3,
            ]
        ];

        foreach ($predefinedPlans as $plan) {
            SubscriptionPlan::firstOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }

        // Create additional random plans with unique names
        $usedNames = ['Free', 'Basic', 'Professional', 'Enterprise'];
        $availableNames = ['Starter', 'Business', 'Premium', 'Agency', 'Corporate', 'Elite', 'Ultimate'];
        
        $randomNames = array_diff($availableNames, $usedNames);
        
        foreach (array_slice($randomNames, 0, 4) as $name) {
            SubscriptionPlan::factory()->create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }

        // Create some inactive plans with unique names
        $inactiveNames = ['Legacy', 'Archived'];
        foreach ($inactiveNames as $name) {
            SubscriptionPlan::factory()->inactive()->create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }

        $this->command->info('Subscription plans seeded successfully!');
        $this->command->info('Total plans created: ' . SubscriptionPlan::count());
        
        $this->displayPlansTable();
    }

    private function displayPlansTable(): void
    {
        $plans = SubscriptionPlan::orderBy('sort_order')->get(['name', 'slug', 'monthly_price', 'property_listings', 'is_active', 'is_popular']);

        $this->command->table(
            ['Name', 'Slug', 'Monthly', 'Listings', 'Active', 'Popular'],
            $plans->map(function ($plan) {
                return [
                    $plan->name,
                    $plan->slug,
                    '$' . number_format($plan->monthly_price, 2),
                    $plan->property_listings,
                    $plan->is_active ? '✅ Yes' : '❌ No',
                    $plan->is_popular ? '⭐ Yes' : 'No',
                ];
            })
        );
    }
}