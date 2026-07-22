@extends('layouts.admin')

@section('title', 'Pengaturan Lokasi & Rekening - Admin')

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<div class="max-w-6xl mx-auto">
  <div class="mb-6 flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Pengaturan Lokasi & Rekening</h1>
      <p class="text-sm text-slate-500 mt-1">Kelola nomor rekening pembayaran, e-wallet, dan titik koordinat peta lokasi Anda secara akurat.</p>
    </div>
  </div>

  @if(session('success'))
    <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 font-medium">
      {{ session('success') }}
    </div>
  @endif

  <form method="POST" action="{{ route('admin.setting.update') }}" class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    @csrf

    <!-- KIRI: FORM INPUT -->
    <div class="lg:col-span-5 space-y-6">
      
      <!-- DYNAMIC PAYMENT ACCOUNTS LIST -->
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <div class="flex justify-between items-center mb-2">
          <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Akun Rekening & E-Wallet</h2>
          <button type="button" onclick="addPaymentRow()" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-bold rounded-lg border border-red-200 transition flex items-center gap-1">
            <i class="fa fa-plus"></i> Tambah
          </button>
        </div>

        <div id="payment-accounts-container" class="space-y-4">
          <!-- Dynamic payment rows will be injected here -->
        </div>
      </div>

      <!-- LOKASI & DETAIL -->
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-2">Informasi Alamat Toko/Kantor</h2>

        <div>
          <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Alamat Detail / Deskripsi Lokasi</label>
          <textarea name="alamat_detail" id="alamat_detail" rows="3" 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-red-500 focus:ring focus:ring-red-200/50 outline-none transition text-sm text-slate-800"
                    placeholder="Masukkan detail alamat toko/kantor...">{{ old('alamat_detail', $setting->alamat_detail) }}</textarea>
        </div>
      </div>

      <!-- KOORDINAT GEOGRAFIS -->
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-2">Koordinat Peta</h2>
        
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Latitude</label>
            <input type="text" name="latitude" id="input-lat" value="{{ old('latitude', $setting->latitude) }}" readonly
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-100 bg-slate-50/50 outline-none text-sm font-semibold text-slate-600 cursor-not-allowed">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Longitude</label>
            <input type="text" name="longitude" id="input-lng" value="{{ old('longitude', $setting->longitude) }}" readonly
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-100 bg-slate-50/50 outline-none text-sm font-semibold text-slate-600 cursor-not-allowed">
          </div>
        </div>

        <button type="button" id="btn-current-location" class="w-full py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-200 text-xs font-bold rounded-xl transition flex items-center justify-center gap-1.5">
          <i class="fa fa-map-marker"></i> Gunakan Lokasi Sekarang
        </button>

        <p class="text-[11px] text-slate-400 leading-relaxed">
          *Koordinat akan terisi secara otomatis ketika Anda mencari alamat, menggeser pin merah, atau mengklik peta di sebelah kanan.
        </p>
      </div>

      <button type="submit" class="w-full py-3.5 bg-red-600 hover:bg-red-500 text-white font-bold rounded-xl shadow-lg transition">
        Simpan Pengaturan
      </button>
    </div>

    <!-- KANAN: LEAFLET MAP DENGAN ADDRESS SEARCH -->
    <div class="lg:col-span-7">
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 h-full flex flex-col">
        <div class="mb-4">
          <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-2">Pencarian Alamat & Pemilih Lokasi</h2>
          <div class="flex gap-2">
            <div class="relative flex-1">
              <input type="text" id="map-search-input" placeholder="Ketik nama tempat / alamat (misal: Monas, Jakarta)..." autocomplete="off"
                     class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm outline-none focus:border-red-500 transition">
              <!-- Suggestions Dropdown -->
              <ul id="search-suggestions" class="absolute left-0 right-0 mt-1 bg-white border border-slate-200 rounded-xl shadow-lg z-[9999] max-h-60 overflow-y-auto hidden divide-y divide-slate-100 text-xs text-slate-700">
              </ul>
            </div>
            <button type="button" id="map-search-btn" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-sm font-bold transition">
              Cari
            </button>
          </div>
        </div>

        <!-- Map Container -->
        <div id="map" class="flex-1 w-full rounded-xl border border-slate-200 z-10 min-h-[450px]"></div>
      </div>
    </div>
  </form>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    // ==========================================
    // LEAFLET MAP LOGIC
    // ==========================================
    var initLat = parseFloat("{{ $setting->latitude ?? -6.2088 }}");
    var initLng = parseFloat("{{ $setting->longitude ?? 106.8456 }}");

    var map = L.map('map').setView([initLat, initLng], 13);

    // Add Google Maps Tile Layer (Super up-to-date street map with latest places)
    L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
      attribution: '&copy; Google Maps'
    }).addTo(map);

    var redIcon = L.icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41]
    });

    var marker = L.marker([initLat, initLng], {
      icon: redIcon,
      draggable: true
    }).addTo(map);

    function updateCoords(lat, lng) {
      document.getElementById('input-lat').value = lat.toFixed(6);
      document.getElementById('input-lng').value = lng.toFixed(6);
    }

    marker.on('dragend', function (e) {
      var position = marker.getLatLng();
      updateCoords(position.lat, position.lng);
    });

    map.on('click', function (e) {
      var clickCoords = e.latlng;
      marker.setLatLng(clickCoords);
      updateCoords(clickCoords.lat, clickCoords.lng);
    });

    // ==========================================
    // NOMINATIM & ARCGIS GEOLOCATION SEARCH + AUTOCOMPLETE LOGIC
    // ==========================================
    const searchInput = document.getElementById('map-search-input');
    const searchBtn = document.getElementById('map-search-btn');
    const suggestionsList = document.getElementById('search-suggestions');
    let debounceTimer;

    // Debounced listener on search input for suggestions list
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

            // Fetch from ArcGIS (very good for local/private places without API keys)
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
                // Merge and remove duplicate places by name
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
                        li.className = 'px-4 py-2.5 hover:bg-slate-50 cursor-pointer transition flex justify-between items-center gap-2 border-b border-slate-100 last:border-0';
                        li.innerHTML = `
                            <span class="truncate flex-1">${item.display_name}</span>
                            <span class="text-[8px] px-1.5 py-0.5 bg-slate-100 text-slate-500 rounded font-semibold uppercase tracking-wider shrink-0">${item.source}</span>
                        `;
                        li.addEventListener('click', function() {
                            const lat = item.lat;
                            const lon = item.lon;

                            // Move map & marker
                            map.setView([lat, lon], 16);
                            marker.setLatLng([lat, lon]);
                            updateCoords(lat, lon);

                            // Fill input & textarea
                            searchInput.value = item.display_name;
                            document.getElementById('alamat_detail').value = item.display_name;

                            // Hide suggestions
                            suggestionsList.classList.add('hidden');
                        });
                        suggestionsList.appendChild(li);
                    });
                    suggestionsList.classList.remove('hidden');
                } else {
                    suggestionsList.classList.add('hidden');
                }
            });
        }, 300);
    });

    // Close suggestion list when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !suggestionsList.contains(e.target)) {
            suggestionsList.classList.add('hidden');
        }
    });

    function performSearch() {
        const query = searchInput.value.trim();
        if (!query) return;

        searchBtn.disabled = true;
        searchBtn.textContent = 'Mencari...';

        // Search Nominatim first
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`)
            .then(res => res.json())
            .then(results => {
                if (results && results.length > 0) {
                    const result = results[0];
                    const lat = parseFloat(result.lat);
                    const lon = parseFloat(result.lon);

                    map.setView([lat, lon], 16);
                    marker.setLatLng([lat, lon]);
                    updateCoords(lat, lon);

                    if (result.display_name) {
                        document.getElementById('alamat_detail').value = result.display_name;
                    }
                    suggestionsList.classList.add('hidden');
                } else {
                    // Try ArcGIS if Nominatim returns nothing
                    return fetch(`https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/findAddressCandidates?f=json&singleLine=${encodeURIComponent(query)}&maxLocations=1`)
                        .then(res => res.json())
                        .then(data => {
                            if (data && data.candidates && data.candidates.length > 0) {
                                const cand = data.candidates[0];
                                const lat = cand.location.y;
                                const lon = cand.location.x;

                                map.setView([lat, lon], 16);
                                marker.setLatLng([lat, lon]);
                                updateCoords(lat, lon);

                                document.getElementById('alamat_detail').value = cand.address;
                                suggestionsList.classList.add('hidden');
                            } else {
                                alert('Tempat tidak ditemukan di database. Silakan coba kata kunci lain atau cari secara manual di peta.');
                            }
                        });
                }
            })
            .catch(err => {
                console.error('Geocoding error:', err);
                alert('Terjadi kesalahan saat mencari lokasi.');
            })
            .finally(() => {
                searchBtn.disabled = false;
                searchBtn.textContent = 'Cari';
            });
    }

    searchBtn.addEventListener('click', performSearch);
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            performSearch();
        }
    });

    // ==========================================
    // HTML5 CURRENT GEOLOCATION LOGIC
    // ==========================================
    const btnCurrentLocation = document.getElementById('btn-current-location');
    btnCurrentLocation.addEventListener('click', function() {
        if (!navigator.geolocation) {
            alert('Geolocation tidak didukung oleh browser Anda.');
            return;
        }

        btnCurrentLocation.disabled = true;
        const originalText = btnCurrentLocation.innerHTML;
        btnCurrentLocation.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Mendeteksi Lokasi...';

        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                map.setView([lat, lng], 16);
                marker.setLatLng([lat, lng]);
                updateCoords(lat, lng);

                btnCurrentLocation.disabled = false;
                btnCurrentLocation.innerHTML = originalText;
            },
            function(error) {
                console.error('Geolocation error:', error);
                alert('Gagal mendeteksi lokasi sekarang. Pastikan izin lokasi aktif.');
                btnCurrentLocation.disabled = false;
                btnCurrentLocation.innerHTML = originalText;
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    });

    // ==========================================
    // DYNAMIC PAYMENT ACCOUNTS BUILDER
    // ==========================================
    var paymentContainer = document.getElementById('payment-accounts-container');

    var bankProviders = [
        'BCA (Bank Central Asia)',
        'Mandiri',
        'BNI (Bank Negara Indonesia)',
        'BRI (Bank Rakyat Indonesia)',
        'BSI (Bank Syariah Indonesia)',
        'BTN (Bank Tabungan Negara)',
        'CIMB Niaga',
        'Permata Bank',
        'OCBC NISP',
        'Danamon',
        'Bank Mega',
        'Maybank',
        'BTPN / Jenius',
        'Bank Neo Commerce',
        'Allo Bank',
        'Bank Jago',
        'SeaBank',
        'Bank DKI',
        'Bank BJB',
        'Bank Jatim',
        'Bank Jateng',
        'Lainnya'
    ];
    var ewalletProviders = [
        'DANA',
        'OVO',
        'GoPay',
        'ShopeePay',
        'LinkAja',
        'iSaku',
        'AstraPay',
        'Sakuku',
        'Lainnya'
    ];

    window.addPaymentRow = function(data = null) {
        var rowIndex = paymentContainer.children.length;
        var type = data ? data.type : 'bank';
        var provider = data ? data.provider : 'BCA';
        var number = data ? data.number : '';

        var row = document.createElement('div');
        row.className = 'payment-row p-4 border border-slate-200 bg-slate-50/50 rounded-xl relative space-y-3';
        row.innerHTML = `
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Kategori</label>
                    <select name="payment_type[]" onchange="onCategoryChange(this)" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-xs font-medium text-slate-700 outline-none bg-white">
                        <option value="bank" ${type === 'bank' ? 'selected' : ''}>Nama Bank</option>
                        <option value="ewallet" ${type === 'ewallet' ? 'selected' : ''}>E-Wallet</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Penyedia</label>
                    <select name="payment_provider[]" class="provider-select w-full px-3 py-2 rounded-lg border border-slate-200 text-xs font-medium text-slate-700 outline-none bg-white">
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="flex-1">
                    <label class="number-label block text-[10px] font-bold text-slate-500 uppercase mb-1">
                        ${type === 'bank' ? 'Nomor Rekening' : 'Nomor E-Wallet / HP'}
                    </label>
                    <input type="text" name="payment_number[]" value="${number}" placeholder="${type === 'bank' ? 'Contoh: 1234567890' : 'Contoh: 08123456789'}" required
                           class="w-full px-3 py-2 rounded-lg border border-slate-200 text-xs font-medium text-slate-800 outline-none bg-white focus:border-red-500 transition">
                </div>
                <div class="pt-5">
                    <button type="button" onclick="this.closest('.payment-row').remove()" class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 flex items-center justify-center transition border border-red-100" title="Hapus Akun">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        `;

        paymentContainer.appendChild(row);

        var providerSelect = row.querySelector('.provider-select');
        populateProviders(providerSelect, type, provider);
    };

    function populateProviders(selectEl, type, selectedValue = '') {
        selectEl.innerHTML = '';
        var providers = type === 'bank' ? bankProviders : ewalletProviders;
        providers.forEach(p => {
            var opt = document.createElement('option');
            opt.value = p;
            opt.textContent = p;
            if (p === selectedValue) {
                opt.selected = true;
            }
            selectEl.appendChild(opt);
        });
    }

    window.onCategoryChange = function(selectEl) {
        var row = selectEl.closest('.payment-row');
        var type = selectEl.value;
        var providerSelect = row.querySelector('.provider-select');
        populateProviders(providerSelect, type);

        var labelEl = row.querySelector('.number-label');
        var inputEl = row.querySelector('input[name="payment_number[]"]');
        if (type === 'bank') {
            labelEl.textContent = 'Nomor Rekening';
            inputEl.placeholder = 'Contoh: 1234567890';
        } else {
            labelEl.textContent = 'Nomor E-Wallet / HP';
            inputEl.placeholder = 'Contoh: 08123456789';
        }
    };

    // Initialize
    const initialAccounts = @json($accounts);
    if (initialAccounts.length > 0) {
        initialAccounts.forEach(acc => addPaymentRow(acc));
    } else {
        addPaymentRow();
    }
  });
</script>
@endsection
