<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProfessionalServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $services = Service::where('id', 1)->get();
        $professionals = User::where('role', 'professional')->get();

        foreach ($services as $service) {
            // attach 2-5 random professionals to each service
            // $randomProfessionals = $professionals->random(rand(2, 5));

            foreach ($professionals as $professional) {
                DB::table('professional_service')->insert([
                    'service_id' => $service->id,
                    'professional_id' => $professional->id,
                    'personal_information' => $faker->text(100),
                    'experience_years' => rand(1, 15),
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
