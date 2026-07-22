@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<!-- Leaflet CSS for maps -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<div class="max-w-6xl mx-auto space-y-8 pb-10">
  
  <!-- Welcome Banner -->
  <div class="bg-gradient-to-r from-red-600 to-rose-700 text-white rounded-3xl p-6 shadow-md relative overflow-hidden">
    <div class="absolute -right-10 -bottom-10 opacity-10">
      <svg class="w-56 h-56 text-white" fill="currentColor" viewBox="0 0 24 24">
        <path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L14 19v-5.5l7 2.5z"/>
      </svg>
    </div>
    <div class="relative z-10">
      <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold uppercase tracking-wider">Control Panel</span>
      <h1 class="text-3xl font-extrabold mt-3">Selamat Datang Kembali, {{ auth()->user()->name }}!</h1>
      <p class="text-white/80 text-sm mt-1">Berikut adalah ringkasan performa dan pengajuan terbaru dari pelanggan Anda hari ini.</p>
    </div>
  </div>

  <!-- Stats Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    
    <!-- Stat: Booking Drone -->
    <a href="{{ route('admin.booking-drone.index') }}" class="group block bg-white rounded-2xl border border-slate-200 shadow-sm p-6 hover:shadow-md hover:border-blue-300 transition duration-300">
      <div class="flex items-center justify-between">
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition duration-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
          </svg>
        </div>
        @if($counts['booking_drone']['new'] > 0)
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 animate-pulse">
            {{ $counts['booking_drone']['new'] }} Baru
          </span>
        @endif
      </div>
      <div class="mt-4">
        <h3 class="text-sm font-semibold text-slate-500">Booking Jasa Drone</h3>
        <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $counts['booking_drone']['total'] }}</p>
        <span class="text-xs text-slate-400 group-hover:text-blue-600 transition font-medium inline-flex items-center gap-1 mt-2">
          Kelola Pengajuan &rarr;
        </span>
      </div>
    </a>

    <!-- Stat: Booking Crew -->
    <a href="{{ route('admin.booking-crews.index') }}" class="group block bg-white rounded-2xl border border-slate-200 shadow-sm p-6 hover:shadow-md hover:border-purple-300 transition duration-300">
      <div class="flex items-center justify-between">
        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition duration-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
          </svg>
        </div>
        @if($counts['booking_crew']['new'] > 0)
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 animate-pulse">
            {{ $counts['booking_crew']['new'] }} Baru
          </span>
        @endif
      </div>
      <div class="mt-4">
        <h3 class="text-sm font-semibold text-slate-500">Booking Crews</h3>
        <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $counts['booking_crew']['total'] }}</p>
        <span class="text-xs text-slate-400 group-hover:text-purple-600 transition font-medium inline-flex items-center gap-1 mt-2">
          Kelola Pengajuan &rarr;
        </span>
      </div>
    </a>

    <!-- Stat: Order Drone -->
    <a href="{{ route('admin.order-drone.index') }}" class="group block bg-white rounded-2xl border border-slate-200 shadow-sm p-6 hover:shadow-md hover:border-emerald-300 transition duration-300">
      <div class="flex items-center justify-between">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition duration-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
          </svg>
        </div>
        @if($counts['order_drone']['new'] > 0)
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 animate-pulse">
            {{ $counts['order_drone']['new'] }} Baru
          </span>
        @endif
      </div>
      <div class="mt-4">
        <h3 class="text-sm font-semibold text-slate-500">Order Drone</h3>
        <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $counts['order_drone']['total'] }}</p>
        <span class="text-xs text-slate-400 group-hover:text-emerald-600 transition font-medium inline-flex items-center gap-1 mt-2">
          Kelola Pengajuan &rarr;
        </span>
      </div>
    </a>

    <!-- Stat: Servis Drone -->
    <a href="{{ route('admin.servis-drone.index') }}" class="group block bg-white rounded-2xl border border-slate-200 shadow-sm p-6 hover:shadow-md hover:border-amber-300 transition duration-300">
      <div class="flex items-center justify-between">
        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition duration-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </div>
        @if($counts['servis_drone']['new'] > 0)
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 animate-pulse">
            {{ $counts['servis_drone']['new'] }} Baru
          </span>
        @endif
      </div>
      <div class="mt-4">
        <h3 class="text-sm font-semibold text-slate-500">Servis Drone</h3>
        <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $counts['servis_drone']['total'] }}</p>
        <span class="text-xs text-slate-400 group-hover:text-amber-600 transition font-medium inline-flex items-center gap-1 mt-2">
          Kelola Pengajuan &rarr;
        </span>
      </div>
    </a>

  </div>

  <!-- Recent Submissions Table -->
  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
      <div>
        <h2 class="text-lg font-bold text-slate-800">Aktivitas & Pengajuan Terbaru</h2>
        <p class="text-xs text-slate-500 mt-0.5">Gabungan daftar pengajuan booking, order, dan servis terbaru.</p>
      </div>
      <span class="text-xs font-semibold text-slate-400 bg-slate-50 px-3 py-1 rounded-full border border-slate-200/50">
        Menampilkan 8 Data Terakhir
      </span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse text-sm">
        <thead>
          <tr class="bg-slate-50/75 border-b border-slate-200 text-slate-600 font-semibold text-xs uppercase tracking-wider">
            <th class="px-6 py-4">Tipe Layanan</th>
            <th class="px-6 py-4">Client / Kontak</th>
            <th class="px-6 py-4">Detail Pemesanan</th>
            <th class="px-6 py-4">DP & Bukti Bayar</th>
            <th class="px-6 py-4">Tgl Masuk</th>
            <th class="px-6 py-4">Status</th>
            <th class="px-6 py-4 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse($recentSubmissions as $item)
            <tr class="hover:bg-slate-50/30 transition">
              <!-- Service Type -->
              <td class="px-6 py-4">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $item->badge_color }}">
                  {{ $item->submission_label }}
                </span>
              </td>
              
              <!-- Client Info -->
              <td class="px-6 py-4">
                <div class="font-bold text-slate-900">{{ $item->nama }}</div>
                <div class="text-xs text-slate-500 mt-0.5">{{ $item->email }}</div>
                <div class="text-xs text-slate-600 mt-1"><i class="fa fa-phone mr-1"></i>{{ $item->hp ?? '-' }}</div>
              </td>
              
              <!-- Booking Detail -->
              <td class="px-6 py-4">
                @if($item->submission_type === 'booking_crew')
                  <div class="font-semibold text-slate-800 uppercase">{{ $item->layanan }}</div>
                  <div class="text-xs text-blue-600 font-semibold mt-0.5 tracking-wide">Paket: {{ $item->paket }}</div>
                @else
                  <div class="text-slate-800 max-w-xs truncate" title="{{ $item->catatan }}">{{ $item->catatan ?? 'Tidak ada catatan' }}</div>
                @endif
                
                @if($item->lokasi)
                  <button type="button" onclick="showMapModal('{{ addslashes($item->lokasi) }}')" class="text-xs text-slate-500 hover:text-blue-600 hover:underline transition text-left mt-1.5 block">
                    <i class="fa fa-map-marker text-red-500 mr-0.5"></i> {{ Str::limit($item->lokasi, 35) }}
                  </button>
                @endif
              </td>
              
              <!-- DP & Payment Proof -->
              <td class="px-6 py-4 text-slate-700">
                <div class="font-bold text-slate-900">{{ $item->dp_booking_tanggal ? 'Rp ' . number_format($item->dp_booking_tanggal, 0, ',', '.') : '-' }}</div>
                @if($item->bukti_pembayaran_dp)
                  <button type="button" onclick="showImageModal('{{ asset('storage/' . $item->bukti_pembayaran_dp) }}')" class="text-xs text-emerald-600 hover:underline font-semibold mt-0.5 block border-0 bg-transparent p-0 cursor-pointer">
                    <i class="fa fa-image mr-0.5"></i> Lihat Bukti
                  </button>
                @else
                  <span class="text-xs text-slate-400 mt-0.5 block">Tidak ada bukti</span>
                @endif
              </td>
              
              <!-- Created At -->
              <td class="px-6 py-4 text-slate-500 text-xs">
                <div>{{ $item->created_at->format('d M Y H:i') }}</div>
                <div class="text-slate-400 mt-0.5">{{ $item->created_at->diffForHumans() }}</div>
              </td>
              
              <!-- Status -->
              <td class="px-6 py-4">
                @if($item->status === 'baru')
                  <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                    Baru
                  </span>
                @else
                  <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                    Proses
                  </span>
                @endif
              </td>

              <!-- Action Link -->
              <td class="px-6 py-4 text-right">
                <a href="{{ $item->manage_route }}" class="inline-flex items-center px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs uppercase tracking-wide rounded-lg transition" style="text-decoration: none;">
                  Kelola
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                <div class="flex flex-col items-center justify-center gap-2">
                  <svg viewBox="0 0 24 24" class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.6" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                  <span class="font-medium">Belum ada pengajuan masuk.</span>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal for viewing payment proof -->
