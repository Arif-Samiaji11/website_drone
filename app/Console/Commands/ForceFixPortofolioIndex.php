<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ForceFixPortofolioIndex extends Command
{
    protected $signature = 'force:fix-portofolio-index';
    protected $description = 'Paksa controller index() kirim $items & view index pakai $items untuk semua portofolio';

    public function handle()
    {
        $list = [
            ['controller' => 'PortofolioUdaraController', 'model' => 'PortofolioUdara', 'view' => 'admin.portofolio-udara.index', 'viewPath' => 'admin/portofolio-udara/index.blade.php'],
            ['controller' => 'PortofolioDaratController', 'model' => 'PortofolioDarat', 'view' => 'admin.portofolio-darat.index', 'viewPath' => 'admin/portofolio-darat/index.blade.php'],
            ['controller' => 'PortofolioServisDroneController', 'model' => 'PortofolioServisDrone', 'view' => 'admin.portofolio-servis-drone.index', 'viewPath' => 'admin/portofolio-servis-drone/index.blade.php'],
            ['controller' => 'PortofolioPenjualanController', 'model' => 'PortofolioPenjualan', 'view' => 'admin.portofolio-penjualan.index', 'viewPath' => 'admin/portofolio-penjualan/index.blade.php'],
        ];

        $this->info('1) Patch controller index() ...');
        foreach ($list as $it) {
            $this->patchController($it['controller'], $it['model'], $it['view']);
        }

        $this->info('2) Patch view index.blade.php ...');
        foreach ($list as $it) {
            $this->patchView($it['viewPath']);
        }

        $this->info('3) Clear cache view...');
        $this->callSilent('view:clear');
        $this->callSilent('optimize:clear');

        $this->newLine();
        $this->info('SELESAI ✅ Coba refresh halaman portofolio.');
        return self::SUCCESS;
    }

    private function patchController(string $controllerName, string $model, string $view): void
    {
        $path = app_path("Http/Controllers/{$controllerName}.php");
        if (!File::exists($path)) {
            $this->warn("Controller tidak ketemu: {$controllerName}");
            return;
        }

        $content = File::get($path);

        // Paksa replace seluruh method index() apapun isinya
        $pattern = '/public function index\(\)\s*\{.*?\n\s*\}/s';

        $replacement = "public function index()\n    {\n        \$items = \\App\\Models\\{$model}::latest()->paginate(10);\n        return view('{$view}', ['items' => \$items]);\n    \n    }";

        if (preg_match($pattern, $content)) {
            $content = preg_replace($pattern, $replacement, $content, 1);
        } else {
            // kalau index() nggak ketemu, tambahkan sebelum akhir class
            $content = preg_replace('/\}\s*$/', "\n\n    {$replacement}\n}\n", $content, 1);
        }

        File::put($path, $content);
        $this->line(" - Patched: {$controllerName}@index");
    }

    private function patchView(string $relativePath): void
    {
        $path = resource_path("views/{$relativePath}");
        if (!File::exists($path)) {
            $this->warn("View tidak ketemu: {$relativePath}");
            return;
        }

        $content = File::get($path);

        // apapun nama koleksi sebelumnya, ganti jadi $items
        $content = preg_replace('/\$(portofolios|portofolio[A-Za-z]+s)\b/', '$items', $content);

        File::put($path, $content);
        $this->line(" - Patched view: {$relativePath}");
    }
}
