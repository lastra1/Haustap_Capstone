<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;

class BookingsTableSeeder extends Seeder
{
    public function run(): void
    {
        Booking::insert([
            [
                'user_id' => 2,
                'service_id' => 1,
                'service_provider_id' => 1,
                'booking_date' => now()->addDays(2),
                'status' => 'pending',
                'total_amount' => 1500.00,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
