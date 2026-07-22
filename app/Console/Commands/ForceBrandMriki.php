<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ForceBrandMriki extends Command
{
    protected $signature = 'force:brand-mriki {--size=24 : Tailwind size (contoh 20,24,28,32)}';
    protected $description = 'FULL OTOMATIS: ganti Laravel -> Mriki_Project + perbesar semua logo asset(img/logo.png) jadi extra gede';

    public function handle()
    {
        $size = (int) $this->option('size');
        if ($size < 12) $size = 12;
        if ($size > 48) $size = 48;

        $this->info("Target brand: Mriki_Project | logo size: w-{$size} h-{$size}");

        $this->info("1) Paksa APP_NAME di .env jadi Mriki_Project...");
        $this->setEnvValue('APP_NAME', 'Mriki_Project');

        $this->info("2) Paksa config/app.php default name jadi Mriki_Project...");
        $this->patchConfigAppName();

        $this->info("3) Paksa komponen logo (application-logo & application-mark) jadi logo kamu + extra gede...");
        $this->writeLogoComponents($size);

        $this->info("4) Replace semua teks 'Laravel' di views jadi 'Mriki_Project'...");
        $this->replaceLaravelTextEverywhere();

        $this->info("5) Perbesar semua <img src=\"{{ asset('img/logo.png') }}\"> di views jadi extra gede...");
        $this->resizeAllLogoImgs($size);

        $this->info("6) Clear cache (config/view/optimize)...");
        $this->callSilent('optimize:clear');
        $this->callSilent('config:clear');
        $this->callSilent('view:clear');

        $this->newLine();
        $this->info("SELESAI ✅");
        $this->line("Jika masih kurang gede: jalankan lagi -> php artisan force:brand-mriki --size=32");
        return self::SUCCESS;
    }

    private function setEnvValue(string $key, string $value): void
    {
        $envPath = base_path('.env');
        if (!File::exists($envPath)) {
            $this->warn(".env tidak ditemukan");
            return;
        }

        $env = File::get($envPath);

        // Quote jika ada spasi/simbol
        $needsQuote = preg_match('/\s|#|=/', $value);
        $val = $needsQuote ? "\"{$value}\"" : $value;

        if (preg_match("/^{$key}=.*/m", $env)) {
            $env = preg_replace("/^{$key}=.*/m", "{$key}={$val}", $env);
        } else {
            $env .= "\n{$key}={$val}\n";
        }

        File::put($envPath, $env);
        $this->line(" - .env updated: {$key}={$value}");
    }

    private function patchConfigAppName(): void
    {
        $path = config_path('app.php');
        if (!File::exists($path)) {
            $this->warn("config/app.php tidak ditemukan");
            return;
        }

        $c = File::get($path);

        // Ganti value 'name' => env('APP_NAME', 'Laravel'),
        $c2 = preg_replace(
            "/'name'\s*=>\s*env\('APP_NAME',\s*'[^']*'\s*\)\s*,/m",
            "'name' => env('APP_NAME', 'Mriki_Project'),",
            $c
        );

        // Fallback kalau pola beda
        if ($c2 === $c) {
            $c2 = str_replace("env('APP_NAME', 'Laravel')", "env('APP_NAME', 'Mriki_Project')", $c2);
        }

        File::put($path, $c2);
        $this->line(" - config/app.php patched");
    }

    private function writeLogoComponents(int $size): void
    {
        File::ensureDirectoryExists(resource_path('views/components'));

        // application-logo
        File::put(
            resource_path('views/components/application-logo.blade.php'),
            <<<BLADE
<img src="{{ asset('img/logo.png') }}"
     alt="Mriki_Project"
     {{ \$attributes->merge(['class' => 'w-{$size} h-{$size} object-contain']) }}>
BLADE
        );

        // application-mark (kadang dipakai Jetstream)
        File::put(
            resource_path('views/components/application-mark.blade.php'),
            <<<BLADE
<img src="{{ asset('img/logo.png') }}"
     alt="Mriki_Project"
     {{ \$attributes->merge(['class' => 'w-{$size} h-{$size} object-contain']) }}>
BLADE
        );

        $this->line(" - components updated: application-logo & application-mark");
    }

    private function replaceLaravelTextEverywhere(): void
    {
        $paths = collect(File::allFiles(resource_path('views')))
            ->filter(fn($f) => str_ends_with($f->getFilename(), '.blade.php'))
            ->map(fn($f) => $f->getPathname())
            ->values();

        $count = 0;

        foreach ($paths as $path) {
            $c = File::get($path);
            if (!str_contains($c, 'Laravel') && !str_contains($c, 'laravel')) continue;

            // Replace beberapa variasi
            $new = str_replace(['Laravel', 'laravel'], ['Mriki_Project', 'Mriki_Project'], $c);

            if ($new !== $c) {
                File::put($path, $new);
                $count++;
            }
        }

        $this->line(" - views updated (Laravel->Mriki_Project): {$count} file");
    }

    private function resizeAllLogoImgs(int $size): void
    {
        $paths = collect(File::allFiles(resource_path('views')))
            ->filter(fn($f) => str_ends_with($f->getFilename(), '.blade.php'))
            ->map(fn($f) => $f->getPathname())
            ->values();

        $changed = 0;

        foreach ($paths as $path) {
            $c = File::get($path);

            // hanya file yang ada logo asset ini
            if (!str_contains($c, "asset('img/logo.png')") && !str_contains($c, 'asset("img/logo.png")')) {
                continue;
            }

            $new = $c;

            // 1) kalau ada class w-xx h-xx object-contain → paksa ke ukuran baru
            $new = preg_replace(
                '/class="([^"]*)\bw-\d+\s+h-\d+\b([^"]*)object-contain([^"]*)"/m',
                'class="$1w-'.$size.' h-'.$size.'$2object-contain$3"',
                $new
            );

            // 2) kalau belum ada w/h, tapi ada object-contain → tambahkan
            $new = preg_replace(
                '/(<img[^>]*asset\([\'"]img\/logo\.png[\'"]\)[^>]*class=")([^"]*object-contain[^"]*)(")/m',
                '$1w-'.$size.' h-'.$size.' $2$3',
                $new
            );

            // 3) kalau img logo tidak punya class sama sekali → tambahkan class
            $new = preg_replace(
                '/<img([^>]*asset\([\'"]img\/logo\.png[\'"]\)[^>]*)>/m',
                '<img$1 class="w-'.$size.' h-'.$size.' object-contain">',
                $new
            );

            if ($new !== $c) {
                File::put($path, $new);
                $changed++;
            }
        }

        $this->line(" - logo resized in views: {$changed} file");
    }
}
