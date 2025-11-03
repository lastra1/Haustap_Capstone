<?php 
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentsTableSeeder extends Seeder
{
    public function run(): void
    {
        Payment::insert([
            [
                'booking_id' => 1,
                'amount' => 1500.00,
                'payment_method' => 'Cash',
                'status' => 'paid',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
