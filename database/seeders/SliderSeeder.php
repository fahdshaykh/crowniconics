<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Type;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Make sure categories and types exist (otherwise keep nulls)
        // $category = Category::inRandomOrder()->first();
        // $type = Type::inRandomOrder()->first();

        Slider::create([
            // 'category_id' => $category?->id,
            // 'type_id' => $type?->id,
            'title' => 'Welcome to Our Website',
            'description' => 'This is the main homepage slider showcasing our services.',
            'note' => 'This is special note',
            'image' => 'sliders/images/sample1.jpg', // keep a placeholder path in storage/app/public/sliders/images
            'status' => 1,
        ]);

        Slider::create([
            // 'category_id' => $category?->id,
            // 'type_id' => $type?->id,
            'title' => 'Exclusive Offer',
            'description' => 'Get up to 50% off on selected services!',
            'note' => 'This is extra note',
            'image' => 'sliders/images/sample2.jpg',
            'status' => 1,
        ]);
    }
}
