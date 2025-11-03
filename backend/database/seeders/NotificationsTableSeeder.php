<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationsTableSeeder extends Seeder
{
    public function run(): void
    {
        Notification::insert([
            [
                'user_id' => 2,
                'title' => 'Booking Confirmed',
                'message' => 'Your booking with John’s Plumbing Services has been confirmed.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
