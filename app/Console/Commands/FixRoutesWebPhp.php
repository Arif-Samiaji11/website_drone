<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixRoutesWebPhp extends Command
{
    protected $signature = 'fix:routes-web-php';
    protected $description = 'Memindahkan "use ..." yang terlanjur di luar tag PHP ke dalam tag PHP pada routes/web.php';

    public function handle()
    {
        $path = base_path('routes/web.php');

        if (!File::exists($path)) {
            $this->error("File tidak ditemukan: {$path}");
            return self::FAILURE;
        }

        $content = File::get($path);

        // Kalau file sudah benar (dimulai dengan <?php), aman
        if (preg_match('/^\s*<\?php/', $content)) {
            $this->info("routes/web.php sudah diawali <?php. (Jika masih muncul teks, berarti ada output lain di luar PHP.)");
            return self::SUCCESS;
        }

        // Ambil semua baris "use ....;"
        preg_match_all('/^\s*use\s+[^;]+;\s*$/m', $content, $m);
        $useLines = array_unique($m[0] ?? []);

        // Hapus semua use line dari luar PHP
        foreach ($useLines as $line) {
            $content = str_replace($line, '', $content);
        }

        // Bersihkan whitespace awal
        $content = ltrim($content);

        // Susun ulang: <?php + use lines + sisanya
        $fixed = "<?php\n\n";
        if (!empty($useLines)) {
            $fixed .= implode("\n", $useLines) . "\n\n";
        }
        $fixed .= $content;

        File::put($path, $fixed);

        $this->info("Berhasil fix routes/web.php ✅");
        $this->line("Lanjut: php artisan optimize:clear");

        return self::SUCCESS;
    }
}
