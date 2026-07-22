<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ResizeLogoEverywhere extends Command
{
    protected $signature = 'resize:logo {--size=16 : Tailwind size (contoh 14,16,20)}';
    protected $description = 'Besarkan logo img/logo.png di semua blade (ubah w-10 h-10 jadi ukuran baru)';

    public function handle()
    {
        $size = (int) $this->option('size');
        if ($size < 8) $size = 8;
        if ($size > 32) $size = 32;

        $from = 'w-10 h-10 object-contain';
        $to   = "w-{$size} h-{$size} object-contain";

        $this->info("Ubah ukuran logo: {$from}  =>  {$to}");

        $paths = collect(File::allFiles(resource_path('views')))
            ->filter(fn($f) => str_ends_with($f->getFilename(), '.blade.php'))
            ->map(fn($f) => $f->getPathname())
            ->values();

        $changed = 0;

        foreach ($paths as $path) {
            $c = File::get($path);

            // hanya ganti logo yang pakai asset('img/logo.png')
            if (!str_contains($c, "asset('img/logo.png')") && !str_contains($c, 'asset("img/logo.png")')) {
                continue;
            }

            $new = str_replace($from, $to, $c);
            if ($new !== $c) {
                File::put($path, $new);
                $changed++;
                $this->line(" - updated: " . str_replace(base_path() . DIRECTORY_SEPARATOR, '', $path));
            }
        }

        $this->newLine();
        $this->info("Total file diupdate: {$changed}");

        $this->info("Clear cache view...");
        $this->callSilent('view:clear');
        $this->callSilent('optimize:clear');

        $this->newLine();
        $this->info("SELESAI ✅");
        $this->line("Kalau masih kurang besar: jalankan lagi dengan --size=20 atau --size=24");
        return self::SUCCESS;
    }
}
