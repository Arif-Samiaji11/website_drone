<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <link rel="icon" type="image/png" href="{{ asset('favicon-256.png') }}">

  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', 'Admin')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">
  <div class="min-h-screen flex">

    {{-- SIDEBAR (LIGHT / MODERN) --}}
    <aside class="w-64 hidden md:flex md:flex-col
                  bg-white/95 backdrop-blur
                  border-r border-slate-200
                  shadow-[0_1px_0_rgba(15,23,42,0.04)]">

      {{-- Brand --}}
      <div class="px-5 py-5 border-b border-slate-200">
        <div class="flex items-center gap-3">
          <img src="{{ asset('img/logo.png') }}" alt="Mriki Project" class="w-32 h-32 w-13 h-13 object-contain" class="w-28 h-28 w-13 h-13 object-contain" class="w-26 h-26 w-13 h-13 object-contain" class="w-12 h-12 w-13 h-13 object-contain" class="w-25 h-25 w-13 h-13 object-contain" class="w-21 h-21 w-13 h-13 object-contain" class="w-15 h-15 w-13 h-13 object-contain" class="w-12 h-12 w-13 h-13 object-contain" class="w-13 h-13 w-13 h-13 object-contain" class="w-12 h-12 w-13 h-13 object-contain" class="w-12 h-12 w-13 h-13 object-contain" class="w-13 h-13 w-13 h-13 object-contain" class="w-13 h-13 w-13 h-13 object-contain" class="w-13 h-13 object-contain">

          <div>
            <div class="font-extrabold text-base tracking-wide">Mriki Admin</div>
            <div class="text-xs text-slate-500">Control Panel</div>
          </div>
        </div>
      </div>

      {{-- Nav --}}
      <nav class="px-3 py-4 space-y-1 flex-1">
        <a href="{{ route('admin.dashboard') }}"
           class="group flex items-center gap-3 px-3 py-2 rounded-xl border transition
                  {{ request()->routeIs('admin.dashboard')
                      ? 'bg-red-50 border-red-200 text-red-700'
                      : 'bg-white border-transparent text-slate-700 hover:bg-slate-50 hover:border-slate-200' }}">

          <span class="w-8 h-8 rounded-lg flex items-center justify-center
                       {{ request()->routeIs('admin.dashboard')
                           ? 'bg-red-100 text-red-700'
                           : 'bg-slate-100 text-slate-600 group-hover:bg-slate-200' }}">
            <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4 10.5V20a1 1 0 0 0 1 1h4v-7H4z" stroke="currentColor" stroke-width="1.6"/>
              <path d="M10 21h4V3h-4v18z" stroke="currentColor" stroke-width="1.6"/>
              <path d="M15 21h4a1 1 0 0 0 1-1v-6.5h-5V21z" stroke="currentColor" stroke-width="1.6"/>
            </svg>
          </span>

          <div class="flex-1">
            <div class="font-semibold leading-none">Dashboard</div>
            <div class="text-xs text-slate-500 mt-1">Ringkasan data</div>
          </div>
        </a>

        {{-- PORTOFOLIO MENUS (AUTO) --}}

        <a href="{{ route('admin.portofolio-udara.index') }}"
           class="group flex items-center gap-3 px-3 py-2 rounded-xl border transition
                  {{ request()->is('admin/portofolio-udara*')
                      ? 'bg-red-50 border-red-200 text-red-700'
                      : 'bg-white border-transparent text-slate-700 hover:bg-slate-50 hover:border-slate-200' }}">

          <span class="w-8 h-8 rounded-lg flex items-center justify-center
                       {{ request()->is('admin/portofolio-udara*')
                           ? 'bg-red-100 text-red-700'
                           : 'bg-slate-100 text-slate-600 group-hover:bg-slate-200' }}">
            <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="1.6"/>
            </svg>
          </span>

          <div class="flex-1">
            <div class="font-semibold leading-none">Kelola Portofolio Jasa Udara Drone</div>
            <div class="text-xs text-slate-500 mt-1">Project jasa udara</div>
          </div>
        </a>
        <a href="{{ route('admin.portofolio-darat.index') }}"
           class="group flex items-center gap-3 px-3 py-2 rounded-xl border transition
                  {{ request()->is('admin/portofolio-darat*')
                      ? 'bg-red-50 border-red-200 text-red-700'
                      : 'bg-white border-transparent text-slate-700 hover:bg-slate-50 hover:border-slate-200' }}">

          <span class="w-8 h-8 rounded-lg flex items-center justify-center
                       {{ request()->is('admin/portofolio-darat*')
                           ? 'bg-red-100 text-red-700'
                           : 'bg-slate-100 text-slate-600 group-hover:bg-slate-200' }}">
            <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="1.6"/>
            </svg>
          </span>

          <div class="flex-1">
            <div class="font-semibold leading-none">Kelola Portofolio Jasa Darat</div>
            <div class="text-xs text-slate-500 mt-1">Project jasa darat</div>
          </div>
        </a>
        <a href="{{ route('admin.portofolio-servis-drone.index') }}"
           class="group flex items-center gap-3 px-3 py-2 rounded-xl border transition
                  {{ request()->is('admin/portofolio-servis-drone*')
                      ? 'bg-red-50 border-red-200 text-red-700'
                      : 'bg-white border-transparent text-slate-700 hover:bg-slate-50 hover:border-slate-200' }}">

          <span class="w-8 h-8 rounded-lg flex items-center justify-center
                       {{ request()->is('admin/portofolio-servis-drone*')
                           ? 'bg-red-100 text-red-700'
                           : 'bg-slate-100 text-slate-600 group-hover:bg-slate-200' }}">
            <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="1.6"/>
            </svg>
          </span>

          <div class="flex-1">
            <div class="font-semibold leading-none">Kelola Portofolio Jasa Servis Drone</div>
            <div class="text-xs text-slate-500 mt-1">Servis & perbaikan drone</div>
          </div>
        </a>
        <a href="{{ route('admin.portofolio-penjualan.index') }}"
           class="group flex items-center gap-3 px-3 py-2 rounded-xl border transition
                  {{ request()->is('admin/portofolio-penjualan*')
                      ? 'bg-red-50 border-red-200 text-red-700'
                      : 'bg-white border-transparent text-slate-700 hover:bg-slate-50 hover:border-slate-200' }}">

          <span class="w-8 h-8 rounded-lg flex items-center justify-center
                       {{ request()->is('admin/portofolio-penjualan*')
                           ? 'bg-red-100 text-red-700'
                           : 'bg-slate-100 text-slate-600 group-hover:bg-slate-200' }}">
            <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="1.6"/>
            </svg>
          </span>

          <div class="flex-1">
            <div class="font-semibold leading-none">Kelola Portofolio Penjualan</div>
            <div class="text-xs text-slate-500 mt-1">Produk & penjualan</div>
          </div>
        </a>

        {{-- MENU DISKUSI USER --}}
        <a href="{{ route('admin.diskusi.index') }}"
           class="group flex items-center gap-3 px-3 py-2 rounded-xl border transition
                  {{ request()->is('admin/diskusi*')
                      ? 'bg-red-50 border-red-200 text-red-700'
                      : 'bg-white border-transparent text-slate-700 hover:bg-slate-50 hover:border-slate-200' }}">

          <span class="w-8 h-8 rounded-lg flex items-center justify-center
                       {{ request()->is('admin/diskusi*')
                           ? 'bg-red-100 text-red-700'
                           : 'bg-slate-100 text-slate-600 group-hover:bg-slate-200' }}">
            <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>

          <div class="flex-1 flex items-center justify-between">
            <div>
              <div class="font-semibold leading-none">Diskusi User</div>
              <div class="text-xs text-slate-500 mt-1">Pesan dari client</div>
            </div>
            @php
              $adminUnreadCount = \App\Models\DiscussionMessage::where('sender_id', '!=', auth()->id())->where('is_read', false)->count();
            @endphp
            <span class="admin-unread-badge bg-red-600 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full leading-none shadow-sm" style="{{ $adminUnreadCount > 0 ? '' : 'display: none;' }}">
              {{ $adminUnreadCount }}
            </span>
          </div>
        </a>

        {{-- PENGATURAN LOKASI & REKENING --}}
        <a href="{{ route('admin.setting.edit') }}"
           class="group flex items-center gap-3 px-3 py-2 rounded-xl border transition
                  {{ request()->is('admin/setting*')
                      ? 'bg-red-50 border-red-200 text-red-700'
                      : 'bg-white border-transparent text-slate-700 hover:bg-slate-50 hover:border-slate-200' }}">

          <span class="w-8 h-8 rounded-lg flex items-center justify-center
                       {{ request()->is('admin/setting*')
                           ? 'bg-red-100 text-red-700'
                           : 'bg-slate-100 text-slate-600 group-hover:bg-slate-200' }}">
            <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.6" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="12" r="3"/>
              <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
            </svg>
          </span>

          <div class="flex-1">
            <div class="font-semibold leading-none">Pengaturan Lokasi & Rekening</div>
            <div class="text-xs text-slate-500 mt-1">Nomor rekening & maps</div>
          </div>
        </a>

        <!-- PENGIRIMAN CLIENT (SUBMISSIONS) -->
        <div class="pt-4 pb-2 px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400">
          Submissions Client
        </div>

        <a href="{{ route('admin.booking-drone.index') }}"
           class="group flex items-center gap-3 px-3 py-2 rounded-xl border transition
                  {{ request()->is('admin/booking-drone*')
                      ? 'bg-red-50 border-red-200 text-red-700'
                      : 'bg-white border-transparent text-slate-700 hover:bg-slate-50 hover:border-slate-200' }}">
          <span class="w-8 h-8 rounded-lg flex items-center justify-center
                       {{ request()->is('admin/booking-drone*')
                           ? 'bg-red-100 text-red-700'
                           : 'bg-slate-100 text-slate-600 group-hover:bg-slate-200' }}">
            <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.6" xmlns="http://www.w3.org/2000/svg">
              <path d="M19 4H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z"/>
              <path d="M16 2v4M8 2v4M3 10h18"/>
            </svg>
          </span>
          <div class="flex-1 flex items-center justify-between">
            <div>
              <div class="font-semibold leading-none">Booking Drone</div>
              <div class="text-xs text-slate-500 mt-1">Jasa drone udara</div>
            </div>
            @php
              $newBookingDrone = \App\Models\BookingDrone::where('status', 'baru')->count();
            @endphp
            <span class="sidebar-new-booking-drone bg-red-600 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full leading-none shadow-sm" style="{{ $newBookingDrone > 0 ? '' : 'display: none;' }}">
              {{ $newBookingDrone }}
            </span>
          </div>
        </a>

        <a href="{{ route('admin.booking-crews.index') }}"
           class="group flex items-center gap-3 px-3 py-2 rounded-xl border transition
                  {{ request()->is('admin/booking-crews*')
                      ? 'bg-red-50 border-red-200 text-red-700'
                      : 'bg-white border-transparent text-slate-700 hover:bg-slate-50 hover:border-slate-200' }}">
          <span class="w-8 h-8 rounded-lg flex items-center justify-center
                       {{ request()->is('admin/booking-crews*')
                           ? 'bg-red-100 text-red-700'
                           : 'bg-slate-100 text-slate-600 group-hover:bg-slate-200' }}">
            <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.6" xmlns="http://www.w3.org/2000/svg">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
          </span>
          <div class="flex-1 flex items-center justify-between">
            <div>
              <div class="font-semibold leading-none">Booking Crews</div>
              <div class="text-xs text-slate-500 mt-1">Photographer & Videographer</div>
            </div>
            @php
              $newBookingCrew = \App\Models\BookingCrew::where('status', 'baru')->count();
            @endphp
            <span class="sidebar-new-booking-crew bg-red-600 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full leading-none shadow-sm" style="{{ $newBookingCrew > 0 ? '' : 'display: none;' }}">
              {{ $newBookingCrew }}
            </span>
          </div>
        </a>

        <a href="{{ route('admin.servis-drone.index') }}"
           class="group flex items-center gap-3 px-3 py-2 rounded-xl border transition
                  {{ request()->is('admin/servis-drone*')
                      ? 'bg-red-50 border-red-200 text-red-700'
                      : 'bg-white border-transparent text-slate-700 hover:bg-slate-50 hover:border-slate-200' }}">
          <span class="w-8 h-8 rounded-lg flex items-center justify-center
                       {{ request()->is('admin/servis-drone*')
                           ? 'bg-red-100 text-red-700'
                           : 'bg-slate-100 text-slate-600 group-hover:bg-slate-200' }}">
            <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.6" xmlns="http://www.w3.org/2000/svg">
              <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
            </svg>
          </span>
          <div class="flex-1 flex items-center justify-between">
            <div>
              <div class="font-semibold leading-none">Servis Drone</div>
              <div class="text-xs text-slate-500 mt-1">Pengajuan servis unit</div>
            </div>
            @php
              $newServisDrone = \App\Models\ServisDrone::where('status', 'baru')->count();
            @endphp
            <span class="sidebar-new-servis-drone bg-red-600 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full leading-none shadow-sm" style="{{ $newServisDrone > 0 ? '' : 'display: none;' }}">
              {{ $newServisDrone }}
            </span>
          </div>
        </a>

        <a href="{{ route('admin.order-drone.index') }}"
           class="group flex items-center gap-3 px-3 py-2 rounded-xl border transition
                  {{ request()->is('admin/order-drone*')
                      ? 'bg-red-50 border-red-200 text-red-700'
                      : 'bg-white border-transparent text-slate-700 hover:bg-slate-50 hover:border-slate-200' }}">
          <span class="w-8 h-8 rounded-lg flex items-center justify-center
                       {{ request()->is('admin/order-drone*')
                           ? 'bg-red-100 text-red-700'
                           : 'bg-slate-100 text-slate-600 group-hover:bg-slate-200' }}">
            <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.6" xmlns="http://www.w3.org/2000/svg">
              <circle cx="9" cy="21" r="1"/>
              <circle cx="20" cy="21" r="1"/>
              <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
            </svg>
          </span>
          <div class="flex-1 flex items-center justify-between">
            <div>
              <div class="font-semibold leading-none">Order Drone</div>
              <div class="text-xs text-slate-500 mt-1">Pembelian unit drone</div>
            </div>
            @php
              $newOrderDrone = \App\Models\OrderDrone::where('status', 'baru')->count();
            @endphp
            <span class="sidebar-new-order-drone bg-red-600 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full leading-none shadow-sm" style="{{ $newOrderDrone > 0 ? '' : 'display: none;' }}">
              {{ $newOrderDrone }}
            </span>
          </div>
        </a>
      </nav>

      {{-- ✅ LOGOUT DI POJOK KIRI BAWAH SIDEBAR --}}
      <div class="px-4 pb-4">
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm p-3">
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
              <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 7V6a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6a2 2 0 0 1-2-2v-1" stroke="currentColor" stroke-width="1.6"/>
                <path d="M3 12h10" stroke="currentColor" stroke-width="1.6"/>
                <path d="M7 8l-4 4 4 4" stroke="currentColor" stroke-width="1.6"/>
              </svg>
            </div>

            <div class="min-w-0">
              <div class="text-sm font-semibold text-slate-800 truncate">
                {{ auth()->user()->name ?? 'Admin' }}
              </div>
              <div class="text-xs text-slate-500 truncate">
                {{ auth()->user()->email ?? 'admin@mriki.test' }}
              </div>
            </div>
          </div>

          <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit"
              class="w-full px-3 py-2 rounded-xl bg-red-600 text-white font-semibold
                     hover:bg-red-500 transition shadow-sm">
              Logout
            </button>
          </form>
        </div>
      </div>

      {{-- Footer sidebar --}}
      <div class="px-5 py-4 border-t border-slate-200 text-xs text-slate-500">
        © <script>document.write(new Date().getFullYear())</script> Mriki_Project
      </div>
    </aside>

    {{-- MAIN --}}
    <main class="flex-1">
      {{-- TOPBAR (LIGHT) --}}
      <div class="flex items-center justify-between px-4 md:px-8 py-4
                  border-b border-slate-200 bg-white/80 backdrop-blur">
        <div class="md:hidden font-extrabold">Mriki Admin</div>

        {{-- ✅ Topbar sekarang tanpa tombol logout (sudah pindah ke sidebar) --}}
        <div class="flex items-center gap-3">
          <div class="text-sm text-slate-600">
            {{ auth()->user()->name ?? 'Admin' }}
          </div>
        </div>
      </div>

      {{-- CONTENT --}}
      <div class="p-4 md:p-8">
        @yield('content')
      </div>
    </main>

  </div>
  <!-- Global Toast Notification Container -->
  <div id="global-toast-container" class="fixed top-5 right-5 z-[99999] flex flex-col gap-3 w-80 pointer-events-none"></div>
