<?php 
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChatMessage;

class ChatMessagesTableSeeder extends Seeder
{
    public function run(): void
    {
        ChatMessage::insert([
            [
                'chat_id' => 1,
                'sender_id' => 2,
                'message' => 'Hello, I’d like to confirm the appointment.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
