<?php 
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                // 'phone' => '09123456789',
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Provider User',
                'email' => 'provider@example.com',
                'password' => Hash::make('password'),
                // 'phone' => '09123456789',
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                // 'phone' => '09876543210',
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