</body>
<script>
    // Global Audio Chime (Web Audio API Synthesizer)
    window.playChime = function() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.type = 'sine';
            osc.frequency.setValueAtTime(587.33, ctx.currentTime); // D5
            osc.frequency.setValueAtTime(880, ctx.currentTime + 0.12); // A5
            gain.gain.setValueAtTime(0.08, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.35);
            osc.start(ctx.currentTime);
            osc.stop(ctx.currentTime + 0.35);
        } catch (e) {
            console.log("Audio Context play failed:", e);
        }
    };

    function spawnToast(title, message, linkUrl) {
        const container = document.getElementById('global-toast-container');
        if (!container) return;
        
        const toast = document.createElement('div');
        toast.className = 'w-full pointer-events-auto bg-white border border-slate-200 shadow-xl rounded-2xl p-4 flex gap-3 transform translate-x-12 opacity-0 transition-all duration-300 ease-out border-l-4 border-l-red-600';
        
        toast.innerHTML = `
            <div class="flex-1 min-w-0">
                <div class="text-xs font-extrabold uppercase tracking-wide text-red-600">Pemberitahuan Baru</div>
                <div class="text-sm font-bold text-slate-800 mt-1">${title}</div>
                <div class="text-xs text-slate-500 mt-1">${message}</div>
                <a href="${linkUrl}" class="inline-flex items-center gap-1 text-[10px] font-extrabold uppercase tracking-wide text-blue-600 hover:text-blue-500 mt-2">
                    Lihat Data <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <button class="text-slate-400 hover:text-slate-600 self-start" onclick="this.parentNode.remove()">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        `;
        
        container.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.remove('translate-x-12', 'opacity-0');
        }, 10);
        
        setTimeout(() => {
            toast.classList.add('translate-x-12', 'opacity-0');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 5000);
    }

    document.addEventListener("DOMContentLoaded", function() {
        const adminBadge = document.querySelector('.admin-unread-badge');
        const badgeDrone = document.querySelector('.sidebar-new-booking-drone');
        const badgeCrew = document.querySelector('.sidebar-new-booking-crew');
        const badgeServis = document.querySelector('.sidebar-new-servis-drone');
        const badgeOrder = document.querySelector('.sidebar-new-order-drone');

        let lastCounts = {
            booking_drone: null,
            booking_crew: null,
            servis_drone: null,
            order_drone: null
        };

        function checkAdminUnread() {
            fetch("{{ route('admin.diskusi.unread-count') }}")
                .then(res => res.json())
                .then(data => {
                    const count = data.count;
                    if (adminBadge) {
                        if (count > 0) {
                            adminBadge.textContent = count;
                            adminBadge.style.display = 'inline-block';
                        } else {
                            adminBadge.style.display = 'none';
                        }
                    }
                })
                .catch(err => console.error("Error checking admin unread:", err));
        }

        function checkAdminSubmissions() {
            fetch("{{ route('admin.submissions.new-count') }}")
                .then(res => res.json())
                .then(data => {
                    updateBadge(badgeDrone, data.booking_drone.count);
                    updateBadge(badgeCrew, data.booking_crew.count);
                    updateBadge(badgeServis, data.servis_drone.count);
                    updateBadge(badgeOrder, data.order_drone.count);

                    checkForNewSubmissions('booking_drone', data.booking_drone, 'Booking Jasa Drone Baru', "{{ route('admin.booking-drone.index') }}");
                    checkForNewSubmissions('booking_crew', data.booking_crew, 'Booking Crew Baru', "{{ route('admin.booking-crews.index') }}");
                    checkForNewSubmissions('servis_drone', data.servis_drone, 'Permintaan Servis Drone Baru', "{{ route('admin.servis-drone.index') }}");
                    checkForNewSubmissions('order_drone', data.order_drone, 'Permintaan Order Drone Baru', "{{ route('admin.order-drone.index') }}");
                })
                .catch(err => console.error("Error checking new submissions:", err));
        }

        function checkForNewSubmissions(key, categoryData, title, linkUrl) {
            const currentCount = categoryData.count;
            const lastCount = lastCounts[key];
            
            if (lastCount !== null && currentCount > lastCount) {
                const latestName = (categoryData.latest && categoryData.latest.nama) ? categoryData.latest.nama : 'Client';
                const message = `Ada pengajuan ${title.toLowerCase()} dari <b>${latestName}</b>.`;
                
                window.playChime();
                spawnToast(title, message, linkUrl);
            }
            
            lastCounts[key] = currentCount;
        }

        function updateBadge(el, count) {
            if (el) {
                if (count > 0) {
                    el.textContent = count;
                    el.style.display = 'inline-block';
                } else {
                    el.style.display = 'none';
                }
            }
        }

        checkAdminUnread();
        checkAdminSubmissions();
        setInterval(function() {
            checkAdminUnread();
            checkAdminSubmissions();
        }, 4000);
    });
</script>
</html>
