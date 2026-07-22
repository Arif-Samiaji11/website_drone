<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class SetupPortofolio extends Command
{
    protected $signature = 'setup:portofolio {--seed : isi data contoh}';
    protected $description = 'Bikin migration portofolio kalau belum ada + migrate (full otomatis)';

    public function handle()
    {
        $models = [
            'PortofolioUdara' => 'portofolio_udaras',
            'PortofolioDarat' => 'portofolio_darats',
            'PortofolioServisDrone' => 'portofolio_servis_drones',
            'PortofolioPenjualan' => 'portofolio_penjualans',
        ];

        $this->info('1) Pastikan migration ada...');
        foreach ($models as $model => $table) {
            $this->ensureMigration($model, $table);
        }

        $this->info('2) Jalankan migrate...');
        $this->call('migrate');

        if ($this->option('seed')) {
            $this->info('3) Isi data contoh (seed ringan)...');
            $this->seedExamples();
        }

        $this->newLine();
        $this->info('SELESAI ✅ Sekarang buka: /admin/portofolio-udara');
        return self::SUCCESS;
    }

    private function ensureMigration(string $model, string $table): void
    {
        $migrationDir = database_path('migrations');
        $pattern = "create_{$table}_table";

        $exists = collect(File::files($migrationDir))
            ->contains(fn($f) => str_contains($f->getFilename(), $pattern));

        if ($exists) {
            $this->line(" - Migration {$pattern} sudah ada.");
            return;
        }

        // bikin migration baru
        $name = "create_{$table}_table";
        Artisan::call('make:migration', ['name' => $name]);
        $this->line(" - Dibuat migration: {$name}");

        // patch isi migration yang baru dibuat (ambil yang terbaru)
        $file = collect(File::files($migrationDir))
            ->sortByDesc(fn($f) => $f->getMTime())
            ->first();

        if (!$file) return;

        $path = $file->getPathname();
        $content = File::get($path);

        // pastikan schema benar (judul, deskripsi, lokasi, tanggal, cover)
        $content = preg_replace(
            '/Schema::create\([^)]+\)\s*{\s*([^}]*)}/s',
            "Schema::create('{$table}', function (Blueprint \$table) {\n".
            "            \$table->id();\n".
            "            \$table->string('judul');\n".
            "            \$table->text('deskripsi')->nullable();\n".
            "            \$table->string('lokasi')->nullable();\n".
            "            \$table->date('tanggal')->nullable();\n".
            "            \$table->string('cover')->nullable();\n".
            "            \$table->timestamps();\n".
            "        })",
            $content
        );

        // kalau regex di atas gagal (format migration beda), fallback replace id+timestamps
        $content = preg_replace(
            '/\$table->id\(\);\s*\$table->timestamps\(\);/m',
            "\$table->id();\n            \$table->string('judul');\n            \$table->text('deskripsi')->nullable();\n            \$table->string('lokasi')->nullable();\n            \$table->date('tanggal')->nullable();\n            \$table->string('cover')->nullable();\n            \$table->timestamps();",
            $content
        );

        File::put($path, $content);
    }

    private function seedExamples(): void
    {
        $examples = [
            \App\Models\PortofolioUdara::class => ['judul' => 'Contoh Portofolio Udara', 'deskripsi' => 'Contoh data', 'lokasi' => 'Jakarta', 'tanggal' => now()->toDateString(), 'cover' => null],
            \App\Models\PortofolioDarat::class => ['judul' => 'Contoh Portofolio Darat', 'deskripsi' => 'Contoh data', 'lokasi' => 'Bandung', 'tanggal' => now()->toDateString(), 'cover' => null],
            \App\Models\PortofolioServisDrone::class => ['judul' => 'Contoh Servis Drone', 'deskripsi' => 'Contoh data', 'lokasi' => 'Depok', 'tanggal' => now()->toDateString(), 'cover' => null],
            \App\Models\PortofolioPenjualan::class => ['judul' => 'Contoh Penjualan', 'deskripsi' => 'Contoh data', 'lokasi' => 'Bekasi', 'tanggal' => now()->toDateString(), 'cover' => null],
        ];

        foreach ($examples as $model => $data) {
            if (class_exists($model)) {
                $model::query()->firstOrCreate(['judul' => $data['judul']], $data);
            }
        }
    }
}
