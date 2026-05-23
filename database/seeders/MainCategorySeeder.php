<?php

namespace Database\Seeders;

use App\Models\MainCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MainCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $categories = [
            [
                'name' => 'Property',
            ],
            [
                'name' => 'Service',
            ],


        ];

        foreach ($categories as $category) {
            MainCategory::create($category);
        }
    }
}
