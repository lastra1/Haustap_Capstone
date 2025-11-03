<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceProvider;

class ServiceProvidersTableSeeder extends Seeder
{
    public function run(): void
    {
        ServiceProvider::insert([
            [
                'user_id' => 2,
                'company_name' => 'John’s Plumbing Services',
                'description' => 'A full-service IT company offering web and mobile app development.',
                'location' => 'Makati City, Metro Manila',
                'rating' => 4.75,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
