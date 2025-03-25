<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Role::factory()->create();

        Role::create(['role_name' => 'Участник', 'role_value' => 'member']);
        Role::create(['role_name' => 'Модератор', 'role_value' => 'moderator']);
        Role::create(['role_name' => 'Админ', 'role_value' => 'admin']);
    }
}
