<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ScaffoldPortofolio extends Command
{
    protected $signature = 'scaffold:portofolio';
    protected $description = 'Scaffold CRUD Portofolio + routes + views + inject menu sidebar (otomatis)';

    public function handle()
    {
        $resources = [
            [
                'name' => 'PortofolioUdara',
                'route' => 'portofolio-udara',
                'title' => 'Kelola Portofolio Jasa Udara Drone',
                'subtitle' => 'Project jasa udara',
            ],
            [
                'name' => 'PortofolioDarat',
                'route' => 'portofolio-darat',
                'title' => 'Kelola Portofolio Jasa Darat',
                'subtitle' => 'Project jasa darat',
            ],
            [
                'name' => 'PortofolioServisDrone',
                'route' => 'portofolio-servis-drone',
                'title' => 'Kelola Portofolio Jasa Servis Drone',
                'subtitle' => 'Servis & perbaikan drone',
            ],
            [
                'name' => 'PortofolioPenjualan',
                'route' => 'portofolio-penjualan',
                'title' => 'Kelola Portofolio Penjualan',
                'subtitle' => 'Produk & penjualan',
            ],
        ];

        $this->info('1) Generate Model + Migration + Controller...');
        foreach ($resources as $r) {
            $this->callSilent('make:model', [
                'name' => $r['name'],
                '--migration' => true,
                '--controller' => true,
                '--resource' => true,
            ]);
        }

        $this->info('2) Generate Form Requests...');
        foreach ($resources as $r) {
            $this->callSilent('make:request', ['name' => "Store{$r['name']}Request"]);
            $this->callSilent('make:request', ['name' => "Update{$r['name']}Request"]);
        }

        $this->info('3) Tulis schema migration (otomatis)...');
        foreach ($resources as $r) {
            $this->patchMigration($r['name']);
        }

        $this->info('4) Patch Controller agar pakai validation + CRUD basic...');
        foreach ($resources as $r) {
            $this->patchController($r['name']);
        }

        $this->info('5) Buat Views CRUD (otomatis)...');
        foreach ($resources as $r) {
            $this->makeViews($r['route'], $r['title'], $r['subtitle']);
        }

        $this->info('6) Tambah routes otomatis...');
        $this->patchRoutes($resources);

        $this->info('7) Inject menu ke sidebar (otomatis)...');
        $this->injectSidebarMenu($resources);

        $this->newLine();
        $this->info('SELESAI ✅');
        $this->line('Lanjut jalankan: php artisan migrate');
        return self::SUCCESS;
    }

    private function patchMigration(string $modelName): void
    {
        $migrationDir = database_path('migrations');
        $files = collect(File::files($migrationDir))
            ->filter(fn ($f) => str_contains($f->getFilename(), 'create_' . $this->snakePlural($modelName) . '_table'))
            ->sortByDesc(fn ($f) => $f->getMTime())
            ->values();

        if ($files->isEmpty()) {
            $this->warn("Migration untuk {$modelName} tidak ditemukan.");
            return;
        }

        $path = $files->first()->getPathname();
        $content = File::get($path);

        // Replace isi Schema::create default
        $content = preg_replace(
            '/\$table->id\(\);\s*\$table->timestamps\(\);/m',
            "\$table->id();\n            \$table->string('judul');\n            \$table->text('deskripsi')->nullable();\n            \$table->string('lokasi')->nullable();\n            \$table->date('tanggal')->nullable();\n            \$table->string('cover')->nullable();\n            \$table->timestamps();",
            $content
        );

        File::put($path, $content);
    }

    private function patchController(string $modelName): void
    {
        $controller = app_path("Http/Controllers/{$modelName}Controller.php");
        if (!File::exists($controller)) return;

        $modelVar = lcfirst($modelName);
        $modelFqn = "App\\Models\\{$modelName}";

        $storeReq = "App\\Http\\Requests\\Store{$modelName}Request";
        $updateReq = "App\\Http\\Requests\\Update{$modelName}Request";

        $viewBase = 'admin.' . $this->kebab($modelName);
        $routeBase = $this->kebab($modelName);

        $stub = <<<PHP
<?php

namespace App\Http\Controllers;

use {$modelFqn};
use {$storeReq};
use {$updateReq};
use Illuminate\Http\Request;

class {$modelName}Controller extends Controller
{
    public function index()
    {
        \${$modelVar}s = {$modelName}::latest()->paginate(10);
        return view('{$viewBase}.index', compact('{$modelVar}s'));
    }

    public function create()
    {
        return view('{$viewBase}.create');
    }

    public function store(Store{$modelName}Request \$request)
    {
        {$modelName}::create(\$request->validated());
        return redirect()->route('admin.{$routeBase}.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function show({$modelName} \${$modelVar})
    {
        return view('{$viewBase}.show', compact('{$modelVar}'));
    }

    public function edit({$modelName} \${$modelVar})
    {
        return view('{$viewBase}.edit', compact('{$modelVar}'));
    }

    public function update(Update{$modelName}Request \$request, {$modelName} \${$modelVar})
    {
        \${$modelVar}->update(\$request->validated());
        return redirect()->route('admin.{$routeBase}.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy({$modelName} \${$modelVar})
    {
        \${$modelVar}->delete();
        return redirect()->route('admin.{$routeBase}.index')->with('success', 'Data berhasil dihapus.');
    }
}
PHP;

        File::put($controller, $stub);

        // Pastikan model fillable
        $modelPath = app_path("Models/{$modelName}.php");
        if (File::exists($modelPath)) {
            $m = File::get($modelPath);
            if (!str_contains($m, 'protected $fillable')) {
                $m = preg_replace(
                    '/class\s+' . preg_quote($modelName, '/') . '\s+extends\s+Model\s*\{/m',
                    "class {$modelName} extends Model\n{\n    protected \$fillable = ['judul','deskripsi','lokasi','tanggal','cover'];\n",
                    $m
                );
                File::put($modelPath, $m);
            }
        }

        // Patch request rules
        $this->patchRequest("Store{$modelName}Request", true);
        $this->patchRequest("Update{$modelName}Request", false);
    }

    private function patchRequest(string $requestName, bool $isStore): void
    {
        $path = app_path("Http/Requests/{$requestName}.php");
        if (!File::exists($path)) return;

        $rules = $isStore
            ? <<<PHP
return [
            'judul' => ['required','string','max:255'],
            'deskripsi' => ['nullable','string'],
            'lokasi' => ['nullable','string','max:255'],
            'tanggal' => ['nullable','date'],
            'cover' => ['nullable','string','max:255'],
        ];
PHP
            : <<<PHP
return [
            'judul' => ['required','string','max:255'],
            'deskripsi' => ['nullable','string'],
            'lokasi' => ['nullable','string','max:255'],
            'tanggal' => ['nullable','date'],
            'cover' => ['nullable','string','max:255'],
        ];
PHP;

        $content = File::get($path);

        // authorize true
        $content = preg_replace('/public function authorize\(\)\s*\{\s*return false;\s*\}/m', "public function authorize()\n    {\n        return true;\n    }", $content);

        // rules body
        $content = preg_replace('/public function rules\(\)\s*\{\s*return \[\];\s*\}/m', "public function rules()\n    {\n        {$rules}\n    }", $content);

        File::put($path, $content);
    }

    private function makeViews(string $route, string $title, string $subtitle): void
    {
        $dir = resource_path("views/admin/{$route}");
        File::ensureDirectoryExists($dir);

        // index
        File::put("{$dir}/index.blade.php", <<<BLADE
@extends('layouts.admin')

@section('title', '{$title}')

@section('content')
<div class="flex items-center justify-between mb-4">
  <div>
    <h1 class="text-xl font-extrabold text-slate-900">{$title}</h1>
    <p class="text-sm text-slate-500">{$subtitle}</p>
  </div>
  <a href="{{ route('admin.{$route}.create') }}"
     class="px-4 py-2 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-500 transition shadow-sm">
    + Tambah
  </a>
</div>

@if(session('success'))
  <div class="mb-4 p-3 rounded-xl bg-green-50 border border-green-200 text-green-800">
    {{ session('success') }}
  </div>
@endif

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-slate-50 text-slate-600">
      <tr>
        <th class="text-left p-3">Judul</th>
        <th class="text-left p-3">Lokasi</th>
        <th class="text-left p-3">Tanggal</th>
        <th class="text-right p-3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse(\$portofolios as \$item)
      <tr class="border-t border-slate-100">
        <td class="p-3 font-semibold text-slate-800">{{ \$item->judul }}</td>
        <td class="p-3 text-slate-600">{{ \$item->lokasi }}</td>
        <td class="p-3 text-slate-600">{{ \$item->tanggal }}</td>
        <td class="p-3">
          <div class="flex justify-end gap-2">
            <a class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 transition"
               href="{{ route('admin.{$route}.show', \$item) }}">Detail</a>
            <a class="px-3 py-1.5 rounded-lg bg-amber-100 hover:bg-amber-200 transition"
               href="{{ route('admin.{$route}.edit', \$item) }}">Edit</a>
            <form method="POST" action="{{ route('admin.{$route}.destroy', \$item) }}"
                  onsubmit="return confirm('Yakin hapus data ini?')">
              @csrf @method('DELETE')
              <button class="px-3 py-1.5 rounded-lg bg-red-100 hover:bg-red-200 transition">
                Hapus
              </button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="4" class="p-6 text-center text-slate-500">Belum ada data.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-4">
  {{ \$portofolios->links() }}
</div>
@endsection
BLADE);

        // create
        File::put("{$dir}/create.blade.php", $this->formView($route, $title, 'create'));

        // edit
        File::put("{$dir}/edit.blade.php", $this->formView($route, $title, 'edit'));

        // show
        File::put("{$dir}/show.blade.php", <<<BLADE
@extends('layouts.admin')

@section('title', '{$title} - Detail')

@section('content')
<div class="mb-4">
  <a href="{{ route('admin.{$route}.index') }}" class="text-sm text-slate-600 hover:underline">← Kembali</a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
  <h1 class="text-xl font-extrabold text-slate-900 mb-1">{{ \$portofolio->judul }}</h1>
  <div class="text-sm text-slate-500 mb-4">
    {{ \$portofolio->lokasi }} · {{ \$portofolio->tanggal }}
  </div>

  <div class="prose max-w-none">
    <p class="text-slate-700 whitespace-pre-line">{{ \$portofolio->deskripsi }}</p>
  </div>

  @if(\$portofolio->cover)
    <div class="mt-4 text-sm text-slate-600">
      Cover: <span class="font-semibold">{{ \$portofolio->cover }}</span>
    </div>
  @endif
</div>
@endsection
BLADE);
    }

    private function formView(string $route, string $title, string $mode): string
    {
        $isEdit = $mode === 'edit';

        $header = $isEdit ? "{$title} - Edit" : "{$title} - Tambah";
        $action = $isEdit
            ? "{{ route('admin.{$route}.update', \$portofolio) }}"
            : "{{ route('admin.{$route}.store') }}";
        $method = $isEdit ? "@method('PUT')" : "";

        $judulVal = $isEdit ? "{{ old('judul', \$portofolio->judul) }}" : "{{ old('judul') }}";
        $deskripsiVal = $isEdit ? "{{ old('deskripsi', \$portofolio->deskripsi) }}" : "{{ old('deskripsi') }}";
        $lokasiVal = $isEdit ? "{{ old('lokasi', \$portofolio->lokasi) }}" : "{{ old('lokasi') }}";
        $tanggalVal = $isEdit ? "{{ old('tanggal', \$portofolio->tanggal) }}" : "{{ old('tanggal') }}";
        $coverVal = $isEdit ? "{{ old('cover', \$portofolio->cover) }}" : "{{ old('cover') }}";

        return <<<BLADE
@extends('layouts.admin')

@section('title', '{$header}')

@section('content')
<div class="mb-4">
  <a href="{{ route('admin.{$route}.index') }}" class="text-sm text-slate-600 hover:underline">← Kembali</a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 max-w-3xl">
  <h1 class="text-xl font-extrabold text-slate-900 mb-4">{$header}</h1>

  @if(\$errors->any())
    <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-red-800">
      <ul class="list-disc pl-5">
        @foreach(\$errors->all() as \$e)
          <li>{{ \$e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{$action}" class="space-y-4">
    @csrf
    {$method}

    <div>
      <label class="text-sm font-semibold text-slate-700">Judul</label>
      <input name="judul" value="{$judulVal}"
             class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-200">
    </div>

    <div>
      <label class="text-sm font-semibold text-slate-700">Deskripsi</label>
      <textarea name="deskripsi" rows="4"
                class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-200">{$deskripsiVal}</textarea>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
      <div>
        <label class="text-sm font-semibold text-slate-700">Lokasi</label>
        <input name="lokasi" value="{$lokasiVal}"
               class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-200">
      </div>

      <div>
        <label class="text-sm font-semibold text-slate-700">Tanggal</label>
        <input type="date" name="tanggal" value="{$tanggalVal}"
               class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-200">
      </div>
    </div>

    <div>
      <label class="text-sm font-semibold text-slate-700">Cover (path / url)</label>
      <input name="cover" value="{$coverVal}"
             class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-200">
      <p class="text-xs text-slate-500 mt-1">Nanti bisa kamu ganti jadi upload file kalau mau.</p>
    </div>

    <div class="flex gap-2">
      <button class="px-4 py-2 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-500 transition shadow-sm">
        Simpan
      </button>
      <a href="{{ route('admin.{$route}.index') }}"
         class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-semibold hover:bg-slate-200 transition">
        Batal
      </a>
    </div>
  </form>
</div>
@endsection
BLADE;
    }

    private function patchRoutes(array $resources): void
    {
        $routesPath = base_path('routes/web.php');
        $content = File::exists($routesPath) ? File::get($routesPath) : '';

        if (!str_contains($content, "scaffold:portofolio")) {
            $content .= "\n\n// scaffold:portofolio\n";
        }

        // Tambahkan group admin kalau belum ada (simple append saja)
        // Catatan: kalau kamu sudah punya group admin sendiri, aman—karena kita cek duplikasi route name.
        $block = "\nRoute::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {\n";
        foreach ($resources as $r) {
            $route = $r['route'];
            $controller = "{$r['name']}Controller::class";
            $useLine = "use App\\Http\\Controllers\\{$r['name']}Controller;";
            if (!str_contains($content, $useLine)) {
                $content = $useLine . "\n" . $content;
            }
            $block .= "    Route::resource('{$route}', {$controller});\n";
        }
        $block .= "});\n";

        // Hindari duplicate append kalau sudah ada salah satu Route::resource yang sama
        $already = false;
        foreach ($resources as $r) {
            if (str_contains($content, "Route::resource('{$r['route']}'")) {
                $already = true;
                break;
            }
        }

        if (!$already) {
            $content .= $block;
            File::put($routesPath, $content);
        }
    }

    private function injectSidebarMenu(array $resources): void
    {
        // Asumsi layout kamu ada di: resources/views/layouts/admin.blade.php
        // (kalau beda path, ubah di sini)
        $layout = resource_path('views/layouts/admin.blade.php');
        if (!File::exists($layout)) {
            $this->warn("Layout tidak ketemu: {$layout}. Menu tidak di-inject.");
            return;
        }

        $content = File::get($layout);

        // Marker: setelah link dashboard pertama
        $needle = "Dashboard</div>";
        if (!str_contains($content, $needle)) {
            $this->warn("Marker dashboard tidak ketemu. Menu tidak di-inject.");
            return;
        }

        // Jika sudah pernah diinject, skip
        if (str_contains($content, "Kelola Portofolio Jasa Udara Drone")) {
            return;
        }

        $menu = "\n\n        {{-- PORTOFOLIO MENUS (AUTO) --}}\n";
        foreach ($resources as $r) {
            $route = $r['route'];
            $label = $r['title'];
            $sub = $r['subtitle'];

            $menu .= <<<BLADE

        <a href="{{ route('admin.{$route}.index') }}"
           class="group flex items-center gap-3 px-3 py-2 rounded-xl border transition
                  {{ request()->is('admin/{$route}*')
                      ? 'bg-red-50 border-red-200 text-red-700'
                      : 'bg-white border-transparent text-slate-700 hover:bg-slate-50 hover:border-slate-200' }}">

          <span class="w-8 h-8 rounded-lg flex items-center justify-center
                       {{ request()->is('admin/{$route}*')
                           ? 'bg-red-100 text-red-700'
                           : 'bg-slate-100 text-slate-600 group-hover:bg-slate-200' }}">
            <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="1.6"/>
            </svg>
          </span>

          <div class="flex-1">
            <div class="font-semibold leading-none">{$label}</div>
            <div class="text-xs text-slate-500 mt-1">{$sub}</div>
          </div>
        </a>
BLADE;
        }

        // Inject menu tepat setelah Dashboard block pertama (setelah Dashboard</div>… bagian link)
        $content = preg_replace('/(Dashboard<\/div>\s*<div class="text-xs text-slate-500 mt-1">Ringkasan data<\/div>\s*<\/div>\s*<\/a>)/m', "$1{$menu}", $content, 1);

        File::put($layout, $content);
    }

    private function snakePlural(string $model): string
    {
        // PortofolioUdara -> portofolio_udaras (cukup untuk default Laravel)
        return str($model)->snake()->plural()->toString();
    }

    private function kebab(string $model): string
    {
        // PortofolioServisDrone -> portofolio-servis-drone
        return str($model)->kebab()->toString();
    }
}
