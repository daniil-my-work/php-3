<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $memberRole = Role::where('role_value', 'member')->first();
        $moderatorRole = Role::where('role_value', 'moderator')->first();
        $adminRole = Role::where('role_value', 'admin')->first();

        foreach ($users as $user) {
            $randomNumber = rand(0, 2);

            if ($randomNumber === 0) {
                $user->role()->attach($memberRole);
            } elseif ($randomNumber === 1) {
                $user->role()->attach($moderatorRole);
            } else {
                $user->role()->attach($adminRole);
            }
        }
    }
}
