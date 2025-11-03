<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chat;

class ChatsTableSeeder extends Seeder
{
    public function run(): void
    {
        Chat::insert([
            [
                'booking_id' => 1,
                'user_id' => 2,
                'service_provider_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
