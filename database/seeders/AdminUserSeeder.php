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
        User::updateOrCreate(
            ['email' => 'admin@biyemedia.com'],
            [
                'name' => 'Biye Media Admin',
                'password' => Hash::make('admin123456'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
