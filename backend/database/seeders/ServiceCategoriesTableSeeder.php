<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;

class ServiceCategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        ServiceCategory::insert([
            ['name' => 'Cleaning', 'description' => 'Residential and office cleaning'],
            ['name' => 'Tech', 'description' => 'Tech support and IT services'],
            ['name' => 'Repair', 'description' => 'Extermination and prevention services'],
            ['name' => 'Outdoor', 'description' => 'Outdoor cleaning and maintenance services'],
            ['name' => 'Wellness', 'description' => 'Residential and office wellness services'],
        ]);
    }
}
