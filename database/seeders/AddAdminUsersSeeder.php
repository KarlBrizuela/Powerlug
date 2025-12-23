<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AddAdminUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin User 2
        User::firstOrCreate(
            ['email' => 'admin2@powerlug.com'],
            [
                'name' => 'Admin Two',
                'firstName' => 'Admin',
                'middleName' => '',
                'lastName' => 'Two',
                'email' => 'admin2@powerlug.com',
                'password' => Hash::make('123456789'),
                'position' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Admin User 3
        User::firstOrCreate(
            ['email' => 'admin3@powerlug.com'],
            [
                'name' => 'Admin Three',
                'firstName' => 'Admin',
                'middleName' => '',
                'lastName' => 'Three',
                'email' => 'admin3@powerlug.com',
                'password' => Hash::make('123456789'),
                'position' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin users created successfully!');
        $this->command->line('✓ admin2@powerlug.com / 123456789');
        $this->command->line('✓ admin3@powerlug.com / 123456789');
    }
}
