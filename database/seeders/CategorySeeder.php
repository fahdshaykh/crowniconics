<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Sell',
                'description' => 'Residential properties like houses, flats, and apartments.',
                'status' => 1,
                'main_category_id' => 1
            ],
            [
                'name' => 'Rent',
                'description' => 'Commercial spaces like shops, offices, and plazas.',
                'status' => 1,
                'main_category_id' => 1
            ],
            [
                'name' => 'Electrical Work',
                'description' => 'Electrical Work for living purposes.',
                'status' => 1,
                'main_category_id' => 2
            ],

        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
