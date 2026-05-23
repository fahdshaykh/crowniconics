<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'House',
                'description' => 'Independent houses for families.',
                'status' => 1,
                'category_id' => 1
                
            ],
            [
                'name' => 'Apartment',
                'description' => 'Flats and apartments in residential complexes.',
                'status' => 1,
                'category_id' => 1

                
            ],
            [
                'name' => 'Office',
                'description' => 'Office spaces for businesses.',
                'status' => 0,
                'category_id' => 1

                
            ],

            [
                'name' => 'Installation',
                'description' => 'Independent houses for families.',
                'status' => 1,
                'category_id' => 3
                
            ],
            [
                'name' => 'Repairing',
                'description' => 'Flats and apartments in residential complexes.',
                'status' => 1,
                'category_id' => 3
            ],
        ];

        foreach ($types as $type) {
            Type::create($type);
        }
    }
}
