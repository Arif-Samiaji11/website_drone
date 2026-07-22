<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ForceUseLogoEverywhere extends Command
{
    protected $signature = 'force:logo';
    protected $description = 'Pasang logo {{ asset("img/logo.png") }} untuk favicon + navbar + sidebar (ganti ikon rumah/SVG)';

    public function handle()
    {
        $this->info("1) Cari & pasang favicon ke layout yang ada...");
        $this->injectFaviconIntoLayouts();

        $this->info("2) Ganti ikon rumah/SVG menjadi logo di file view yang relevan...");
        $this->replaceSvgWithLogoInViews();

        $this->info("3) Clear cache view & optimize...");
        $this->callSilent('view:clear');
        $this->callSilent('optimize:clear');

        $this->newLine();
        $this->info("SELESAI ✅");
        $this->line("Logo yang dipakai: {{ asset('img/logo.png') }}");
        return self::SUCCESS;
    }

    private function injectFaviconIntoLayouts(): void
    {
        // Cari semua blade yang kemungkinan layout
        $paths = collect(File::allFiles(resource_path('views')))
            ->filter(fn($f) => str_ends_with($f->getFilename(), '.blade.php'))
            ->map(fn($f) => $f->getPathname())
            ->values();

        foreach ($paths as $path) {
            $c = File::get($path);

            // hanya file yang ada <head> dan belum ada favicon yang kita pasang
            if (!str_contains($c, '<head') || str_contains($c, "rel=\"icon\"") || str_contains($c, "rel='icon'")) {
                continue;
            }

            // inject setelah <head> atau setelah <meta charset>
            $favicon = "\n  <link rel=\"icon\" type=\"image/png\" href=\"{{ asset('img/logo.png') }}\">\n";

            if (preg_match('/<meta\s+charset=.*?>/i', $c)) {
                $c = preg_replace('/(<meta\s+charset=.*?>)/i', "$1{$favicon}", $c, 1);
            } else {
                $c = preg_replace('/<head[^>]*>/i', "$0{$favicon}", $c, 1);
            }

            File::put($path, $c);
            $this->line(" - favicon injected: " . str_replace(base_path() . DIRECTORY_SEPARATOR, '', $path));
        }
    }

    private function replaceSvgWithLogoInViews(): void
    {
        $logoImg = <<<BLADE
<img src="{{ asset('img/logo.png') }}" alt="Mriki Project" class="w-10 h-10 object-contain">
BLADE;

        $paths = collect(File::allFiles(resource_path('views')))
            ->filter(fn($f) => str_ends_with($f->getFilename(), '.blade.php'))
            ->map(fn($f) => $f->getPathname())
            ->values();

        foreach ($paths as $path) {
            $c = File::get($path);

            // Heuristik: hanya file yang mengandung SVG brand/logo (biar gak ganggu svg lain)
            // biasanya ada "Mriki", "Admin", atau kelas "bg-gradient-to-br" atau "w-10 h-10 rounded-xl"
            $isLikelyBrandArea =
                str_contains($c, 'Mriki') ||
                str_contains($c, 'Control Panel') ||
                str_contains($c, 'bg-gradient-to-br') ||
                str_contains($c, 'w-10 h-10 rounded-xl');

            if (!$isLikelyBrandArea) continue;

            // Ganti blok brand icon yang biasanya:
            // <div class="w-10 h-10 ..."> <svg ...>...</svg> </div>
            $pattern = '/<div[^>]*class="[^"]*w-10\s+h-10[^"]*"[^>]*>\s*<svg[\s\S]*?<\/svg>\s*<\/div>/m';

            $new = preg_replace($pattern, $logoImg, $c, 1, $count);

            // Kalau tidak ketemu pattern, coba pattern yang lebih fleksibel (ada rounded-xl)
            if ($count === 0) {
                $pattern2 = '/<div[^>]*class="[^"]*rounded-xl[^"]*"[^>]*>\s*<svg[\s\S]*?<\/svg>\s*<\/div>/m';
                $new = preg_replace($pattern2, $logoImg, $c, 1, $count2);
                if ($count2 > 0) {
                    File::put($path, $new);
                    $this->line(" - brand svg replaced: " . str_replace(base_path() . DIRECTORY_SEPARATOR, '', $path));
                }
                continue;
            }

            if ($count > 0) {
                File::put($path, $new);
                $this->line(" - brand svg replaced: " . str_replace(base_path() . DIRECTORY_SEPARATOR, '', $path));
            }
        }
    }
}