<div id="imageModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden">
  <div class="relative max-w-3xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-200 flex flex-col">
    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
      <h3 class="font-bold text-slate-800 text-base">Bukti Pembayaran DP</h3>
      <button onclick="closeImageModal()" class="text-slate-400 hover:text-slate-600 text-lg transition focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
    <div class="p-6 bg-slate-50 flex items-center justify-center max-h-[70vh] overflow-y-auto">
      <img id="modalImage" src="" class="max-w-full max-h-[60vh] rounded-lg shadow-md object-contain">
    </div>
    <div class="px-6 py-4 border-t border-slate-100 bg-white flex justify-end gap-3">
      <a id="modalDownloadLink" href="" download class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold uppercase tracking-wider rounded-xl transition flex items-center gap-1.5" style="text-decoration: none;">
        Unduh Foto
      </a>
      <button onclick="closeImageModal()" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition">
        Tutup
      </button>
    </div>
  </div>
</div>

<!-- Modal for viewing map -->
<div id="mapModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden">
  <div class="relative max-w-2xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-200 flex flex-col">
    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
      <h3 class="font-bold text-slate-800 text-base">Detail Lokasi Pengerjaan</h3>
      <button onclick="closeMapModal()" class="text-slate-400 hover:text-slate-600 text-lg transition focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
    <div class="p-6 bg-slate-50 flex flex-col gap-4">
      <div id="modal-map-address" class="text-xs text-slate-600 bg-slate-100 p-3 rounded-xl border border-slate-200/60 font-semibold leading-relaxed"></div>
      <div id="admin-detail-map" class="w-full h-[320px] rounded-xl border border-slate-200 shadow-sm bg-slate-100"></div>
    </div>
    <div class="px-6 py-4 border-t border-slate-100 bg-white flex justify-end gap-3">
      <a id="googleMapsLink" href="" target="_blank" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold uppercase tracking-wider rounded-xl transition flex items-center gap-1.5" style="text-decoration: none;">
        Buka di Google Maps
      </a>
      <button onclick="closeMapModal()" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition">
        Tutup
      </button>
    </div>
  </div>
