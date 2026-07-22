<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ✅ Buat akun admin (lihat AdminUserSeeder)
        $this->call(AdminUserSeeder::class);

        // ✅ Optional: buat user testing biasa (aman, email jelas)
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'password', // akan otomatis di-hash karena cast "hashed"
                'is_admin' => false,
                'email_verified_at' => now(), // biar tidak mentok verified
            ]
        );
        $this->call([
        \Database\Seeders\AdminDaftarLayananDaratSeeder::class,
    ]);

        // ✅ Optional: kalau kamu mau banyak user dummy, aktifkan ini
        // User::factory(10)->create();
    }
}
