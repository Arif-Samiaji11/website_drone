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

    /* Table Container Styling */
    .vg-table-container {
      background: #202940;
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 24px;
      overflow: hidden;
      margin-top: 35px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
    }

    .vg-table-header {
      background: rgba(255, 255, 255, 0.02);
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      padding: 24px 30px;
    }
  </style>

  @php
    $safe = function ($name) {
      return \Illuminate\Support\Facades\Route::has($name) ? route($name) : '#';
    };

    $userEmail = auth()->user()->email;

    $myBookingDrones = \App\Models\BookingDrone::where('email', $userEmail)->latest()->get()->map(function ($item) {
        $item->submission_type = 'booking_drone';
        $item->submission_label = 'Booking Jasa Drone';
        $item->badge_color = 'bg-blue-500/20 text-blue-300 border border-blue-500/30';
        $item->chat_param = 'booking_drone';
        return $item;
    });

    $myBookingCrews = \App\Models\BookingCrew::where('email', $userEmail)->latest()->get()->map(function ($item) {
        $item->submission_type = 'booking_crew';
        $item->submission_label = 'Photographer & Videographer';
        $item->badge_color = 'bg-purple-500/20 text-purple-300 border border-purple-500/30';
        $item->chat_param = 'booking_crews';
        return $item;
    });

    $myOrderDrones = \App\Models\OrderDrone::where('email', $userEmail)->latest()->get()->map(function ($item) {
        $item->submission_type = 'order_drone';
        $item->submission_label = 'Order Unit Drone';
        $item->badge_color = 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30';
        $item->chat_param = 'order_drone';
        return $item;
    });

    $myServisDrones = \App\Models\ServisDrone::where('email', $userEmail)->latest()->get()->map(function ($item) {
        $item->submission_type = 'servis_drone';
        $item->submission_label = 'Servis Unit Drone';
        $item->badge_color = 'bg-amber-500/20 text-amber-300 border border-amber-500/30';
        $item->chat_param = 'servis_drone';
        return $item;
    });

    $mySubmissions = collect()
        ->merge($myBookingDrones)
        ->merge($myBookingCrews)
        ->merge($myOrderDrones)
        ->merge($myServisDrones)
        ->sortByDesc('created_at');

    $totalSubmissions = $mySubmissions->count();
  @endphp

  <!-- Area Konten Utama (Slate-Blue / Navy Theme) -->
  <div class="py-12 vg-theme min-h-[calc(100vh-12rem)] pb-20">
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
        <a href="{{ route('profile.edit') }}" class="vg-status-card block hover:no-underline">
          <div class="vg-status-card__icon">
            <i class="fa fa-user-circle-o"></i>
          </div>
          <h4>Status</h4>
          <p class="font-bold text-emerald-400">
            Login aktif ✅
          </p>
        </a>

        {{-- Card 2: Email --}}
        <a href="{{ route('profile.edit') }}" class="vg-status-card block hover:no-underline">
          <div class="vg-status-card__icon">
            <i class="fa fa-envelope-o"></i>
          </div>
          <h4>Email</h4>
          <p class="truncate text-white" title="{{ auth()->user()->email }}">
            {{ auth()->user()->email }}
          </p>
        </a>

        {{-- Card 3: Akun --}}
        <a href="{{ (auth()->user()->is_admin ?? false) ? route('admin.dashboard') : route('profile.edit') }}" class="vg-status-card block hover:no-underline">
          <div class="vg-status-card__icon">
            <i class="fa fa-shield"></i>
          </div>
          <h4>Tipe Akun</h4>
          <p class="text-white">
            {{ (auth()->user()->is_admin ?? false) ? 'Administrator' : 'User' }}
          </p>
        </a>

        {{-- Card 4: Total Pengajuan --}}
        <a href="#riwayat-pengajuan" class="vg-status-card block hover:no-underline">
          <div class="vg-status-card__icon">
            <i class="fa fa-list"></i>
          </div>
          <h4>Total Pengajuan</h4>
          <p class="text-white font-bold">
            {{ $totalSubmissions }} Transaksi
          </p>
        </a>

      </div>

      {{-- Table Riwayat Pengajuan --}}
      <div class="vg-table-container" id="riwayat-pengajuan">
        <div class="vg-table-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <div>
            <h3 class="text-lg font-bold text-white">Riwayat Pengajuan & Pemesanan Anda</h3>
            <p class="text-xs text-white/50 mt-1">Daftar semua permintaan dan status booking yang terhubung dengan akun Anda.</p>
          </div>
          @if(Route::has('diskusi.index'))
            <a href="{{ route('diskusi.index') }}" class="vg-btn text-xs" style="padding: 8px 16px; border-radius: 8px; font-size: 11px;">
              <i class="fa fa-comments mr-1"></i> Buka Diskusi Chat
            </a>
          @endif
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse text-sm">
            <thead>
              <tr class="bg-white/[0.02] border-b border-white/10 text-white/60 font-semibold text-xs uppercase tracking-wider">
                <th class="px-6 py-4">Layanan</th>
                <th class="px-6 py-4">Detail Pengajuan</th>
                <th class="px-6 py-4">DP & Bukti Bayar</th>
                <th class="px-6 py-4">Tanggal Masuk</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
              @forelse($mySubmissions as $item)
                <tr class="hover:bg-white/[0.02] transition">
                  <!-- Service Type -->
                  <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-bold {{ $item->badge_color }}">
                      {{ $item->submission_label }}
                    </span>
                  </td>
                  
                  <!-- Detail -->
                  <td class="px-6 py-4">
                    @if($item->submission_type === 'booking_crew')
                      <div class="font-bold text-white uppercase">{{ $item->layanan }}</div>
                      <div class="text-xs text-white/60 mt-0.5">Paket: {{ $item->paket }}</div>
                    @else
                      <div class="text-white font-medium max-w-xs truncate" title="{{ $item->catatan }}">{{ $item->catatan ?? '-' }}</div>
                    @endif

                    @if($item->lokasi)
                      <div class="text-xs text-white/50 mt-1"><i class="fa fa-map-marker text-[#00c7ff] mr-1"></i>{{ $item->lokasi }}</div>
                    @endif
                  </td>

                  <!-- DP Payment -->
                  <td class="px-6 py-4 text-white">
                    <div class="font-bold">{{ $item->dp_booking_tanggal ? 'Rp ' . number_format($item->dp_booking_tanggal, 0, ',', '.') : '-' }}</div>
                    @if($item->bukti_pembayaran_dp)
                      <button type="button" onclick="showImageModal('{{ asset('storage/' . $item->bukti_pembayaran_dp) }}')" class="text-xs text-[#00c7ff] hover:underline font-semibold mt-1 block border-0 bg-transparent p-0 cursor-pointer">
                        <i class="fa fa-image mr-1"></i> Lihat Bukti
                      </button>
                    @else
                      <span class="text-xs text-white/40 mt-1 block">Tidak ada bukti</span>
                    @endif
                  </td>

                  <!-- Created At -->
                  <td class="px-6 py-4 text-white/60 text-xs">
                    <div>{{ $item->created_at->format('d M Y H:i') }}</div>
                    <div class="text-white/40 mt-1">{{ $item->created_at->diffForHumans() }}</div>
                  </td>

                  <!-- Status -->
                  <td class="px-6 py-4">
                    @if($item->status === 'baru')
                      <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-blue-500/20 text-blue-300 border border-blue-500/30">
                        Baru
                      </span>
                    @else
                      <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        Proses
                      </span>
                    @endif
                  </td>

                  <!-- Action -->
                  <td class="px-6 py-4 text-right">
                    @if(Route::has('diskusi.chat'))
                      <a href="{{ route('diskusi.chat', $item->chat_param) }}" class="inline-flex items-center px-3 py-1.5 bg-[#e53637] hover:bg-[#c22d2f] text-white font-bold text-xs uppercase tracking-wide rounded-lg transition" style="text-decoration: none;">
                        <i class="fa fa-comments mr-1"></i> Chat Admin
                      </a>
                    @else
                      <span class="text-white/30 text-xs">-</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="px-6 py-16 text-center text-white/50">
                    <div class="flex flex-col items-center justify-center gap-3">
                      <i class="fa fa-folder-open-o text-white/20 text-4xl"></i>
                      <div class="font-medium text-white/70">Belum ada riwayat pengajuan pemesanan.</div>
                      <div class="text-xs text-white/40 max-w-sm">Silakan pilih dan pesan salah satu layanan dari panel di atas untuk memulai.</div>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

  <!-- Modal for viewing payment proof -->
  <div id="imageModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm hidden">
    <div class="relative max-w-3xl w-full bg-[#1c233a] rounded-2xl shadow-2xl overflow-hidden border border-white/10 flex flex-col">
      <div class="flex items-center justify-between px-6 py-4 border-b border-white/10">
        <h3 class="font-bold text-white text-base">Bukti Pembayaran DP</h3>
        <button onclick="closeImageModal()" class="text-white/60 hover:text-white text-lg transition focus:outline-none bg-transparent border-0 cursor-pointer">
          <i class="fa fa-times"></i>
        </button>
      </div>
      <div class="p-6 bg-[#14192b] flex items-center justify-center max-h-[70vh] overflow-y-auto">
        <img id="modalImage" src="" class="max-w-full max-h-[60vh] rounded-lg shadow-md object-contain">
      </div>
      <div class="px-6 py-4 border-t border-white/10 bg-[#1c233a] flex justify-end gap-3">
        <a id="modalDownloadLink" href="" download class="px-4 py-2 bg-white/5 hover:bg-white/10 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition flex items-center gap-1.5" style="text-decoration: none;">
          Unduh Foto
        </a>
        <button onclick="closeImageModal()" class="px-4 py-2 bg-[#e53637] hover:bg-[#c22d2f] text-white text-xs font-bold uppercase tracking-wider rounded-xl transition border-0 cursor-pointer">
          Tutup
        </button>
      </div>
    </div>
  </div>

  <script>
    function showImageModal(src) {
      const modal = document.getElementById('imageModal');
      const img = document.getElementById('modalImage');
      const downloadLink = document.getElementById('modalDownloadLink');
      if (modal && img && downloadLink) {
        img.src = src;
        downloadLink.href = src;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
      }
    }

    function closeImageModal() {
      const modal = document.getElementById('imageModal');
      if (modal) {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
      }
    }

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') closeImageModal();
    });
  </script>
</x-app-layout>