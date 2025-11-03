<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TeamMember;

class TeamMembersTableSeeder extends Seeder
{
    public function run(): void
    {
        TeamMember::insert([
            ['service_provider_id' => 1, 'name' => 'Mike Helper'],
            ['service_provider_id' => 1, 'name' => 'Anna Support'],
        ]);
    }
}
