<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixDuplicateIsAdminMigration extends Command
{
    protected $signature = 'fix:dup-is-admin {--run-migrate : langsung lanjut migrate setelah fix}';
    protected $description = 'Auto-skip SEMUA migration add_is_admin_to_users_table yang duplikat jika kolom is_admin sudah ada';

    public function handle()
    {
        $this->info('1) Cek tabel users & kolom is_admin ...');

        if (!Schema::hasTable('users')) {
            $this->error('Tabel users tidak ada. Tidak bisa lanjut.');
            return self::FAILURE;
        }

        if (!Schema::hasColumn('users', 'is_admin')) {
            $this->warn('Kolom is_admin BELUM ada. Jadi bukan kasus duplikat. Jalankan migrate biasa.');
            return self::SUCCESS;
        }

        $this->line(' - is_admin sudah ada ✅');
        $this->newLine();

        $this->info('2) Cari semua migration file yang mengandung add_is_admin_to_users_table ...');
        $names = $this->findAllMigrationNamesLike('add_is_admin_to_users_table');

        if (empty($names)) {
            $this->warn('Tidak menemukan migration add_is_admin_to_users_table di folder migrations.');
        } else {
            $batch = (int) (DB::table('migrations')->max('batch') ?? 0);
            $batch = $batch > 0 ? $batch : 1;

            foreach ($names as $migrationName) {
                $exists = DB::table('migrations')->where('migration', $migrationName)->exists();
                if ($exists) {
                    $this->line(" - Sudah tercatat: {$migrationName}");
                    continue;
                }

                DB::table('migrations')->insert([
                    'migration' => $migrationName,
                    'batch' => $batch,
                ]);

                $this->line(" - Ditandai sukses (skip): {$migrationName}");
            }
        }

        $this->newLine();
        $this->info('3) Clear cache (biar aman) ...');
        $this->callSilent('optimize:clear');
        $this->line(' - optimize:clear done');

        if ($this->option('run-migrate')) {
            $this->newLine();
            $this->info('4) Lanjutkan migrate sampai tuntas ...');
            $this->call('migrate');
        }

        $this->newLine();
        $this->info('SELESAI ✅');
        return self::SUCCESS;
    }

    private function findAllMigrationNamesLike(string $needle): array
    {
        $dir = database_path('migrations');
        $files = glob($dir . DIRECTORY_SEPARATOR . '*_' . $needle . '.php');
        if (!$files) return [];

        return array_values(array_unique(array_map(fn($f) => basename($f, '.php'), $files)));
    }
}
