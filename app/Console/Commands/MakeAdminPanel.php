<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeAdminPanel extends Command
{
    protected $signature = 'app:make-admin-panel
        {--email=arifsamiaji11@gmail.com : Email admin}
        {--password=12345678 : Password admin}
        {--name=Administrator : Nama admin}';

    protected $description = 'Generate Admin Login (/admin/login), admin routes, middleware alias, sidebar layout, dashboard, and admin seeder (no manual edits)';

    public function handle()
    {
        $fs = new Filesystem();

        $adminEmail = $this->option('email');
        $adminPass  = $this->option('password');
        $adminName  = $this->option('name');

        // 1) Ensure migration exists; create if missing
        $this->ensureMigrationExists();

        // 2) Write migration content for is_admin
        $migrationPath = $this->findLatestMigration('add_is_admin_to_users_table');
        if (!$migrationPath) {
            $this->error('Migration add_is_admin_to_users_table not found.');
            return self::FAILURE;
        }
        $fs->put($migrationPath, $this->stubMigrationIsAdmin());
        $this->info('✓ Migration updated: ' . basename($migrationPath));

        // 3) Middleware
        $mwPath = app_path('Http/Middleware/EnsureUserIsAdmin.php');
        $fs->ensureDirectoryExists(dirname($mwPath));
        $fs->put($mwPath, $this->stubMiddleware());
        $this->info('✓ Middleware written: EnsureUserIsAdmin.php');

        // 4) Register middleware alias 'admin' (FIXED)
        $this->registerMiddlewareAlias($fs);

        // 5) Controllers
        $authControllerPath = app_path('Http/Controllers/Admin/AdminAuthController.php');
        $dashControllerPath = app_path('Http/Controllers/Admin/AdminDashboardController.php');

        $fs->ensureDirectoryExists(dirname($authControllerPath));
        $fs->put($authControllerPath, $this->stubAdminAuthController());
        $fs->put($dashControllerPath, $this->stubAdminDashboardController());
        $this->info('✓ Controllers written: AdminAuthController, AdminDashboardController');

        // 6) Seeder admin (custom email/pass) + hook to DatabaseSeeder
        $seederPath = database_path('seeders/AdminUserSeeder.php');
        $fs->ensureDirectoryExists(dirname($seederPath));
        $fs->put($seederPath, $this->stubAdminSeederCustom($adminName, $adminEmail, $adminPass));
        $this->info("✓ Seeder written: AdminUserSeeder.php ({$adminEmail})");

        // 6a) Patch DatabaseSeeder Breeze: comment out any test@example.com creation
        $this->patchDatabaseSeederToAvoidTestUser($fs);

        // 6b) Ensure DatabaseSeeder calls AdminUserSeeder
        $this->hookSeederIntoDatabaseSeeder($fs);

        // 7) Views
        $views = [
            resource_path('views/admin/auth/login.blade.php') => $this->stubAdminLoginBlade(),
            resource_path('views/layouts/admin.blade.php')    => $this->stubAdminLayoutSidebarBlade(),
            resource_path('views/admin/dashboard.blade.php')  => $this->stubAdminDashboardBlade(),
        ];
        foreach ($views as $path => $content) {
            $fs->ensureDirectoryExists(dirname($path));
            $fs->put($path, $content);
        }
        $this->info('✓ Views written: admin login, admin layout sidebar, admin dashboard');

        // 8) Routes injection
        $this->injectRoutes($fs);

        $this->newLine();
        $this->info('DONE ✅');
        $this->line('Next run:');
        $this->line('  php artisan migrate');
        $this->line('  php artisan db:seed');
        $this->line('Admin login: /admin/login');
        $this->line('Admin dashboard: /admin/dashboard');
        $this->line("Admin: {$adminEmail} | {$adminPass}");

        return self::SUCCESS;
    }

    private function ensureMigrationExists(): void
    {
        $existing = $this->findLatestMigration('add_is_admin_to_users_table');
        if ($existing) return;

        $this->call('make:migration', [
            'name' => 'add_is_admin_to_users_table',
            '--table' => 'users',
        ]);
    }

    private function findLatestMigration(string $needle): ?string
    {
        $files = glob(database_path('migrations/*.php')) ?: [];
        rsort($files);
        foreach ($files as $f) {
            if (str_contains(basename($f), $needle)) return $f;
        }
        return null;
    }

    private function stubMigrationIsAdmin(): string
    {
        return <<<'PHP'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }
};
PHP;
    }

    private function stubMiddleware(): string
    {
        return <<<'PHP'
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Akses khusus admin.');
        }

        return $next($request);
    }
}
PHP;
    }

    /**
     * FIXED: gunakan single quotes agar $middleware tidak dianggap variabel PHP.
     */
    private function registerMiddlewareAlias(Filesystem $fs): void
    {
        // Laravel 11: bootstrap/app.php
        $bootstrap = base_path('bootstrap/app.php');
        if ($fs->exists($bootstrap)) {
            $content = $fs->get($bootstrap);

            if (str_contains($content, "EnsureUserIsAdmin::class") && str_contains($content, "'admin'")) {
                $this->info("✓ Middleware alias 'admin' already registered (bootstrap/app.php)");
                return;
            }

            if (str_contains($content, '->withMiddleware(')) {

                // If alias([ ... ]) exists, append admin entry
                if (str_contains($content, '->alias([')) {
                    $content = preg_replace(
                        '/->alias\(\[([\s\S]*?)\]\);\s*/m',
                        function ($m) {
                            $inside = $m[1];
                            if (!str_contains($inside, "'admin'")) {
                                $inside = rtrim($inside) . "\n            'admin' => \\\\App\\\\Http\\\\Middleware\\\\EnsureUserIsAdmin::class,\n";
                            }
                            return "->alias([\n" . ltrim($inside) . "        ]);\n";
                        },
                        $content,
                        1
                    );

                    $fs->put($bootstrap, $content);
                    $this->info("✓ Middleware alias 'admin' injected into bootstrap/app.php");
                    return;
                }

                // If no alias block, create one at start of withMiddleware closure
                $content = preg_replace(
                    '/->withMiddleware\(function\s*\(\s*\$middleware\s*\)\s*\{/m',
                    "->withMiddleware(function (\$middleware) {\n        \$middleware->alias([\n            'admin' => \\\\App\\\\Http\\\\Middleware\\\\EnsureUserIsAdmin::class,\n        ]);\n",
                    $content,
                    1
                );

                $fs->put($bootstrap, $content);
                $this->info("✓ Middleware alias 'admin' added to bootstrap/app.php");
                return;
            }
        }

        // Laravel <=10 fallback: app/Http/Kernel.php
        $kernel = app_path('Http/Kernel.php');
        if ($fs->exists($kernel)) {
            $content = $fs->get($kernel);

            if (str_contains($content, "EnsureUserIsAdmin::class") && str_contains($content, "'admin'")) {
                $this->info("✓ Middleware alias 'admin' already registered (Kernel.php)");
                return;
            }

            $content = preg_replace(
                '/protected\s+\$routeMiddleware\s*=\s*\[([\s\S]*?)\];/m',
                "protected \$routeMiddleware = [\n$1    'admin' => \\\\App\\\\Http\\\\Middleware\\\\EnsureUserIsAdmin::class,\n];",
                $content,
                1
            );

            $fs->put($kernel, $content);
            $this->info("✓ Middleware alias 'admin' injected into app/Http/Kernel.php");
        }
    }

    private function stubAdminAuthController(): string
    {
        return <<<'PHP'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if (!Auth::user()->is_admin) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun ini bukan admin.']);
            }

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
PHP;
    }

    private function stubAdminDashboardController(): string
    {
        return <<<'PHP'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
}
PHP;
    }

    private function stubAdminSeederCustom(string $name, string $email, string $password): string
    {
        $name = addslashes($name);
        $email = addslashes($email);
        $password = addslashes($password);

        return <<<PHP
<?php

namespace Database\\Seeders;

use App\\Models\\User;
use Illuminate\\Database\\Seeder;
use Illuminate\\Support\\Facades\\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => '{$email}'],
            [
                'name' => '{$name}',
                'password' => Hash::make('{$password}'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
PHP;
    }

    private function patchDatabaseSeederToAvoidTestUser(Filesystem $fs): void
    {
        $dbSeeder = database_path('seeders/DatabaseSeeder.php');
        if (!$fs->exists($dbSeeder)) return;

        $content = $fs->get($dbSeeder);

        if (!str_contains($content, 'test@example.com')) {
            $this->info('✓ DatabaseSeeder has no test@example.com (no patch needed)');
            return;
        }

        $lines = preg_split("/\r\n|\n|\r/", $content);
        $changed = false;

        foreach ($lines as $i => $line) {
            if (str_contains($line, 'test@example.com') && !str_starts_with(ltrim($line), '//')) {
                $lines[$i] = '// ' . $line;
                $changed = true;
            }
        }

        if ($changed) {
            $fs->put($dbSeeder, implode(PHP_EOL, $lines));
            $this->info('✓ DatabaseSeeder patched: commented test@example.com to avoid duplicate');
        }
    }

    private function hookSeederIntoDatabaseSeeder(Filesystem $fs): void
    {
        $dbSeeder = database_path('seeders/DatabaseSeeder.php');
        if (!$fs->exists($dbSeeder)) return;

        $content = $fs->get($dbSeeder);

        if (str_contains($content, 'AdminUserSeeder::class')) {
            $this->info('✓ DatabaseSeeder already calls AdminUserSeeder');
            return;
        }

        $content = preg_replace(
            '/public function run\(\): void\s*\{/m',
            "public function run(): void\n    {\n        \$this->call(\\Database\\Seeders\\AdminUserSeeder::class);\n",
            $content,
            1
        );

        $fs->put($dbSeeder, $content);
        $this->info('✓ DatabaseSeeder hooked to call AdminUserSeeder');
    }

    private function injectRoutes(Filesystem $fs): void
    {
        $routesPath = base_path('routes/web.php');
        if (!$fs->exists($routesPath)) return;

        $content = $fs->get($routesPath);
        if (str_contains($content, "Route::prefix('admin')")) {
            $this->info('✓ Admin routes already exist in routes/web.php');
            return;
        }

        $block = <<<'PHP'

// ===== Admin Routes =====
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.store');
    });

    Route::post('/logout', [AdminAuthController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    });
});
// ===== End Admin Routes =====

