<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $usersData = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '1234567890',
                'user_type' => 'provider_individual',
                'receive_notifications_from' => 'both',
                'password' => Hash::make('password123'),
                'profile_picture' => 'public/users/pfps/pfp-00.jpg',
                'path' => 'public/users/documents/doc-0.pdf',
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '2345678901',
                'user_type' => 'provider_society',
                'receive_notifications_from' => 'renter_individual',
                'password' => Hash::make('password123'),
                'profile_picture' => 'public/users/pfps/pfp-01.jpg',
                'path' => 'public/users/documents/doc-1.pdf',
            ],
            [
                'first_name' => 'Alice',
                'last_name' => 'Johnson',
                'email' => 'alice.johnson@example.com',
                'phone' => '3456789012',
                'user_type' => 'renter_individual',
                'receive_notifications_from' => 'none',
                'password' => Hash::make('password123'),
                'profile_picture' => 'public/users/pfps/pfp-02.jpg',
                'path' => 'public/users/documents/doc-2.pdf',
            ],
            [
                'first_name' => 'Bob',
                'last_name' => 'Brown',
                'email' => 'bob.brown@example.com',
                'phone' => '4567890123',
                'user_type' => 'renter_society',
                'receive_notifications_from' => 'none',
                'password' => Hash::make('password123'),
                'profile_picture' => 'public/users/pfps/pfp-03.jpg',
                'path' => 'public/users/documents/doc-3.pdf',
            ],
            [
                'first_name' => 'Charlie',
                'last_name' => 'Davis',
                'email' => 'charlie.davis@example.com',
                'phone' => '5678901234',
                'user_type' => 'provider_individual',
                'receive_notifications_from' => 'both',
                'password' => Hash::make('password123'),
                'profile_picture' => 'public/users/pfps/pfp-04.jpg',
                'path' => 'public/users/documents/doc-4.pdf',
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Miller',
                'email' => 'david.miller@example.com',
                'phone' => '6789012345',
                'user_type' => 'provider_society',
                'receive_notifications_from' => 'renter_individual',
                'password' => Hash::make('password123'),
                'profile_picture' => 'public/users/pfps/pfp-05.jpg',
                'path' => 'public/users/documents/doc-5.pdf',
            ],
            [
                'first_name' => 'Eve',
                'last_name' => 'Wilson',
                'email' => 'eve.wilson@example.com',
                'phone' => '7890123456',
                'user_type' => 'renter_individual',
                'receive_notifications_from' => 'none',
                'password' => Hash::make('password123'),
                'profile_picture' => 'public/users/pfps/pfp-06.jpg',
                'path' => 'public/users/documents/doc-6.pdf',
            ],
            [
                'first_name' => 'Frank',
                'last_name' => 'Moore',
                'email' => 'frank.moore@example.com',
                'phone' => '8901234567',
                'user_type' => 'renter_society',
                'receive_notifications_from' => 'none',
                'password' => Hash::make('password123'),
                'profile_picture' => 'public/users/pfps/pfp-07.jpg',
                'path' => 'public/users/documents/doc-7.pdf',
            ],
            [
                'first_name' => 'Grace',
                'last_name' => 'Taylor',
                'email' => 'grace.taylor@example.com',
                'phone' => '9012345678',
                'user_type' => 'provider_individual',
                'receive_notifications_from' => 'both',
                'password' => Hash::make('password123'),
                'profile_picture' => 'public/users/pfps/pfp-08.jpg',
                'path' => 'public/users/documents/doc-8.pdf',
            ],
            [
                'first_name' => 'Hank',
                'last_name' => 'Anderson',
                'email' => 'hank.anderson@example.com',
                'phone' => '0123456789',
                'user_type' => 'provider_society',
                'receive_notifications_from' => 'renter_individual',
                'password' => Hash::make('password123'),
                'profile_picture' => 'public/users/pfps/pfp-09.jpg',
                'path' => 'public/users/documents/doc-9.pdf',
            ],
        ];

        foreach ($usersData as $userData) {

            $user = User::create([
                'first_name' => $userData['first_name'],
                'last_name' => $userData['last_name'],
                'email' => $userData['email'],
                'phone' => $userData['phone'],
                'user_type' => $userData['user_type'],
                'receive_notifications_from' => $userData['receive_notifications_from'],
                'password' => $userData['password'],
                'profile_picture' => $userData['profile_picture'],
            ]);

            $user->documents()->create(['path' => $userData['path']]);
        }
    }
}
