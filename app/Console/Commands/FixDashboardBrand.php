<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixDashboardBrand extends Command
{
    protected $signature = 'fix:dashboard-brand {--size=14 : Tailwind size untuk logo (contoh 14,16,20)}';
    protected $description = 'Perbesar logo dashboard (breeze/jetstream) + ganti teks Laravel jadi Mriki_Project';

    public function handle()
    {
        $size = (int) $this->option('size');
        if ($size < 10) $size = 10;
        if ($size > 32) $size = 32;

        $this->info("1) Patch komponen application-logo (ukuran logo dashboard)...");
        $this->patchApplicationLogo($size);

        $this->info("2) Ganti teks 'Laravel' jadi 'Mriki_Project' di layout navigasi dashboard...");
        $this->replaceLaravelTextInNav();

        $this->info("3) Clear cache...");
        $this->callSilent('view:clear');
        $this->callSilent('optimize:clear');

        $this->newLine();
        $this->info("SELESAI ✅");
        $this->line("Logo size: w-{$size} h-{$size}");
        return self::SUCCESS;
    }

    private function patchApplicationLogo(int $size): void
    {
        $path = resource_path('views/components/application-logo.blade.php');

        // kalau file belum ada, buatkan
        if (!File::exists($path)) {
            File::ensureDirectoryExists(dirname($path));
            File::put($path, '');
        }

        $content = <<<BLADE
<img src="{{ asset('img/logo.png') }}"
     alt="Mriki_Project"
     {{ \$attributes->merge(['class' => 'w-{$size} h-{$size} object-contain']) }}>
BLADE;

        File::put($path, $content);
        $this->line(" - updated: resources/views/components/application-logo.blade.php");
    }

    private function replaceLaravelTextInNav(): void
    {
        // File yang paling sering berisi teks "Laravel" di Breeze
        $targets = [
            resource_path('views/layouts/navigation.blade.php'),
            resource_path('views/layouts/app.blade.php'),
            resource_path('views/components/application-mark.blade.php'),
        ];

        $changed = 0;

        foreach ($targets as $path) {
            if (!File::exists($path)) continue;

            $c = File::get($path);
            $new = $c;

            // ganti teks Laravel di beberapa bentuk umum
            $new = str_replace('Laravel', 'Mriki_Project', $new);
            $new = str_replace('laravel', 'Mriki_Project', $new);

            if ($new !== $c) {
                File::put($path, $new);
                $changed++;
                $this->line(" - updated: " . str_replace(base_path() . DIRECTORY_SEPARATOR, '', $path));
            }
        }

        // fallback: scan semua views untuk string ">Laravel<" (biar aman)
        $all = collect(File::allFiles(resource_path('views')))
            ->filter(fn($f) => str_ends_with($f->getFilename(), '.blade.php'))
            ->map(fn($f) => $f->getPathname())
            ->values();

        foreach ($all as $path) {
            $c = File::get($path);
            if (!str_contains($c, 'Laravel')) continue;

            $new = str_replace('Laravel', 'Mriki_Project', $c);

            if ($new !== $c) {
                File::put($path, $new);
                $changed++;
                $this->line(" - updated (scan): " . str_replace(base_path() . DIRECTORY_SEPARATOR, '', $path));
            }
        }

        $this->line("Total file diupdate: {$changed}");
    }
}
