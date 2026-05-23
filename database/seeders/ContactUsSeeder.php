<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            DB::table('contact_us')->insert([
            [
                'title' => 'Head Office',
                'description' => 'You can reach our main office for general inquiries and partnerships.',
                'phone' => '+92 300 1234567',
                'email' => 'info@example.com',
                'address' => '123 Main Street, Karachi, Pakistan',
                'image' => 'contact/head-office.jpg',
                'status' => 1,
            ],
        ]);
    }
}
