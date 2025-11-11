<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    public function run()
    {
        $clients = [
            [
                'firstName' => 'Juan',
                'middleName' => 'Santos',
                'lastName' => 'Dela Cruz',
                'email' => 'juan.delacruz@email.com',
                'phone' => '09123456789',
                'address' => '123 Main Street',
                'city' => 'Manila',
                'province' => 'Metro Manila',
                'postalCode' => '1000',
                'birthDate' => '1990-01-15',
                'occupation' => 'Business Owner'
            ],
            [
                'firstName' => 'Maria',
                'middleName' => 'Garcia',
                'lastName' => 'Santos',
                'email' => 'maria.santos@email.com',
                'phone' => '09187654321',
                'address' => '456 Oak Avenue',
                'city' => 'Quezon City',
                'province' => 'Metro Manila',
                'postalCode' => '1100',
                'birthDate' => '1992-05-20',
                'occupation' => 'Engineer'
            ],
            [
                'firstName' => 'Antonio',
                'middleName' => 'Reyes',
                'lastName' => 'Mendoza',
                'email' => 'antonio.mendoza@email.com',
                'phone' => '09234567890',
                'address' => '789 Palm Street',
                'city' => 'Makati',
                'province' => 'Metro Manila',
                'postalCode' => '1200',
                'birthDate' => '1988-09-10',
                'occupation' => 'Businessman'
            ],
            [
                'firstName' => 'Rosa',
                'middleName' => 'Luna',
                'lastName' => 'Ramos',
                'email' => 'rosa.ramos@email.com',
                'phone' => '09345678901',
                'address' => '321 Pine Road',
                'city' => 'Pasig',
                'province' => 'Metro Manila',
                'postalCode' => '1600',
                'birthDate' => '1995-03-25',
                'occupation' => 'Manager'
            ],
            [
                'firstName' => 'Miguel',
                'middleName' => 'Torres',
                'lastName' => 'Aquino',
                'email' => 'miguel.aquino@email.com',
                'phone' => '09456789012',
                'address' => '567 Cedar Lane',
                'city' => 'Taguig',
                'province' => 'Metro Manila',
                'postalCode' => '1630',
                'birthDate' => '1991-07-30',
                'occupation' => 'IT Professional'
            ]
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}