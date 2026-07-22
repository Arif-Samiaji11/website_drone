<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;

use App\Http\Controllers\PortofolioPenjualanController;
use App\Http\Controllers\PortofolioServisDroneController;
use App\Http\Controllers\PortofolioDaratController;
use App\Http\Controllers\PortofolioUdaraController;

use App\Http\Controllers\OrderDronePageController;
use App\Http\Controllers\ServisDronePageController;

use App\Http\Controllers\BookingCrewPageController;
use App\Http\Controllers\BookingDronePageController;

use App\Models\User;
use Illuminate\Http\Request;

// ✅ tambah controller admin layanan & paket darat
use App\Http\Controllers\Admin\AdminDaftarLayananDaratController;
use App\Http\Controllers\Admin\AdminDaftarPaketLayananDaratController;

use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\Admin\AdminDiscussionController;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/
Route::get('/', HomeController::class)->name('home');
Route::post('/check-email', function (Request $request) {
    $exists = User::where('email', $request->email)->exists();
    return response()->json(['exists' => $exists]);
});
/*
|--------------------------------------------------------------------------
| Public Pages (tanpa login)
|--------------------------------------------------------------------------
*/
Route::view('/about', 'about')->name('about');
Route::view('/portfolio', 'portfolio')->name('portfolio');
Route::view('/services', 'services')->name('services');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');

/*
|--------------------------------------------------------------------------
| Order (sementara / tombol "Pesan Sekarang")
|--------------------------------------------------------------------------
*/
Route::get('/order', function () {
    return 'Halaman Order (sementara)';
})->name('order.start');

/*
|--------------------------------------------------------------------------
| User Dashboard (wajib login + verifikasi email)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'client'])->name('dashboard');

Route::middleware(['auth', 'verified', 'client'])->group(function () {
    Route::get('/diskusi', [DiscussionController::class, 'index'])->name('diskusi.index');
    Route::get('/diskusi/unread-count', [DiscussionController::class, 'getUnreadCount'])->name('diskusi.unread-count');
    Route::get('/diskusi/unread-by-category', [DiscussionController::class, 'getUnreadByCategory'])->name('diskusi.unread-by-category');
    Route::get('/diskusi/{service_type}', [DiscussionController::class, 'chat'])->name('diskusi.chat');
    Route::post('/diskusi/{service_type}/send', [DiscussionController::class, 'sendMessage'])->name('diskusi.send');
    Route::get('/diskusi/{service_type}/messages', [DiscussionController::class, 'getMessages'])->name('diskusi.messages');
});

/*
|--------------------------------------------------------------------------
| Profile (wajib login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'client'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Admin Routes (wajib login + admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/fetch-latest', [AdminDashboardController::class, 'fetchLatest'])->name('dashboard.fetch-latest');

        /*
        |--------------------------------------------------------------
        | Admin Resources (Portofolio)
        |--------------------------------------------------------------
        */
        Route::resource('portofolio-udara', PortofolioUdaraController::class);
        Route::resource('portofolio-darat', PortofolioDaratController::class);
        Route::resource('portofolio-servis-drone', PortofolioServisDroneController::class);
        Route::resource('portofolio-penjualan', PortofolioPenjualanController::class);

        /*
        |--------------------------------------------------------------
        | ✅ Master Data Layanan Darat + Paket (untuk booking modal)
        | URL:
        | - /admin/layanan-darat
        | - /admin/paket-layanan-darat
        |--------------------------------------------------------------
        */
        Route::resource('layanan-darat', AdminDaftarLayananDaratController::class);
        Route::resource('paket-layanan-darat', AdminDaftarPaketLayananDaratController::class);

        // ✅ Kelola Diskusi User
        Route::get('/diskusi', [AdminDiscussionController::class, 'index'])->name('diskusi.index');
        Route::get('/diskusi-unread-count', [AdminDiscussionController::class, 'getUnreadCount'])->name('diskusi.unread-count');
        Route::get('/diskusi-list-status', [AdminDiscussionController::class, 'getListStatus'])->name('diskusi.list-status');
        Route::get('/diskusi/{discussion}', [AdminDiscussionController::class, 'show'])->name('diskusi.show');
        Route::post('/diskusi/{discussion}/send', [AdminDiscussionController::class, 'sendMessage'])->name('diskusi.send');
        Route::get('/diskusi/{discussion}/messages', [AdminDiscussionController::class, 'getMessages'])->name('diskusi.messages');

        // ✅ Pengaturan Admin (No. Rek & Lokasi Leaflet)
        Route::get('/setting', [\App\Http\Controllers\Admin\AdminSettingController::class, 'edit'])->name('setting.edit');
        Route::post('/setting', [\App\Http\Controllers\Admin\AdminSettingController::class, 'update'])->name('setting.update');

        // ✅ Kelola Form Submissions Client
        Route::get('/submissions-new-count', [\App\Http\Controllers\Admin\AdminBookingOrderController::class, 'getNewSubmissionsCount'])->name('submissions.new-count');
        Route::get('/submissions/fetch-new', [\App\Http\Controllers\Admin\AdminBookingOrderController::class, 'fetchNew'])->name('submissions.fetch-new');
        Route::post('/submissions/proses', [\App\Http\Controllers\Admin\AdminBookingOrderController::class, 'prosesSubmission'])->name('submissions.proses');
        Route::get('/booking-drone', [\App\Http\Controllers\Admin\AdminBookingOrderController::class, 'bookingDroneIndex'])->name('booking-drone.index');
        Route::delete('/booking-drone/{bookingDrone}', [\App\Http\Controllers\Admin\AdminBookingOrderController::class, 'bookingDroneDestroy'])->name('booking-drone.destroy');

        Route::get('/booking-crews', [\App\Http\Controllers\Admin\AdminBookingOrderController::class, 'bookingCrewIndex'])->name('booking-crews.index');
        Route::delete('/booking-crews/{bookingCrew}', [\App\Http\Controllers\Admin\AdminBookingOrderController::class, 'bookingCrewDestroy'])->name('booking-crews.destroy');

        Route::get('/servis-drone', [\App\Http\Controllers\Admin\AdminBookingOrderController::class, 'servisDroneIndex'])->name('servis-drone.index');
        Route::delete('/servis-drone/{servisDrone}', [\App\Http\Controllers\Admin\AdminBookingOrderController::class, 'servisDroneDestroy'])->name('servis-drone.destroy');

        Route::get('/order-drone', [\App\Http\Controllers\Admin\AdminBookingOrderController::class, 'orderDroneIndex'])->name('order-drone.index');
        Route::delete('/order-drone/{orderDrone}', [\App\Http\Controllers\Admin\AdminBookingOrderController::class, 'orderDroneDestroy'])->name('order-drone.destroy');
    });

