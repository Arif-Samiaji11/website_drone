<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-white leading-tight">
        {{ __('Dashboard') }}
      </h2>
    </div>
  </x-slot>

  <!-- Google Fonts & FontAwesome (Sesuai dengan welcome.blade.php) -->
  <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">

  <!-- Style Khusus Tema Slate-Blue / Navy Cinematic -->
  <style>
    .vg-theme {
      font-family: 'Play', sans-serif;
      background-color: #1a2035;
      color: #fff;
    }
    
    .vg-hero-card {
      position: relative;
      background: linear-gradient(135deg, #202940 0%, #151a30 100%);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 24px;
      padding: 40px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
      border-left: 3px solid #00c7ff !important;
    }

    /* Tombol Luxury */
    .vg-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      padding: 13px 26px;
      border-radius: 999px;
      font-weight: 600;
      letter-spacing: 0.6px;
      border: 1px solid rgba(255,255,255,0.22);
      background: rgba(255,255,255,0.08);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      color: #fff !important;
      transition: all 0.25s ease;
      text-transform: uppercase;
      font-size: 13px;
      text-decoration: none !important;
      cursor: pointer;
    }

    .vg-btn:hover {
      background: rgba(255,255,255,0.16);
      border-color: rgba(255,255,255,0.35);
      transform: translateY(-2px);
    }

    .vg-btn-primary {
      background: #e53637;
      border-color: #e53637;
    }

    .vg-btn-primary:hover {
      background: transparent;
      color: #e53637 !important;
      border-color: #e53637;
    }

    /* Style Card Layanan */
    .vg-status-card {
      background: #202940;
      border: 1px solid rgba(255, 255, 255, 0.06);
      border-radius: 16px;
      padding: 30px;
      transition: all 0.3s ease;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .vg-status-card:hover {
      border-color: rgba(0, 199, 255, 0.45);
      background: #242f4c;
      transform: translateY(-3px);
    }

    .vg-status-card__icon {
      width: 64px;
      height: 64px;
      border: 1px solid rgba(0, 199, 255, 0.55);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
      color: #00c7ff;
      font-size: 22px;
    }

    .vg-status-card h4 {
      color: #ffffff;
      font-weight: 700;
      margin-bottom: 12px;
      text-transform: uppercase;
      font-size: 16px;
      letter-spacing: 1px;
    }

    .vg-status-card p {
      color: rgba(255, 255, 255, 0.7);
      font-family: "Josefin Sans", sans-serif;
      font-size: 14px;
      line-height: 1.6;
      margin: 0;
    }
  </style>

  @php
    $safe = function ($name) {
      return \Illuminate\Support\Facades\Route::has($name) ? route($name) : '#';
    };
  @endphp

  <!-- Area Konten Utama (Slate-Blue / Navy Theme) -->
  <div class="py-12 vg-theme min-h-[calc(100vh-12rem)]">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      {{-- Hero card --}}
      <div class="vg-hero-card">
        <div class="text-xs uppercase tracking-widest font-bold mb-2" style="color: #00c7ff; font-family: 'Josefin Sans', sans-serif;">
          Website Resmi Mriki_Project
        </div>
        <div class="text-3xl md:text-4xl font-bold">
          Selamat datang, {{ auth()->user()->name ?? 'User' }} 👋
        </div>
        <div class="mt-3 text-white/70" style="font-family: 'Josefin Sans', sans-serif; font-size: 16px;">
          Kamu sudah login. Silakan pilih layanan yang ingin kamu gunakan.
        </div>

        <div class="mt-8 flex flex-wrap gap-3">
          <a href="{{ $safe('booking.drone') }}" class="vg-btn vg-btn-primary">
            Booking Jasa Drone
          </a>
          <a href="{{ $safe('booking.crews') }}" class="vg-btn">
            Photographer / Videographer
          </a>
          <a href="{{ $safe('servis.drone') }}" class="vg-btn">
            Servis Unit Drone
          </a>
          <a href="{{ $safe('order.drone') }}" class="vg-btn">
            Order Unit Drone
          </a>
        </div>
      </div>

      {{-- Grid Status --}}
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
        
        {{-- Card 1: Status --}}
        <div class="vg-status-card">
          <div class="vg-status-card__icon">
            <i class="fa fa-user-circle-o"></i>
          </div>
          <h4>Status</h4>
          <p class="font-bold text-emerald-400">
            Login aktif ✅
          </p>
        </div>

        {{-- Card 2: Email --}}
        <div class="vg-status-card">
          <div class="vg-status-card__icon">
            <i class="fa fa-envelope-o"></i>
          </div>
          <h4>Email</h4>
          <p class="truncate text-white" title="{{ auth()->user()->email }}">
            {{ auth()->user()->email }}
          </p>
        </div>

        {{-- Card 3: Akun --}}
        <div class="vg-status-card">
          <div class="vg-status-card__icon">
            <i class="fa fa-shield"></i>
          </div>
          <h4>Tipe Akun</h4>
          <p class="text-white">
            {{ (auth()->user()->is_admin ?? false) ? 'Administrator' : 'User' }}
          </p>
        </div>

        {{-- Card 4: Menu --}}
        <div class="vg-status-card">
          <div class="vg-status-card__icon">
            <i class="fa fa-list"></i>
          </div>
          <h4>Daftar Layanan</h4>
          <p class="text-white/70">
            Akses cepat menu layanan
          </p>
        </div>

      </div>

    </div>
  </div>
</x-app-layout>