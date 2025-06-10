<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $recruiter_role = Role::create([
            'name' => 'recruiter',
            'can_create_job' => true,
            'can_apply_job' => false
        ]);

        $jobseeker_role = Role::create([
            'name' => 'jobseeker',
            'can_create_job' => false,
            'can_apply_job' => true
        ]);

        User::create([
            'name' => 'RECRUITER',
            'role_id' => $recruiter_role->id,
            'username' => 'recruiter',
            'email' => 'recruiter@example.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'jobseeker',
            'username' => 'jobseeker',
            'role_id' => $jobseeker_role->id,
            'email' => 'jobseeker@example.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
