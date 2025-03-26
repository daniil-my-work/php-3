<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $memberRole = Role::create(['role_name' => 'Участник', 'role_value' => 'member']);
        $moderatorRole = Role::create(['role_name' => 'Модератор', 'role_value' => 'moderator']);

        $users = User::all();
        foreach($users as $user) {
            $isModerator = rand(0, 1) === 1;

            if ($isModerator) {
                $user->role()->attach($moderatorRole->id);
            }

            $user->role()->attach($memberRole->id);
        }
    }
}
