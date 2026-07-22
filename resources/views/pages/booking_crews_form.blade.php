<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-white leading-tight">
        {{ __('Form Booking Crews') }}
      </h2>
    </div>
  </x-slot>

  <!-- Google Fonts & FontAwesome (Sesuai dengan welcome/dashboard) -->
  <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">

  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

  <!-- Style Khusus Tema Slate-Blue / Navy Cinematic (Sama Persis dengan booking_drone.blade.php) -->
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
  </style>

  <!-- Area Konten Utama (Slate-Blue / Navy Theme) -->
  <div class="py-12 vg-theme min-h-[calc(100vh-12rem)] relative">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Header Area -->
      <div class="mb-6 flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold tracking-tight text-white uppercase" style="letter-spacing: 1px;">Form Pemesanan</h1>
          <p class="text-white/70 text-sm mt-2" style="font-family: 'Josefin Sans', sans-serif;">
            Layanan: <span class="font-semibold text-[#00c7ff]">{{ $layanan }}</span> ·
            Paket: <span class="font-semibold text-[#00c7ff]">{{ $paket }}</span>
          </p>
        </div>
        <a href="{{ route('booking.crews') }}" class="text-xs uppercase tracking-widest text-[#00c7ff] hover:underline" style="font-family: 'Josefin Sans', sans-serif; font-weight: 600;">
          <i class="fa fa-arrow-left mr-1"></i> Kembali
        </a>
      </div>

      @if(session('success'))
        <div class="mb-8 p-4 rounded-2xl bg-green-500/10 border border-green-500/30 text-green-400 font-semibold" style="font-family: 'Josefin Sans', sans-serif;">
          <i class="fa fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
      @endif

      @if($errors->any())
        <div class="mb-5 p-3 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-sm" style="font-family: 'Josefin Sans', sans-serif;">
          <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $e)
              <li>{{ $e }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- FORM CARD -->
      <div class="vg-card">
        <form id="booking-crews-form" method="POST" action="{{ route('booking.crews.submit') }}" enctype="multipart/form-data" class="space-y-4">
          @csrf
          <input type="hidden" name="layanan" value="{{ $layanan }}">
          <input type="hidden" name="paket" value="{{ $paket }}">

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
              <label class="vg-label">Tanggal Booking</label>
              <input type="date" name="tanggal" id="tanggal-input" value="{{ old('tanggal') }}" class="vg-input" required>
            </div>

            <div class="col-span-2">
              <label class="vg-label">Lokasi Pengerjaan</label>
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
              <!-- Map container inside form -->
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
              <label class="vg-label">Catatan Tambahan (Opsional)</label>
              <textarea name="catatan" rows="3" class="vg-input" placeholder="Tulis catatan atau instruksi tambahan jika ada...">{{ old('catatan') }}</textarea>
            </div>
          </div>

          <button class="vg-btn-primary mt-4">
            Kirim Permintaan
          </button>
        </form>
      </div>

    </div>

    <!-- ========================================== -->
    <!-- FLOATING ACTION BUTTONS -->
    <!-- ========================================== -->

    <!-- Kiri Bawah: Diskusi Icon (Menuju Halaman Diskusi) -->
    <a href="{{ route('diskusi.chat', 'booking_crews') }}" 
       class="fixed bottom-6 left-6 z-[9999] bg-[#202940] hover:bg-[#242f4c] text-white border border-white/10 hover:border-[#00c7ff] hover:text-[#00c7ff] w-14 h-14 rounded-full shadow-2xl flex items-center justify-center transition duration-300 focus:outline-none"
       title="Diskusi dengan Admin">
      <i class="fa fa-comments text-2xl"></i>
      @auth
        @php
            $floatingUnreadCount = \App\Models\DiscussionMessage::whereHas('discussion', function($q) {
                $q->where('user_id', auth()->id())->where('service_type', 'booking_crews');
            })->where('sender_id', '!=', auth()->id())->where('is_read', false)->count();
        @endphp
        <span class="floating-unread-badge absolute -top-1.5 -right-1.5 bg-[#e53637] text-white text-[9px] font-extrabold w-5 h-5 rounded-full flex items-center justify-center border-2 border-[#1a2035] shadow-lg {{ $floatingUnreadCount > 0 ? 'animate-bounce' : '' }}" data-service-type="booking_crews" style="{{ $floatingUnreadCount > 0 ? '' : 'display: none;' }}">
            {{ $floatingUnreadCount }}
        </span>
      @endauth
    </a>

  </div>

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script>
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

      function initMap() {
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
      }

      initMap();

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

      // Search Autocomplete Logic
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

      // Form submit intercept to append distance/cost information to catatan
      const form = document.getElementById('booking-crews-form');
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
          if (catatanTextarea) {
            const distanceVal = document.getElementById('distance-value').textContent;
            const costVal = document.getElementById('cost-value').textContent;
            if (distanceVal && costVal && distanceVal !== '0.00 km') {
              const originalCatatan = catatanTextarea.value.trim();
              const systemInfo = `\n\n[INFO SISTEM - ESTIMASI PERJALANAN]\nJarak Tempuh PP (Pulang Pergi): ${distanceVal}\nOngkos Perjalanan (Rp 2.500/km): ${costVal}`;
              catatanTextarea.value = originalCatatan ? originalCatatan + systemInfo : systemInfo.trim();
            }
          }
        });
      }
    });
  </script>
</x-app-layout>
