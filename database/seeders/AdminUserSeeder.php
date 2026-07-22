<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@mriki.com'],
            [
                'name' => 'Admin Mriki',
                'password' => Hash::make('12345678'),
                'is_admin' => true,
                'email_verified_at' => now(), // biar tidak kena verifikasi
            ]
        );
    }
}