Route::middleware(['auth', 'client'])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Booking Jasa Drone
    |--------------------------------------------------------------------------
    */
    Route::get('/booking-jasa-drone', [BookingDronePageController::class, 'index'])
        ->name('booking.drone');
    Route::post('/booking-jasa-drone', [BookingDronePageController::class, 'store'])
        ->name('booking.drone.submit');

    /*
    |--------------------------------------------------------------------------
    | Booking Photographer / Videographer (FLOW MODAL -> FORM -> SUBMIT)
    |--------------------------------------------------------------------------
    */
    Route::get('/booking-photographer-videographer', [BookingCrewPageController::class, 'index'])
        ->name('booking.crews');
    Route::get('/booking-photographer-videographer/form', [BookingCrewPageController::class, 'form'])
        ->name('booking.crews.form');
    Route::post('/booking-photographer-videographer', [BookingCrewPageController::class, 'store'])
        ->name('booking.crews.submit');

    /*
    |--------------------------------------------------------------------------
    | Servis Unit Drone
    |--------------------------------------------------------------------------
    */
    Route::get('/servis-unit-drone', [ServisDronePageController::class, 'index'])
        ->name('servis.drone');
    Route::post('/servis-unit-drone', [ServisDronePageController::class, 'store'])
        ->name('servis.drone.submit');

    /*
    |--------------------------------------------------------------------------
    | Order Unit Drone
    |--------------------------------------------------------------------------
    */
    Route::get('/order-unit-drone', [OrderDronePageController::class, 'index'])
        ->name('order.drone');
    Route::post('/order-unit-drone', [OrderDronePageController::class, 'store'])
        ->name('order.drone.submit');
});
