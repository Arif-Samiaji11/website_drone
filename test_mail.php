<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$users = User::latest()->take(3)->get();
echo "--- DAFTAR USER TERBARU ---\n";
foreach ($users as $user) {
    echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email} | Verified At: " . ($user->email_verified_at ?: 'BELUM VERIFIKASI') . "\n";
}
echo "---------------------------\n";
