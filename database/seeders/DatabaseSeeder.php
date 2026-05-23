<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            MainCategorySeeder::class,
            PermissionSeeder::class,
            SubscriptionPlanSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            TypeSeeder::class,
            PropertySeeder::class,
            ServiceSeeder::class,
            ProfessionalServiceSeeder::class,
            SliderSeeder::class,
            PartnerSeeder::class,
            ContactUsSeeder::class,
            WorldSeeder::class
        ]);
    }
}
