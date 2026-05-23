<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\User;
use App\Models\Category;
use App\Models\Type;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Property::factory()
            ->count(20)
            ->create([
                'user_id' => 1,
            ]);

        $this->command->info('Properties seeded successfully!');
    }
}
