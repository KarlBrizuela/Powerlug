<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Super Admin
        User::create([
            'name' => 'superadmin',
            'firstName' => 'Super',
            'middleName' => '',
            'lastName' => 'Admin',
            'email' => 'superadmin@powerlug.com',
            'password' => Hash::make('password123'),
            'position' => 'superadmin',
        ]);

        // Create Admin
        User::create([
            'name' => 'admin',
            'firstName' => 'System',
            'middleName' => '',
            'lastName' => 'Admin',
            'email' => 'admin@powerlug.com',
            'password' => Hash::make('password123'),
            'position' => 'admin',
        ]);
    }
}