<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-white leading-tight">
        {{ __('Booking Jasa Drone') }}
      </h2>
    </div>
  </x-slot>

  <!-- Google Fonts & FontAwesome (Sesuai dengan welcome/dashboard) -->
  <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">

  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

  <!-- Style Khusus Tema Slate-Blue / Navy Cinematic (Sama Persis dengan dashboard.blade.php) -->
  <style>
    .vg-theme {
      font-family: 'Play', sans-serif;
      background-color: #1a2035;
      color: #fff;
    }
    
    .vg-card {
      background: #202940;
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 20px;
      padding: 30px;
      transition: all 0.3s ease;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
    }
    
    .vg-card:hover {
      border-color: rgba(0, 199, 255, 0.45);
      background: #242f4c;
      transform: translateY(-2px);
    }

    .no-scrollbar::-webkit-scrollbar {
      display: none; /* Safari and Chrome */
    }
    .no-scrollbar {
      -ms-overflow-style: none;  /* IE and Edge */
      scrollbar-width: none;  /* Firefox */
    }

    /* Input Fields Theme */
    .vg-input {
      background-color: #151a30;
      border: 1px solid rgba(255, 255, 255, 0.12);
      color: #ffffff;
      border-radius: 12px;
      padding: 11px 15px;
      width: 100%;
      outline: none;
      transition: all 0.25s ease;
      font-family: "Josefin Sans", sans-serif;
      font-size: 14px;
    }

    .vg-input:focus {
      border-color: #00c7ff;
      box-shadow: 0 0 10px rgba(0, 199, 255, 0.35);
      background-color: #171d37;
    }

    /* Form Label */
    .vg-label {
      font-family: "Josefin Sans", sans-serif;
      color: rgba(255, 255, 255, 0.85);
      font-weight: 600;
      font-size: 13px;
      margin-bottom: 6px;
      display: block;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    /* Tombol luxury (Sama Persis dengan tombol dashboard) */
    .vg-btn-primary {
      background: #e53637;
      border: 1px solid #e53637;
      border-radius: 999px;
      color: #fff;
      font-weight: 600;
      padding: 13px 26px;
      text-transform: uppercase;
      font-size: 13px;
      letter-spacing: 0.6px;
      cursor: pointer;
      transition: all 0.25s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      text-decoration: none !important;
    }

    .vg-btn-primary:hover {
      background: transparent;
      color: #e53637 !important;
      border-color: #e53637;
      transform: translateY(-2px);
    }

    /* Pulse effect untuk floating button booking */
    .pulse-btn {
      box-shadow: 0 0 0 0 rgba(229, 54, 55, 0.7);
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(229, 54, 55, 0.7);
      }
      70% {
        transform: scale(1);
        box-shadow: 0 0 0 15px rgba(229, 54, 55, 0);
      }
      100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(229, 54, 55, 0);
      }
    }

    /* Dark mode styling untuk pagination Laravel */
    .dark-pagination nav[role="navigation"] {
      background: transparent !important;
    }
    .dark-pagination nav span,
    .dark-pagination nav a {
      background-color: #202940 !important;
      color: #fff !important;
      border-color: rgba(255, 255, 255, 0.08) !important;
      border-radius: 8px !important;
      margin: 0 2px;
      transition: all 0.25s ease;
    }
    .dark-pagination nav span[aria-current="page"] > span {
      background-color: #00c7ff !important;
      color: #1a2035 !important;
      border-color: #00c7ff !important;
      font-weight: 700;
    }
    .dark-pagination nav a:hover {
      background-color: #242f4c !important;
      border-color: rgba(0, 199, 255, 0.4) !important;
      color: #00c7ff !important;
    }
  </style>

  <!-- Wrapper Root dengan State Modal Alpine.js -->
  <div x-data="{ showBookingModal: {{ $errors->any() ? 'true' : 'false' }} }" 
       x-init="$watch('showBookingModal', value => { 
         if (value) { 
           setTimeout(() => { 
             if (window.initBookingMap) window.initBookingMap(); 
           }, 250); 
         } 
       }); if (showBookingModal) { setTimeout(() => { if (window.initBookingMap) window.initBookingMap(); }, 350); }"
       class="py-12 vg-theme min-h-[calc(100vh-12rem)] relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Header Area -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-white uppercase" style="letter-spacing: 1px;">Booking Jasa Drone</h1>
        <p class="text-white/70 text-sm mt-2" style="font-family: 'Josefin Sans', sans-serif;">
          Ambil referensi project dari Portofolio Jasa Udara Drone (tabel portofolio_udaras) dan ajukan booking.
        </p>
      </div>

      @if(session('success'))
        <div class="mb-8 p-4 rounded-2xl bg-green-500/10 border border-green-500/30 text-green-400 font-semibold" style="font-family: 'Josefin Sans', sans-serif;">
          <i class="fa fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
      @endif

      <!-- LIST PORTOFOLIO (Full-Width Responsive Grid) -->
      <div class="space-y-6">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
          @forelse($portofolios as $p)
            @php
              $coverUrl = '';
              $youtubeId = null;
              $isYoutube = false;

              if (!empty($p->cover)) {
                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|shorts|watch)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $p->cover, $match)) {
                    $youtubeId = $match[1];
                    $isYoutube = true;
                    $coverUrl = "https://img.youtube.com/vi/{$youtubeId}/hqdefault.jpg";
                } else {
                    $coverUrl = \Illuminate\Support\Str::startsWith($p->cover, ['http://', 'https://']) ? $p->cover : asset($p->cover);
                }
              } else {
                $coverUrl = asset('img/portfolio/portfolio-1.jpg');
              }
            @endphp

            @if($isYoutube)
              <button type="button"
                      class="text-left vg-card p-0 overflow-hidden flex flex-col justify-between h-full cursor-pointer w-full focus:outline-none"
                      data-yt="{{ $youtubeId }}"
                      data-title="{{ e($p->judul) }}"
                      onclick="openVideoModal(this)">
            @else
              <div class="vg-card p-0 overflow-hidden flex flex-col justify-between h-full">
            @endif
              <div class="w-full">
                <!-- Thumbnail Cover -->
                <div class="relative overflow-hidden" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                  <img src="{{ $coverUrl }}" 
                       onerror="this.src='{{ asset('img/portfolio/portfolio-1.jpg') }}';"
                       alt="{{ $p->judul }}" 
                       class="w-full h-48 object-cover transition duration-300 hover:scale-105" 
                       loading="lazy">
                  
                  @if($isYoutube)
                    <div class="absolute inset-0 flex items-center justify-center bg-black/35 hover:bg-black/50 transition">
                      <div class="rounded-full bg-black/60 px-4 py-2 text-white text-xs font-semibold flex items-center gap-2 border border-white/10">
                        <i class="fa fa-play text-[#e53637]"></i> PLAY VIDEO
                      </div>
                    </div>
                    <div class="absolute top-3 left-3 text-[10px] font-bold bg-[#e53637] text-white px-2.5 py-1 rounded-lg uppercase tracking-wide">
                      Video
                    </div>
                  @else
                    <div class="absolute top-3 left-3 text-[10px] font-bold bg-[#00c7ff] text-white px-2.5 py-1 rounded-lg uppercase tracking-wide">
                      Foto
                    </div>
                  @endif
                </div>

                <div class="p-6">
                  <div class="font-bold text-lg text-white mb-2 tracking-wide line-clamp-1">{{ $p->judul }}</div>
                  <div class="text-xs text-[#00c7ff] mb-4" style="font-family: 'Josefin Sans', sans-serif; font-weight: 500;">
                    <i class="fa fa-map-marker mr-1"></i> {{ $p->lokasi }} @if($p->tanggal) · {{ $p->tanggal }} @endif
                  </div>
                  @if($p->deskripsi)
                    <p class="text-sm text-white/70 line-clamp-3 mb-4" style="font-family: 'Josefin Sans', sans-serif; line-height: 1.6;">
                      {{ $p->deskripsi }}
                    </p>
                  @endif
                </div>
              </div>
              <div class="text-xs text-white/45 px-6 pb-6 pt-4 border-t border-white/5" style="font-family: 'Josefin Sans', sans-serif;">
                ID Referensi: <span class="font-semibold text-[#00c7ff]">{{ $p->id }}</span>
              </div>
            @if($isYoutube)
              </button>
            @else
              </div>
            @endif
          @empty
            <div class="vg-card text-center text-white/50 py-12 sm:col-span-2 lg:col-span-3" style="font-family: 'Josefin Sans', sans-serif;">
              Belum ada portofolio.
            </div>
          @endforelse
        </div>

        <div class="mt-6 dark-pagination">
          {{ $portofolios->links() }}
        </div>
      </div>

      <!-- ========================================== -->
      <!-- MODAL POP-UP (Booking Form) -->
      <!-- ========================================== -->
      <div x-show="showBookingModal" 
           class="fixed inset-0 z-[99999] flex items-center justify-center p-4" 
           style="display: none;"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 scale-95"
           x-transition:enter-end="opacity-100 scale-100"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="opacity-100 scale-100"
           x-transition:leave-end="opacity-0 scale-95">
        
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/75 backdrop-blur-md" @click="showBookingModal = false"></div>

        <!-- Modal Content Card -->
        <div class="vg-card w-full max-w-xl max-h-[90vh] overflow-y-auto no-scrollbar relative z-10 border border-white/10 shadow-2xl">
          
          <!-- Close Button -->
          <button @click="showBookingModal = false" class="absolute top-4 right-4 text-white/60 hover:text-white text-xl focus:outline-none">
            <i class="fa fa-times"></i>
          </button>

          <div class="font-bold text-xl text-white mb-1 tracking-wide uppercase">Kirim Permintaan Booking</div>
          <div class="text-xs text-white/50 mb-6" style="font-family: 'Josefin Sans', sans-serif;">
            Isi form berikut, Anda dapat memasukkan ID Referensi portofolio.
          </div>

          @if($errors->any())
            <div class="mb-5 p-3 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-sm" style="font-family: 'Josefin Sans', sans-serif;">
              <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form id="booking-drone-form" method="POST" action="{{ route('booking.drone.submit') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div class="grid grid-cols-2 gap-4">
              <div class="col-span-2 sm:col-span-1">
                <label class="vg-label">Nama</label>
                <input name="nama" value="{{ old('nama', auth()->user() ? auth()->user()->name : '') }}" class="vg-input" placeholder="Masukkan nama lengkap" required>
              </div>

              <div class="col-span-2 sm:col-span-1">
                <label class="vg-label">Email</label>
                <input type="email" name="email" value="{{ auth()->user()->email }}" class="vg-input" style="background-color: #151a30; opacity: 0.65;" readonly required>
              </div>

              <div class="col-span-2 sm:col-span-1">
                <label class="vg-label">No HP</label>
                <input name="hp" id="hp-input" value="{{ old('hp') }}" class="vg-input" placeholder="Contoh: 08123456789" required>
              </div>

              <div class="col-span-2 sm:col-span-1">
                <label class="vg-label">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal-input" value="{{ old('tanggal') }}" class="vg-input" required>
              </div>

              <div class="col-span-2">
                <label class="vg-label">Lokasi</label>
                <div class="relative">
                  <div class="flex gap-2">
                    <div class="relative flex-1">
                      <input id="lokasi-input" name="lokasi" value="{{ old('lokasi') }}" class="vg-input" placeholder="Cari lokasi pengerjaan atau ketik alamat..." required autocomplete="off">
                      <!-- Suggestions Dropdown for address search -->
                      <ul id="modal-search-suggestions" class="absolute left-0 right-0 mt-1 bg-[#151a30] border border-white/10 rounded-xl shadow-2xl z-[99999] max-h-60 overflow-y-auto hidden divide-y divide-white/5 text-xs text-white"></ul>
                    </div>
                    <!-- Use current location button -->
                    <button type="button" id="btn-current-location" class="px-3 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shrink-0" title="Gunakan Lokasi Sekarang">
                      <i class="fa fa-map-marker text-sm"></i>
                      <span class="hidden sm:inline">Lokasi Saya</span>
                    </button>
                  </div>
                </div>
                <!-- Map container inside modal -->
                <div id="booking-map" class="w-full h-[240px] rounded-xl border border-white/10 mt-2 z-10 bg-[#151a30]"></div>
                <div class="text-[10px] text-white/50 mt-1 flex justify-between">
                  <span>* Geser pin merah atau klik peta untuk menyesuaikan titik</span>
                  <span id="coords-display" class="font-mono text-[#00c7ff]"></span>
                </div>
                
                <!-- Cost Estimate Display Container -->
                <div id="cost-estimate-container" class="mt-3 p-3.5 bg-[#151a30]/50 border border-white/5 rounded-xl flex items-center justify-between text-sm hidden">
                  <div>
                    <div class="text-white/50 text-[10px] uppercase font-bold tracking-wider">Jarak Tempuh PP (Pulang Pergi)</div>
                    <div id="distance-value" class="text-white font-extrabold text-base mt-0.5">0.00 km</div>
                  </div>
                  <div class="text-right">
                    <div class="text-[#00c7ff] text-[10px] uppercase font-bold tracking-wider">Ongkos Perjalanan (Rp 2.500/km)</div>
                    <div id="cost-value" class="text-emerald-400 font-extrabold text-base mt-0.5">Rp 0</div>
                  </div>
                </div>
              </div>

              <div class="col-span-2">
                <label class="vg-label">Referensi Portofolio (opsional)</label>
                <select name="portofolio_id" class="vg-input bg-[#151a30] text-white">
                  <option value="">-- Pilih Referensi Portofolio --</option>
                  @foreach($allPortofolios as $p_ref)
                    <option value="{{ $p_ref->id }}" {{ old('portofolio_id') == $p_ref->id ? 'selected' : '' }}>
                      ID: {{ $p_ref->id }} - {{ $p_ref->judul }} ({{ $p_ref->lokasi }})
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="col-span-2">
                <label class="vg-label">DP Booking Tanggal</label>
                <input type="text" id="dp-display-input" class="vg-input text-emerald-400 font-bold" style="background-color: #151a30; color: #10b981; font-weight: bold;" value="Rp 100.000" readonly>
                <input type="hidden" name="dp_booking_tanggal" id="dp-hidden-input" value="100000">
                <p class="text-[10px] text-white/50 mt-1">
                  * DP normal Rp 100.000. Jika tanggal booking kurang dari 2 hari dari tanggal hari ini, DP otomatis menjadi Rp 230.000.
                </p>
              </div>

              <div class="col-span-2">
                <label class="vg-label">Upload Bukti Pembayaran DP</label>
                <input type="file" name="bukti_pembayaran_dp" class="vg-input bg-[#151a30] text-white/70" accept="image/*" required>
                <p class="text-[10px] text-white/50 mt-1">
                  * Harap unggah foto bukti transfer DP (format gambar: JPG, JPEG, PNG, GIF, WEBP, maks 10MB).
                </p>
              </div>

              <div class="col-span-2">
                <label class="vg-label">Catatan</label>
                <textarea name="catatan" rows="3" class="vg-input" placeholder="Tulis catatan atau instruksi tambahan jika ada...">{{ old('catatan') }}</textarea>
              </div>
            </div>

            <button class="vg-btn-primary mt-2">
              Kirim Permintaan
            </button>
          </form>
        </div>
      </div>

    </div>

    <!-- ========================================== -->
    <!-- FLOATING ACTION BUTTONS -->
    <!-- ========================================== -->
    
    <!-- Kanan Bawah: Booking Sekarang Button (Membuka Modal) -->
    <button @click="showBookingModal = true" 
            class="fixed bottom-6 right-6 z-[9999] bg-[#e53637] text-white hover:bg-[#b22425] font-extrabold py-3.5 px-6 rounded-full shadow-2xl flex items-center gap-2 text-xs uppercase tracking-widest transition duration-300 pulse-btn focus:outline-none">
      <i class="fa fa-calendar-check-o text-sm"></i>
      Booking Sekarang
    </button>

    <!-- Kiri Bawah: Diskusi Icon (Menuju Halaman Diskusi) -->
    <a href="{{ route('diskusi.chat', 'booking_drone') }}" 
       class="fixed bottom-6 left-6 z-[9999] bg-[#202940] hover:bg-[#242f4c] text-white border border-white/10 hover:border-[#00c7ff] hover:text-[#00c7ff] w-14 h-14 rounded-full shadow-2xl flex items-center justify-center transition duration-300 focus:outline-none"
       title="Diskusi dengan Admin">
      <i class="fa fa-comments text-2xl"></i>
      @auth
        @php
            $floatingUnreadCount = \App\Models\DiscussionMessage::whereHas('discussion', function($q) {
                $q->where('user_id', auth()->id())->where('service_type', 'booking_drone');
            })->where('sender_id', '!=', auth()->id())->where('is_read', false)->count();
        @endphp
        <span class="floating-unread-badge absolute -top-1.5 -right-1.5 bg-[#e53637] text-white text-[9px] font-extrabold w-5 h-5 rounded-full flex items-center justify-center border-2 border-[#1a2035] shadow-lg {{ $floatingUnreadCount > 0 ? 'animate-bounce' : '' }}" data-service-type="booking_drone" style="{{ $floatingUnreadCount > 0 ? '' : 'display: none;' }}">
            {{ $floatingUnreadCount }}
        </span>
      @endauth
    </a>

    <!-- ========================================== -->
    <!-- MODAL VIDEO -->
    <!-- ========================================== -->
    <div id="videoModal" class="fixed inset-0 z-[99999] hidden">
      <div class="absolute inset-0 bg-black/85 backdrop-blur-sm" onclick="closeVideoModal()"></div>

      <div class="relative w-full h-full flex items-center justify-center p-4">
        <div id="videoModalBox" class="relative w-full max-w-5xl bg-[#202940] rounded-2xl overflow-hidden shadow-2xl border border-white/10">
          <div class="flex items-center justify-between px-6 py-4 border-b border-white/10">
            <div class="font-bold text-white text-base" id="videoTitle">Video</div>

            <div class="flex items-center gap-3">
              <button type="button"
                class="px-4 py-2 rounded-xl bg-[#151a30] text-white text-xs font-bold uppercase tracking-wider hover:bg-[#202940] border border-white/10 transition"
                onclick="toggleModalFullscreen()">
                Full Screen
              </button>

              <button type="button"
                class="px-4 py-2 rounded-xl bg-red-600 text-white text-xs font-bold uppercase tracking-wider hover:bg-red-500 transition"
                onclick="closeVideoModal()">
                Tutup
              </button>
            </div>
          </div>

          <div class="bg-black">
            <iframe
              id="videoFrame"
              class="w-full aspect-video"
              src=""
              title="YouTube Video"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              allowfullscreen>
            </iframe>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script>
    // ========= VIDEO MODAL =========
    function openVideoModal(btn) {
      const videoModal = document.getElementById('videoModal');
      const videoFrame = document.getElementById('videoFrame');
      const videoTitle = document.getElementById('videoTitle');
      const yt = btn.getAttribute('data-yt');
      const title = btn.getAttribute('data-title') || 'Video';
      if (!yt) return;
      videoTitle.textContent = title;
      videoModal.classList.remove('hidden');
      videoFrame.src = `https://www.youtube.com/embed/${yt}?autoplay=1&rel=0`;
      document.body.classList.add('overflow-hidden');
    }

    function closeVideoModal() {
      const videoModal = document.getElementById('videoModal');
      const videoFrame = document.getElementById('videoFrame');
      videoModal.classList.add('hidden');
      videoFrame.src = '';
      document.body.classList.remove('overflow-hidden');
      if (document.fullscreenElement) document.exitFullscreen().catch(()=>{});
    }

    function toggleModalFullscreen() {
      const videoModalBox = document.getElementById('videoModalBox');
      if (!document.fullscreenElement) {
        videoModalBox.requestFullscreen?.().catch(()=>{});
      } else {
        document.exitFullscreen?.().catch(()=>{});
      }
    }

    document.addEventListener('keydown', (e) => {
      if (e.key !== 'Escape') return;
      const videoModal = document.getElementById('videoModal');
      if (videoModal && !videoModal.classList.contains('hidden')) closeVideoModal();
    });

    document.addEventListener("DOMContentLoaded", function () {
      let bookingMap = null;
      let bookingMarker = null;

      @php
        $setting = \App\Models\AdminSetting::first();
        $initLat = $setting->latitude ?? -6.2088;
        $initLng = $setting->longitude ?? 106.8456;
      @endphp

      const initLat = parseFloat("{{ $initLat }}");
      const initLng = parseFloat("{{ $initLng }}");
      let currentLat = initLat;
      let currentLng = initLng;

      // Haversine formula to measure distance between two lat/lng coordinates in km
      function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radius of the earth in km
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = 
          Math.sin(dLat/2) * Math.sin(dLat/2) +
          Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
          Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c; // Distance in km
      }

      // Format currency as IDR (Rupiah)
      function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
      }

      window.initBookingMap = function() {
        if (bookingMap) {
          bookingMap.invalidateSize();
          return;
        }

        bookingMap = L.map('booking-map').setView([initLat, initLng], 13);

        // Add Google Maps Tile Layer
        L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
          attribution: '&copy; Google Maps'
        }).addTo(bookingMap);

        const redIcon = L.icon({
          iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
          shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
          iconSize: [25, 41],
          iconAnchor: [12, 41],
          popupAnchor: [1, -34],
          shadowSize: [41, 41]
        });

        bookingMarker = L.marker([initLat, initLng], {
          icon: redIcon,
          draggable: true
        }).addTo(bookingMap);

        updateCoords(initLat, initLng);

        // Reverse geocoding on dragend
        bookingMarker.on('dragend', function (e) {
          const position = bookingMarker.getLatLng();
          updateCoords(position.lat, position.lng);
          reverseGeocode(position.lat, position.lng);
        });

        // Click on map to place marker
        bookingMap.on('click', function (e) {
          const clickCoords = e.latlng;
          bookingMarker.setLatLng(clickCoords);
          updateCoords(clickCoords.lat, clickCoords.lng);
          reverseGeocode(clickCoords.lat, clickCoords.lng);
        });
      };

      function updateCoords(lat, lng) {
        currentLat = lat;
        currentLng = lng;
        const coordsDisplay = document.getElementById('coords-display');
        if (coordsDisplay) {
          coordsDisplay.textContent = `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
        }

        // Measure distance and estimate cost (PP / Round Trip)
        const distanceOneWay = calculateDistance(initLat, initLng, lat, lng);
        const distancePP = distanceOneWay * 2;
        const cost = distancePP * 2500;

        const estimateContainer = document.getElementById('cost-estimate-container');
        const distanceValue = document.getElementById('distance-value');
        const costValue = document.getElementById('cost-value');

        if (estimateContainer && distanceValue && costValue) {
          distanceValue.textContent = `${distancePP.toFixed(2)} km`;
          costValue.textContent = formatRupiah(Math.round(cost));
          estimateContainer.classList.remove('hidden');
        }
      }

      function reverseGeocode(lat, lng) {
        const lokasiInput = document.getElementById('lokasi-input');
        const coordsDisplay = document.getElementById('coords-display');
        
        if (coordsDisplay) {
          coordsDisplay.textContent = `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
        }
        
        lokasiInput.placeholder = "Mengambil alamat...";

        // 1. Try Nominatim first
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
          .then(res => {
            if (!res.ok) throw new Error('Nominatim error');
            return res.json();
          })
          .then(data => {
            if (data && data.display_name) {
              lokasiInput.value = data.display_name;
            } else {
              throw new Error('No address found');
            }
          })
          .catch(() => {
            // 2. Try ArcGIS fallback
            fetch(`https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/reverseGeocode?f=json&location=${lng},${lat}`)
              .then(res => res.json())
              .then(data => {
                if (data && data.address && data.address.Match_addr) {
                  lokasiInput.value = data.address.Match_addr;
                } else if (data && data.address && data.address.Address) {
                  lokasiInput.value = data.address.Address;
                } else {
                  lokasiInput.value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                }
              })
              .catch(() => {
                lokasiInput.value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
              });
          })
          .finally(() => {
            lokasiInput.placeholder = "Cari lokasi pengerjaan atau ketik alamat...";
          });
      }

      // Geolocation "Use current location" button
      const btnCurrentLocation = document.getElementById('btn-current-location');
      if (btnCurrentLocation) {
        btnCurrentLocation.addEventListener('click', function() {
          if (!navigator.geolocation) {
            alert("Browser Anda tidak mendukung geolokasi.");
            return;
          }

          const originalText = btnCurrentLocation.innerHTML;
          btnCurrentLocation.disabled = true;
          btnCurrentLocation.innerHTML = `<i class="fa fa-spinner animate-spin"></i> <span class="hidden sm:inline">Mencari...</span>`;

          navigator.geolocation.getCurrentPosition(
            function(position) {
              const lat = position.coords.latitude;
              const lng = position.coords.longitude;

              if (bookingMap && bookingMarker) {
                bookingMap.setView([lat, lng], 16);
                bookingMarker.setLatLng([lat, lng]);
              }

              updateCoords(lat, lng);
              reverseGeocode(lat, lng);

              btnCurrentLocation.disabled = false;
              btnCurrentLocation.innerHTML = originalText;
            },
            function(error) {
              alert("Gagal mendapatkan lokasi. Pastikan izin lokasi aktif.");
              btnCurrentLocation.disabled = false;
              btnCurrentLocation.innerHTML = originalText;
            },
            { enableHighAccuracy: true, timeout: 8000, maximumAge: 0 }
          );
        });
      }

      // Search and Autocomplete Logic
      const searchInput = document.getElementById('lokasi-input');
      const suggestionsList = document.getElementById('modal-search-suggestions');
      let debounceTimer;

      searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = searchInput.value.trim();

        if (query.length < 3) {
          suggestionsList.classList.add('hidden');
          return;
        }

        debounceTimer = setTimeout(() => {
          // Fetch from Nominatim
          const nominatimPromise = fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=5`)
            .then(res => res.json())
            .then(data => data.map(item => ({
              display_name: item.display_name,
              lat: parseFloat(item.lat),
              lon: parseFloat(item.lon),
              source: 'Nominatim'
            })))
            .catch(() => []);

          // Fetch from ArcGIS
          const arcgisPromise = fetch(`https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/findAddressCandidates?f=json&singleLine=${encodeURIComponent(query)}&maxLocations=5`)
            .then(res => res.json())
            .then(data => {
              if (data && data.candidates) {
                return data.candidates.map(item => ({
                  display_name: item.address,
                  lat: item.location.y,
                  lon: item.location.x,
                  source: 'ArcGIS'
                }));
              }
              return [];
            })
            .catch(() => []);

          Promise.all([nominatimPromise, arcgisPromise]).then(([nomResults, arcResults]) => {
            const merged = [...nomResults, ...arcResults];
            const unique = [];
            const seen = new Set();

            merged.forEach(item => {
              const normalized = item.display_name.toLowerCase().trim();
              if (!seen.has(normalized)) {
                seen.add(normalized);
                unique.push(item);
              }
            });

            suggestionsList.innerHTML = '';
            if (unique.length > 0) {
              unique.slice(0, 8).forEach(item => {
                const li = document.createElement('li');
                li.className = 'px-4 py-2.5 hover:bg-[#242f4c] cursor-pointer transition flex justify-between items-center gap-2 border-b border-white/5 last:border-0';
                li.innerHTML = `
                  <span class="truncate flex-1">${item.display_name}</span>
                  <span class="text-[8px] px-1.5 py-0.5 bg-white/10 text-white/70 rounded font-semibold uppercase tracking-wider shrink-0">${item.source}</span>
                `;
                li.addEventListener('click', function() {
                  const lat = item.lat;
                  const lon = item.lon;

                  if (bookingMap && bookingMarker) {
                    bookingMap.setView([lat, lon], 16);
                    bookingMarker.setLatLng([lat, lon]);
                  }

                  updateCoords(lat, lon);
                  searchInput.value = item.display_name;
                  suggestionsList.classList.add('hidden');
                });
                suggestionsList.appendChild(li);
              });
              suggestionsList.classList.remove('hidden');
            } else {
              suggestionsList.classList.add('hidden');
            }
          });
        }, 400);
      });

      document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !suggestionsList.contains(e.target)) {
          suggestionsList.classList.add('hidden');
        }
      });

      // Form submit intercept to append distance/cost information to catatan
      const form = document.getElementById('booking-drone-form');
      if (form) {
        form.addEventListener('submit', function() {
          // Append accurate coordinates to lokasi input value
          const lokasiInput = form.querySelector('input[name="lokasi"]');
          if (lokasiInput && lokasiInput.value && currentLat && currentLng) {
            if (!lokasiInput.value.includes('Lat:')) {
              lokasiInput.value = `${lokasiInput.value.trim()} (Lat: ${currentLat.toFixed(6)}, Lng: ${currentLng.toFixed(6)})`;
            }
          }

          const catatanTextarea = form.querySelector('textarea[name="catatan"]');
          const distanceVal = document.getElementById('distance-value').textContent;
          const costVal = document.getElementById('cost-value').textContent;
          if (distanceVal && costVal && distanceVal !== '0.00 km') {
            const originalCatatan = catatanTextarea.value.trim();
            const systemInfo = `\n\n[INFO SISTEM - ESTIMASI PERJALANAN]\nJarak Tempuh PP (Pulang Pergi): ${distanceVal}\nOngkos Perjalanan (Rp 2.500/km): ${costVal}`;
            catatanTextarea.value = originalCatatan ? originalCatatan + systemInfo : systemInfo.trim();
          }
        });
      }

      // DP Calculation Logic based on date chosen
      const dateInput = document.getElementById('tanggal-input');
      const dpDisplay = document.getElementById('dp-display-input');
      const dpHidden = document.getElementById('dp-hidden-input');

      function calculateDP() {
        if (!dateInput.value) {
          dpDisplay.value = "Pilih tanggal booking...";
          dpHidden.value = "";
          return;
        }

        const selectedDate = new Date(dateInput.value);
        selectedDate.setHours(0, 0, 0, 0);

        const today = new Date();
        today.setHours(0, 0, 0, 0);

        // Difference in time
        const diffTime = selectedDate.getTime() - today.getTime();
        // Difference in days
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        let dpValue = 100000;
        if (diffDays < 2) {
          dpValue = 230000;
        }

        dpDisplay.value = formatRupiah(dpValue);
        dpHidden.value = dpValue;
      }

      dateInput.addEventListener('change', calculateDP);
      calculateDP();

      // Restrict No HP to numbers and '+' sign only (no letters allowed)
      const hpInput = document.getElementById('hp-input');
      if (hpInput) {
        hpInput.addEventListener('input', function(e) {
          this.value = this.value.replace(/[^0-9+]/g, '');
        });
      }
    });
  </script>
</x-app-layout>