</div>

<!-- Leaflet JS for maps -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
  // Image Modal Logic
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

  // Map Modal Logic
  let detailMap = null;
  let detailMarker = null;

  function showMapModal(address) {
    document.getElementById('modal-map-address').textContent = address;
    document.getElementById('mapModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');

    if (!detailMap) {
      detailMap = L.map('admin-detail-map').setView([-6.2088, 106.8456], 13);
      L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        attribution: '&copy; Google Maps'
      }).addTo(detailMap);
    }

    const reg = /Lat:\s*([-\d.]+),\s*Lng:\s*([-\d.]+)/i;
    const match = address.match(reg);
    if (match) {
      const lat = parseFloat(match[1]);
      const lon = parseFloat(match[2]);

      detailMap.setView([lat, lon], 15);
      if (detailMarker) {
        detailMarker.setLatLng([lat, lon]);
      } else {
        detailMarker = L.marker([lat, lon]).addTo(detailMap);
      }
      document.getElementById('googleMapsLink').href = `https://www.google.com/maps/search/?api=1&query=${lat},${lon}`;
      
      setTimeout(() => {
        detailMap.invalidateSize();
      }, 200);
      return;
    }

    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1`)
      .then(res => {
        if (!res.ok) throw new Error('Nominatim error');
        return res.json();
      })
      .then(data => {
        if (data && data.length > 0) {
          const lat = parseFloat(data[0].lat);
          const lon = parseFloat(data[0].lon);

          detailMap.setView([lat, lon], 15);

          if (detailMarker) {
            detailMarker.setLatLng([lat, lon]);
          } else {
            detailMarker = L.marker([lat, lon]).addTo(detailMap);
          }

          document.getElementById('googleMapsLink').href = `https://www.google.com/maps/search/?api=1&query=${lat},${lon}`;
        } else {
          throw new Error('No Nominatim geocode result');
        }
      })
      .catch(() => {
        detailMap.setView([-6.9839, 109.1171], 12);
        if (detailMarker) {
          detailMap.removeLayer(detailMarker);
          detailMarker = null;
        }
        document.getElementById('googleMapsLink').href = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(address)}`;
      })
      .finally(() => {
        setTimeout(() => {
          detailMap.invalidateSize();
        }, 200);
      });
  }

  function closeMapModal() {
    const modal = document.getElementById('mapModal');
    if (modal) {
      modal.classList.add('hidden');
      document.body.classList.remove('overflow-hidden');
    }
  }

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closeImageModal();
      closeMapModal();
    }
  });
</script>
@endsection