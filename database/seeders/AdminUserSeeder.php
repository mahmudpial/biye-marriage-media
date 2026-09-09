<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Primary Super Administrator
        User::updateOrCreate(
            ['email' => 'admin@biyemedia.com'],
            [
                'name' => 'Biye Media Admin',
                'password' => Hash::make('admin123456'),
                'is_admin' => true,
                'role' => User::ROLE_SUPER_ADMIN,
                'designation' => 'Principal Executive Matchmaker',
                'phone' => '+880 1577-723404',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Senior Matchmaker - Dhaka High-Society Desk
        User::updateOrCreate(
            ['email' => 'matchmaker@biyemedia.com'],
            [
                'name' => 'Shabnam Begum (Gulshan Desk)',
                'password' => Hash::make('matchmaker123'),
                'is_admin' => true,
                'role' => User::ROLE_SENIOR_MATCHMAKER,
                'designation' => 'Senior Matchmaker (Gulshan & Banani HNI)',
                'phone' => '+880 1711-223344',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Global NRB Relationship Manager
        User::updateOrCreate(
            ['email' => 'nrb.desk@biyemedia.com'],
            [
                'name' => 'Tanvir Ahmed (Global Desks)',
                'password' => Hash::make('manager123'),
                'is_admin' => true,
                'role' => User::ROLE_RELATIONSHIP_MANAGER,
                'designation' => 'Lead Relationship Manager (UK/USA/Canada NRBs)',
                'phone' => '+880 1819-556677',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
