<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );

        $admin->syncRoles(['admin']);

        $hr = User::updateOrCreate(
            ['email' => 'hr@example.com'],
            [
                'name' => 'HR User',
                'password' => Hash::make('password'),
            ]
        );

        $hr->syncRoles(['hr']);

        $staff = User::updateOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name' => 'Staff User',
                'password' => Hash::make('password'),
            ]
        );

        $staff->syncRoles(['staff']);
    }
}