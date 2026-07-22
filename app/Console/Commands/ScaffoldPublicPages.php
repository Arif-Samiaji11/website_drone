<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ScaffoldPublicPages extends Command
{
    protected $signature = 'scaffold:public-pages';
    protected $description = 'FULL otomatis: buat booking/order/servis pages + CRUD simpan DB + ambil data dari tabel portofolio yg sudah ada';

    public function handle()
    {
        $this->info("1) Generate Model + Migration + Controller + Request...");
        $this->call('make:model', ['name' => 'BookingDrone', '--migration' => true, '--controller' => true]);
        $this->call('make:model', ['name' => 'BookingCrew', '--migration' => true, '--controller' => true]);
        $this->call('make:model', ['name' => 'ServisDrone', '--migration' => true, '--controller' => true]);
        $this->call('make:model', ['name' => 'OrderDrone',  '--migration' => true, '--controller' => true]);

        $this->call('make:request', ['name' => 'StoreBookingDroneRequest']);
        $this->call('make:request', ['name' => 'StoreBookingCrewRequest']);
        $this->call('make:request', ['name' => 'StoreServisDroneRequest']);
        $this->call('make:request', ['name' => 'StoreOrderDroneRequest']);

        $this->info("2) Patch migration transaction tables...");
        $this->patchMigration('BookingDrone', 'booking_drones');
        $this->patchMigration('BookingCrew', 'booking_crews');
        $this->patchMigration('ServisDrone', 'servis_drones');
        $this->patchMigration('OrderDrone',  'order_drones');

        $this->info("3) Patch models fillable...");
        $this->patchModelFillable('BookingDrone');
        $this->patchModelFillable('BookingCrew');
        $this->patchModelFillable('ServisDrone');
        $this->patchModelFillable('OrderDrone');

        $this->info("4) Patch Form Requests rules...");
        $this->patchRequest('StoreBookingDroneRequest');
        $this->patchRequest('StoreBookingCrewRequest');
        $this->patchRequest('StoreServisDroneRequest');
        $this->patchRequest('StoreOrderDroneRequest');

        $this->info("5) Patch Controllers (GET page + POST submit, ambil data dari tabel portofolio)...");
        $this->writeControllers();

        $this->info("6) Buat Views public pages (ambil data portofolio + form submit)...");
        $this->makeViews();

        $this->info("7) Patch routes/web.php (route names sesuai navbar)...");
        $this->patchRoutes();

        $this->newLine();
        $this->info("SELESAI ✅");
        $this->line("Lanjut jalankan:");
        $this->line("  php artisan migrate");
        $this->line("  php artisan optimize:clear");
        return self::SUCCESS;
    }

    private function patchMigration(string $modelName, string $table): void
    {
        $migrationDir = database_path('migrations');
        $needle = 'create_' . $this->snakePlural($modelName) . '_table';

        $file = collect(File::files($migrationDir))
            ->filter(fn($f) => str_contains($f->getFilename(), $needle))
            ->sortByDesc(fn($f) => $f->getMTime())
            ->first();

        if (!$file) return;

        $path = $file->getPathname();
        $content = File::get($path);

        // paksa table name sesuai yang kita mau
        $content = preg_replace(
            "/Schema::create\('.*?'/",
            "Schema::create('{$table}'",
            $content
        );

        // isi kolom standar transaksi
        $content = preg_replace(
            '/\$table->id\(\);\s*\$table->timestamps\(\);/m',
            "\$table->id();\n".
            "            \$table->string('nama');\n".
            "            \$table->string('email')->nullable();\n".
            "            \$table->string('hp')->nullable();\n".
            "            \$table->string('lokasi')->nullable();\n".
            "            \$table->date('tanggal')->nullable();\n".
            "            \$table->text('catatan')->nullable();\n".
            "            \$table->unsignedBigInteger('portofolio_id')->nullable();\n".
            "            \$table->string('status')->default('baru');\n".
            "            \$table->timestamps();",
            $content
        );

        File::put($path, $content);
    }

    private function patchModelFillable(string $modelName): void
    {
        $path = app_path("Models/{$modelName}.php");
        if (!File::exists($path)) return;

        $c = File::get($path);
        if (str_contains($c, 'protected $fillable')) return;

        $c = preg_replace(
            '/class\s+' . preg_quote($modelName, '/') . '\s+extends\s+Model\s*\{/m',
            "class {$modelName} extends Model\n{\n    protected \$fillable = ['nama','email','hp','lokasi','tanggal','catatan','portofolio_id','status'];\n",
            $c
        );

        File::put($path, $c);
    }

    private function patchRequest(string $requestName): void
    {
        $path = app_path("Http/Requests/{$requestName}.php");
        if (!File::exists($path)) return;

        $rules = <<<PHP
return [
            'nama' => ['required','string','max:255'],
            'email' => ['nullable','email','max:255'],
            'hp' => ['nullable','string','max:30'],
            'lokasi' => ['nullable','string','max:255'],
            'tanggal' => ['nullable','date'],
            'catatan' => ['nullable','string'],
            'portofolio_id' => ['nullable','integer'],
        ];
PHP;

        $c = File::get($path);
        $c = preg_replace('/return false;/', 'return true;', $c);
        $c = preg_replace(
            '/public function rules\(\)\s*\{\s*return \[\];\s*\}/m',
            "public function rules()\n    {\n        {$rules}\n    }",
            $c
        );

        File::put($path, $c);
    }

    private function writeControllers(): void
    {
        // 4 controller public (kita bikin baru supaya gak ganggu yg lain)
        $this->writePublicController(
            'BookingDronePageController',
            'PortofolioUdara',
            'portofolio_udaras',
            'booking_drone',
            'StoreBookingDroneRequest',
            'BookingDrone',
            'booking.drone'
        );

        $this->writePublicController(
            'BookingCrewPageController',
            'PortofolioDarat',
            'portofolio_darats',
            'booking_crews',
            'StoreBookingCrewRequest',
            'BookingCrew',
            'booking.crews'
        );

        $this->writePublicController(
            'ServisDronePageController',
            'PortofolioServisDrone',
            'portofolio_servis_drones',
            'servis_drone',
            'StoreServisDroneRequest',
            'ServisDrone',
            'servis.drone'
        );

        $this->writePublicController(
            'OrderDronePageController',
            'PortofolioPenjualan',
            'portofolio_penjualans',
            'order_drone',
            'StoreOrderDroneRequest',
            'OrderDrone',
            'order.drone'
        );
    }

    private function writePublicController(
        string $controllerName,
        string $portofolioModel,
        string $portofolioTable,
        string $viewName,
        string $requestName,
        string $trxModel,
        string $routeName
    ): void {
        $path = app_path("Http/Controllers/{$controllerName}.php");

        $stub = <<<PHP
<?php

namespace App\Http\Controllers;

use App\Models\\{$portofolioModel};
use App\Models\\{$trxModel};
use App\Http\Requests\\{$requestName};
use Illuminate\Support\Facades\DB;

class {$controllerName} extends Controller
{
    public function index()
    {
        // ambil data dari tabel portofolio yang sudah kamu buat
        \$portofolios = {$portofolioModel}::latest()->paginate(9);
        return view('pages.{$viewName}', compact('portofolios'));
    }

    public function store({$requestName} \$request)
    {
        {$trxModel}::create(\$request->validated());

        return redirect()->route('{$routeName}')
            ->with('success', 'Permintaan berhasil dikirim. Tim kami akan menghubungi kamu.');
    }
}
PHP;

        File::put($path, $stub);

        // pastikan controller public terdaftar autoload: sudah otomatis
    }

    private function makeViews(): void
    {
        File::ensureDirectoryExists(resource_path('views/pages'));

        $this->writePageView(
            'booking_drone',
            'Booking Jasa Drone',
            'Ambil referensi project dari Portofolio Jasa Udara Drone (tabel portofolio_udaras).'
        );

        $this->writePageView(
            'booking_crews',
            'Booking Photographer / Videographer',
            'Ambil referensi project dari Portofolio Jasa Darat (tabel portofolio_darats).'
        );

        $this->writePageView(
            'servis_drone',
            'Servis Unit Drone',
            'Ambil referensi servis dari Portofolio Servis Drone (tabel portofolio_servis_drones).'
        );

        $this->writePageView(
            'order_drone',
            'Order Unit Drone',
            'Ambil referensi produk dari Portofolio Penjualan (tabel portofolio_penjualans).'
        );
    }

    private function writePageView(string $file, string $title, string $desc): void
    {
        $path = resource_path("views/pages/{$file}.blade.php");

        // route name sesuai navbar
        $routeName = match($file) {
            'booking_drone' => 'booking.drone.submit',
            'booking_crews' => 'booking.crews.submit',
            'servis_drone'  => 'servis.drone.submit',
            'order_drone'   => 'order.drone.submit',
            default => '#',
        };

        $content = <<<BLADE
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{$title}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
  {{-- kalau kamu punya partial navbar, dia akan otomatis tampil --}}
  @includeIf('partials.navbar')

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-6">
      <h1 class="text-2xl font-extrabold">{$title}</h1>
      <p class="text-slate-600 text-sm mt-1">{$desc}</p>
    </div>

    @if(session('success'))
      <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-200 text-green-800">
        {{ session('success') }}
      </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-6">
      {{-- LIST PORTOFOLIO --}}
      <div class="lg:col-span-2">
        <div class="grid md:grid-cols-2 gap-4">
          @forelse(\$portofolios as \$p)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
              <div class="font-extrabold text-slate-900">{{ \$p->judul }}</div>
              <div class="text-sm text-slate-500 mt-1">
                {{ \$p->lokasi }} @if(\$p->tanggal) · {{ \$p->tanggal }} @endif
              </div>
              @if(\$p->deskripsi)
                <p class="text-sm text-slate-700 mt-3 line-clamp-3">{{ \$p->deskripsi }}</p>
              @endif
              <div class="mt-3 text-xs text-slate-500">ID Referensi: <span class="font-semibold">{{ \$p->id }}</span></div>
            </div>
          @empty
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 text-slate-500">
              Belum ada portofolio.
            </div>
          @endforelse
        </div>

        <div class="mt-5">
          {{ \$portofolios->links() }}
        </div>
      </div>

      {{-- FORM SUBMIT --}}
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <div class="font-extrabold text-slate-900">Kirim Permintaan</div>
        <div class="text-sm text-slate-500 mt-1">Isi form, boleh pilih ID Referensi portofolio.</div>

        @if(\$errors->any())
          <div class="mt-4 p-3 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm">
            <ul class="list-disc pl-5">
              @foreach(\$errors->all() as \$e)
                <li>{{ \$e }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('{$routeName}') }}" class="mt-4 space-y-3">
          @csrf

          <div>
            <label class="text-sm font-semibold text-slate-700">Nama</label>
            <input name="nama" value="{{ old('nama') }}"
              class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-200">
          </div>

          <div>
            <label class="text-sm font-semibold text-slate-700">Email</label>
            <input name="email" value="{{ old('email') }}"
              class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-200">
          </div>

          <div>
            <label class="text-sm font-semibold text-slate-700">No HP</label>
            <input name="hp" value="{{ old('hp') }}"
              class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-200">
          </div>

          <div>
            <label class="text-sm font-semibold text-slate-700">Lokasi</label>
            <input name="lokasi" value="{{ old('lokasi') }}"
              class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-200">
          </div>

          <div>
            <label class="text-sm font-semibold text-slate-700">Tanggal</label>
            <input type="date" name="tanggal" value="{{ old('tanggal') }}"
              class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-200">
          </div>

          <div>
            <label class="text-sm font-semibold text-slate-700">ID Referensi Portofolio (opsional)</label>
            <input name="portofolio_id" value="{{ old('portofolio_id') }}"
              class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-200"
              placeholder="contoh: 1">
          </div>

          <div>
            <label class="text-sm font-semibold text-slate-700">Catatan</label>
            <textarea name="catatan" rows="4"
              class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-200">{{ old('catatan') }}</textarea>
          </div>

          <button class="w-full px-4 py-2 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-500 transition shadow-sm">
            Kirim
          </button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
BLADE;

        File::put($path, $content);
    }

    private function patchRoutes(): void
    {
        $routes = base_path('routes/web.php');
        $c = File::exists($routes) ? File::get($routes) : "<?php\n\n";

        // pastikan file diawali <?php
        if (!preg_match('/^\s*<\?php/', $c)) {
            $c = "<?php\n\n" . preg_replace('/<\?php/', '', $c);
        }

        // use controllers (masuk setelah <?php)
        $uses = [
            "use App\Http\Controllers\BookingDronePageController;",
            "use App\Http\Controllers\BookingCrewPageController;",
            "use App\Http\Controllers\ServisDronePageController;",
            "use App\Http\Controllers\OrderDronePageController;",
        ];

        foreach ($uses as $u) {
            if (!str_contains($c, $u)) {
                $c = preg_replace('/<\?php\s*/', "<?php\n{$u}\n", $c, 1);
            }
        }

        // route block
        $block = <<<PHP


// Public pages (auto)
Route::get('/booking-jasa-drone', [BookingDronePageController::class, 'index'])->name('booking.drone');
Route::post('/booking-jasa-drone', [BookingDronePageController::class, 'store'])->name('booking.drone.submit');

Route::get('/booking-photographer-videographer', [BookingCrewPageController::class, 'index'])->name('booking.crews');
Route::post('/booking-photographer-videographer', [BookingCrewPageController::class, 'store'])->name('booking.crews.submit');

Route::get('/servis-unit-drone', [ServisDronePageController::class, 'index'])->name('servis.drone');
Route::post('/servis-unit-drone', [ServisDronePageController::class, 'store'])->name('servis.drone.submit');

Route::get('/order-unit-drone', [OrderDronePageController::class, 'index'])->name('order.drone');
Route::post('/order-unit-drone', [OrderDronePageController::class, 'store'])->name('order.drone.submit');

PHP;

        // hindari duplicate
        if (!str_contains($c, "Route::get('/booking-jasa-drone'")) {
            $c .= $block;
        }

        File::put($routes, $c);
    }

    private function snakePlural(string $model): string
    {
        return str($model)->snake()->plural()->toString();
    }
}
