<?php

use App\Http\Controllers\OrderDronePageController;
use App\Http\Controllers\ServisDronePageController;
use App\Http\Controllers\BookingCrewPageController;
use App\Http\Controllers\BookingDronePageController;



use App\Http\Controllers\PortofolioPenjualanController;
use App\Http\Controllers\PortofolioServisDroneController;
use App\Http\Controllers\PortofolioDaratController;
use App\Http\Controllers\PortofolioUdaraController;



use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;








ï»¿






Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Public Pages (tanpa login)
|--------------------------------------------------------------------------
*/
Route::view('/about', 'about')->name('about');
Route::view('/portfolio', 'portfolio')->name('portfolio');
Route::view('/services', 'services')->name('services');

/*
|--------------------------------------------------------------------------
| Order (untuk tombol "Pesan Sekarang" di welcome.blade.php)
|--------------------------------------------------------------------------
*/
Route::get('/order', function () {
    return 'Halaman Order (sementara)';
})->name('order.start');

/*
|--------------------------------------------------------------------------
| User Dashboard (wajib login + wajib verifikasi email)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile (wajib login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Admin Routes (Satu login saja)
|--------------------------------------------------------------------------
| Admin login dari /login biasa (Breeze).
| Setelah login, admin akses: /admin/dashboard
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // OPTIONAL: kalau butuh halaman lain di admin, tambah di sini
        // Route::get('/users', ...)->name('users.index');
    });


// scaffold:portofolio

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('portofolio-udara', PortofolioUdaraController::class);
    Route::resource('portofolio-darat', PortofolioDaratController::class);
    Route::resource('portofolio-servis-drone', PortofolioServisDroneController::class);
    Route::resource('portofolio-penjualan', PortofolioPenjualanController::class);
});



// Public pages (auto)
Route::get('/booking-jasa-drone', [BookingDronePageController::class, 'index'])->name('booking.drone');
Route::post('/booking-jasa-drone', [BookingDronePageController::class, 'store'])->name('booking.drone.submit');

Route::get('/booking-photographer-videographer', [BookingCrewPageController::class, 'index'])->name('booking.crews');
Route::post('/booking-photographer-videographer', [BookingCrewPageController::class, 'store'])->name('booking.crews.submit');

Route::get('/servis-unit-drone', [ServisDronePageController::class, 'index'])->name('servis.drone');
Route::post('/servis-unit-drone', [ServisDronePageController::class, 'store'])->name('servis.drone.submit');

Route::get('/order-unit-drone', [OrderDronePageController::class, 'index'])->name('order.drone');
Route::post('/order-unit-drone', [OrderDronePageController::class, 'store'])->name('order.drone.submit');


