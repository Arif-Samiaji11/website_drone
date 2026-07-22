<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ForcePortofolioTables extends Command
{
    protected $signature = 'force:portofolio-tables';
    protected $description = 'Pastikan 4 tabel portofolio benar-benar ada (auto buat migration + migrate + cek DB)';

    public function handle()
    {
        $tables = [
            'portofolio_udaras',
            'portofolio_darats',
            'portofolio_servis_drones',
            'portofolio_penjualans',
        ];

        $this->info('DB yang dipakai:');
        $this->line(' - DB_CONNECTION: ' . config('database.default'));
        $this->line(' - DB_DATABASE  : ' . config('database.connections.'.config('database.default').'.database'));
        $this->newLine();

        $this->info('1) Cek tabel...');
        $missing = [];
        foreach ($tables as $t) {
            if (!$this->tableExists($t)) {
                $missing[] = $t;
                $this->line(" - ❌ {$t} belum ada");
            } else {
                $this->line(" - ✅ {$t} sudah ada");
            }
        }

        if (empty($missing)) {
            $this->info('Semua tabel sudah ada ✅');
            return self::SUCCESS;
        }

        $this->newLine();
        $this->warn('2) Ada tabel yang hilang, buat migration FIX (nama tabel dipaksa benar)...');

        foreach ($missing as $t) {
            $this->ensureFixedMigrationFor($t);
        }

        $this->newLine();
        $this->info('3) Jalankan migrate...');
        $this->call('migrate');

        $this->newLine();
        $this->info('4) Verifikasi lagi...');
        $stillMissing = [];
        foreach ($tables as $t) {
            if (!$this->tableExists($t)) {
                $stillMissing[] = $t;
                $this->line(" - ❌ {$t} masih belum ada");
            } else {
                $this->line(" - ✅ {$t} OK");
            }
        }

        if (!empty($stillMissing)) {
            $this->newLine();
            $this->error('MASIH ADA YANG HILANG. Ini diagnosa otomatis:');
            $this->line(' - Coba jalankan: php artisan migrate:status');
            $this->line(' - Pastikan .env DB_DATABASE benar dan tidak tercache: php artisan config:clear');
            return self::FAILURE;
        }

        $this->newLine();
        $this->info('SELESAI ✅ Semua tabel sudah dibuat.');
        return self::SUCCESS;
    }

    private function tableExists(string $table): bool
    {
        try {
            // cara paling aman di mysql
            $db = config('database.connections.'.config('database.default').'.database');
            $res = DB::selectOne(
                "SELECT COUNT(*) AS c
                 FROM information_schema.tables
                 WHERE table_schema = ? AND table_name = ?",
                [$db, $table]
            );
            return ((int)($res->c ?? 0)) > 0;
        } catch (\Throwable $e) {
            // fallback
            try {
                return DB::getSchemaBuilder()->hasTable($table);
            } catch (\Throwable $e2) {
                return false;
            }
        }
    }

    private function ensureFixedMigrationFor(string $table): void
    {
        $migrationDir = database_path('migrations');
        $name = "force_create_{$table}_table";

        // kalau sudah ada migration force-nya, skip
        $exists = collect(File::files($migrationDir))
            ->contains(fn($f) => str_contains($f->getFilename(), $name));

        if ($exists) {
            $this->line(" - Migration force untuk {$table} sudah ada");
            return;
        }

        Artisan::call('make:migration', ['name' => $name]);
        $this->line(" - Dibuat migration: {$name}");

        // ambil file migration terbaru
        $file = collect(File::files($migrationDir))
            ->sortByDesc(fn($f) => $f->getMTime())
            ->first();

        if (!$file) return;

        $path = $file->getPathname();

        $fixed = <<<PHP
<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('{$table}')) {
            Schema::create('{$table}', function (Blueprint \$table) {
                \$table->id();
                \$table->string('judul');
                \$table->text('deskripsi')->nullable();
                \$table->string('lokasi')->nullable();
                \$table->date('tanggal')->nullable();
                \$table->string('cover')->nullable();
                \$table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('{$table}');
    }
};
PHP;

        File::put($path, $fixed);
    }
}
