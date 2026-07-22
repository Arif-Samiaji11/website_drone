<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixPortofolioViewVars extends Command
{
    protected $signature = 'fix:portofolio-vars';
    protected $description = 'Samakan nama variable controller & view portofolio (pakai $items)';

    public function handle()
    {
        $resources = [
            ['route' => 'portofolio-udara', 'model' => 'PortofolioUdara'],
            ['route' => 'portofolio-darat', 'model' => 'PortofolioDarat'],
            ['route' => 'portofolio-servis-drone', 'model' => 'PortofolioServisDrone'],
            ['route' => 'portofolio-penjualan', 'model' => 'PortofolioPenjualan'],
        ];

        $this->info('1) Patch controller index() => kirim $items ...');
        foreach ($resources as $r) {
            $this->patchControllerIndex($r['model'], $r['route']);
        }

        $this->info('2) Patch view index.blade.php => pakai $items ...');
        foreach ($resources as $r) {
            $this->patchIndexView($r['route']);
        }

        $this->newLine();
        $this->info('SELESAI ✅ Jalankan: php artisan optimize:clear');
        return self::SUCCESS;
    }

    private function patchControllerIndex(string $model, string $route): void
    {
        $path = app_path("Http/Controllers/{$model}Controller.php");
        if (!File::exists($path)) return;

        $content = File::get($path);

        // ganti apapun variabel paginate di index jadi $items
        $content = preg_replace(
            '/public function index\(\)\s*\{\s*[^}]*?paginate\(\d+\);\s*return view\([^)]+\);\s*\}/s',
            "public function index()\n    {\n        \$items = \\App\\Models\\{$model}::latest()->paginate(10);\n        return view('admin.{$route}.index', compact('items'));\n    }",
            $content,
            1
        );

        File::put($path, $content);
    }

    private function patchIndexView(string $route): void
    {
        $path = resource_path("views/admin/{$route}/index.blade.php");
        if (!File::exists($path)) return;

        $content = File::get($path);

        // ganti $portofolios / $portofolioUdaras / dll menjadi $items
        $content = preg_replace('/\$(portofolios|portofolio[A-Za-z]+s)\b/', '$items', $content);

        File::put($path, $content);
    }
}
