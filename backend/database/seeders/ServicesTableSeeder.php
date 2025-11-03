<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ServicesTableSeeder extends Seeder
{
    public function run(): void
    {
       $now = Carbon::now();

        $services = [
            // 🧹 Cleaning
            [
                'service_category_id' => 1,
                'service_provider_id' => 1,
                'service_name' => 'House Cleaning',
                'description' => 'Full home cleaning including floors, windows, and furniture.',
                'price' => 1200.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'service_category_id' => 1,
                'service_provider_id' => 1,
                'service_name' => 'Office Cleaning',
                'description' => 'Professional office cleaning for a spotless workspace.',
                'price' => 2000.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 💻 Tech
            [
                'service_category_id' => 2,
                'service_provider_id' => 1,
                'service_name' => 'Computer Repair',
                'description' => 'Fixing common PC and laptop issues quickly and efficiently.',
                'price' => 1800.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'service_category_id' => 2,
                'service_provider_id' => 1,
                'service_name' => 'Network Setup',
                'description' => 'Home and office network setup with secure configurations.',
                'price' => 2500.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 🔧 Repair
            [
                'service_category_id' => 3,
                'service_provider_id' => 1,
                'service_name' => 'Pipe Leak Repair',
                'description' => 'Quick and reliable repair of leaking water pipes.',
                'price' => 1500.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'service_category_id' => 3,
                'service_provider_id' => 1,
                'service_name' => 'Appliance Repair',
                'description' => 'Repair services for home and office appliances.',
                'price' => 1700.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 🌿 Outdoor
            [
                'service_category_id' => 4,
                'service_provider_id' => 1,
                'service_name' => 'Garden Maintenance',
                'description' => 'Trimming, mowing, and garden beautification services.',
                'price' => 1300.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'service_category_id' => 4,
                'service_provider_id' => 1,
                'service_name' => 'Outdoor Cleaning',
                'description' => 'Driveway and exterior wall pressure washing.',
                'price' => 1400.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 💆 Wellness
            [
                'service_category_id' => 5,
                'service_provider_id' => 1,
                'service_name' => 'Home Massage',
                'description' => 'Relaxing home massage service by certified therapists.',
                'price' => 2000.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'service_category_id' => 5,
                'service_provider_id' => 1,
                'service_name' => 'Yoga Session',
                'description' => 'Personalized home yoga session for beginners and pros.',
                'price' => 1800.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('services')->insert($services);
    }
}
