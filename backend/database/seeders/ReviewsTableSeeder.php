<?php 
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewsTableSeeder extends Seeder
{
    public function run(): void
    {
        Review::insert([
            [
                'booking_id' => 1,
                'user_id' => 3,
                'rating' => 5,
                'comment' => 'Great service! Highly recommended.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
