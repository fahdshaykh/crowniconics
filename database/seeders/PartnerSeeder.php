<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Partner;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Partner::create([
            'title' => 'Tech Corp',
            'image' => 'partners/images/partner-1.png',
            'status' => 1,
        ]);

        Partner::create([
            'title' => 'Global Solutions',
            'image' => 'partners/images/partner-2.png',
            'status' => 1,
        ]);

        Partner::create([
            'title' => 'NextGen Innovations',
            'image' => 'partners/images/partner-3.png',
            'status' => 1,
        ]);
        Partner::create([
            'title' => 'Tech Corp',
            'image' => 'partners/images/partner-4.png',
            'status' => 1,
        ]);

        Partner::create([
            'title' => 'Global Solutions',
            'image' => 'partners/images/partner-5.png',
            'status' => 1,
        ]);

        Partner::create([
            'title' => 'NextGen Innovations',
            'image' => 'partners/images/partner-6.png',
            'status' => 1,
        ]);
    }
}
