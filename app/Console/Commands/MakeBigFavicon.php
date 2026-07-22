<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeBigFavicon extends Command
{
    protected $signature = 'make:big-favicon';
    protected $description = 'Bikin favicon besar & tajam dari public/img/logo.png (khusus tab browser), tanpa mengubah logo lain';

    public function handle()
    {
        $src = public_path('img/logo.png');
        if (!File::exists($src)) {
            $this->error("File tidak ditemukan: {$src}");
            return self::FAILURE;
        }

        $this->info("1) Generate favicon PNG besar (256x256)...");
        $out = public_path('favicon-256.png');
        $this->resizePng($src, $out, 256, 256);

        $this->info("2) Update semua layout blade agar pakai favicon-256.png...");
        $this->replaceFaviconLinks();

        $this->info("3) Clear cache...");
        $this->callSilent('view:clear');
        $this->callSilent('optimize:clear');

        $this->newLine();
        $this->info("SELESAI ✅");
        $this->line("Cek: http://127.0.0.1:8000/favicon-256.png");
        $this->line("Hard refresh tab: Ctrl+Shift+R (favicon sering cache)");
        return self::SUCCESS;
    }

    private function resizePng(string $src, string $out, int $w, int $h): void
    {
        // pakai GD extension (umumnya ada di PHP)
        $img = @imagecreatefrompng($src);
        if (!$img) {
            // kalau png kamu ternyata bukan png valid / transparan aneh
            $this->error("Gagal baca PNG. Pastikan file valid PNG: {$src}");
            exit(1);
        }

        $dst = imagecreatetruecolor($w, $h);

        // preserve alpha transparency
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
        imagefilledrectangle($dst, 0, 0, $w, $h, $transparent);

        imagecopyresampled($dst, $img, 0, 0, 0, 0, $w, $h, imagesx($img), imagesy($img));

        imagepng($dst, $out);

        imagedestroy($img);
        imagedestroy($dst);

        $this->line(" - created: public/favicon-256.png");
    }

    private function replaceFaviconLinks(): void
    {
        $paths = collect(File::allFiles(resource_path('views')))
            ->filter(fn($f) => str_ends_with($f->getFilename(), '.blade.php'))
            ->map(fn($f) => $f->getPathname())
            ->values();

        $changed = 0;

        foreach ($paths as $path) {
            $c = File::get($path);

            if (!str_contains($c, '<head')) continue;

            // kalau ada favicon link sebelumnya: replace jadi favicon-256
            $new = preg_replace(
                '/<link\s+rel=("|\')icon\1[^>]*>/i',
                '<link rel="icon" type="image/png" href="{{ asset(\'favicon-256.png\') }}">',
                $c
            );

            // kalau belum ada favicon link: inject setelah meta charset atau setelah <head>
            if ($new === $c && !preg_match('/rel=("|\')icon\1/i', $c)) {
                $inject = "\n  <link rel=\"icon\" type=\"image/png\" href=\"{{ asset('favicon-256.png') }}\">\n";
                if (preg_match('/<meta\s+charset=.*?>/i', $c)) {
                    $new = preg_replace('/(<meta\s+charset=.*?>)/i', "$1{$inject}", $c, 1);
                } else {
                    $new = preg_replace('/<head[^>]*>/i', "$0{$inject}", $c, 1);
                }
            }

            if ($new !== $c) {
                File::put($path, $new);
                $changed++;
            }
        }

        $this->line(" - layouts updated: {$changed} file");
    }
}