PHP;

        $fs->append($routesPath, $block);
        $this->info('✓ Admin routes appended to routes/web.php');
    }

    private function stubAdminLoginBlade(): string
    {
        return <<<'BLADE'
<x-guest-layout>
  <div class="min-h-screen flex items-center justify-center bg-slate-900 text-white px-4">
    <div class="w-full max-w-md bg-slate-800/60 border border-slate-700 rounded-2xl p-6">
      <h1 class="text-2xl font-bold">Admin Login</h1>
      <p class="text-white/70 mt-1">Masuk ke panel admin.</p>

      <x-auth-session-status class="mt-4" :status="session('status')" />

      <form method="POST" action="{{ route('admin.login.store') }}" class="mt-4 space-y-4">
        @csrf

        <div>
          <x-input-label for="email" :value="'Email'" />
          <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
            :value="old('email')" required autofocus autocomplete="username" />
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
          <x-input-label for="password" :value="'Password'" />
          <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
            required autocomplete="current-password" />
          <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label class="inline-flex items-center gap-2">
          <input type="checkbox" name="remember" class="rounded border-slate-600 bg-slate-900">
          <span class="text-sm text-white/80">Ingat saya</span>
        </label>

        <div class="flex justify-end">
          <x-primary-button>Masuk</x-primary-button>
        </div>
      </form>
    </div>
  </div>
</x-guest-layout>
BLADE;
    }

    private function stubAdminLayoutSidebarBlade(): string
    {
        return <<<'BLADE'
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', 'Admin')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-slate-900 text-white">
  <div class="min-h-screen flex">
    <aside class="w-64 bg-slate-950/60 border-r border-slate-800 hidden md:block">
      <div class="p-5 font-extrabold text-lg tracking-wide">Mriki Admin</div>

      <nav class="px-3 pb-6 space-y-1">
        <a href="{{ route('admin.dashboard') }}"
           class="block px-3 py-2 rounded-lg hover:bg-slate-800/60 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800/60' : '' }}">
          Dashboard
        </a>
      </nav>
    </aside>

    <main class="flex-1">
      <div class="flex items-center justify-between px-4 md:px-8 py-4 border-b border-slate-800 bg-slate-900/60">
        <div class="md:hidden font-bold">Mriki Admin</div>

        <form method="POST" action="{{ route('admin.logout') }}">
          @csrf
          <button class="px-3 py-2 rounded-lg bg-red-600 hover:bg-red-500">
            Logout
          </button>
        </form>
      </div>

      <div class="p-4 md:p-8">
        @yield('content')
      </div>
    </main>
  </div>
</body>
</html>
BLADE;
    }

    private function stubAdminDashboardBlade(): string
    {
        return <<<'BLADE'
@extends('layouts.admin')

@section('title','Dashboard Admin')

@section('content')
  <h1 class="text-2xl font-bold">Dashboard</h1>
  <p class="mt-2 text-white/80">Selamat datang, {{ auth()->user()->name }}.</p>
@endsection
BLADE;
    }
}
