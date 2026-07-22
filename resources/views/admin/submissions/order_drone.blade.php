@extends('layouts.admin')

@section('title', 'Kelola Order Drone - Admin')

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<div class="max-w-6xl mx-auto">
  <div class="mb-6 flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Daftar Pengajuan Order Drone</h1>
      <p class="text-sm text-slate-500 mt-1">Daftar permintaan pembelian unit drone baru dari client.</p>
    </div>
  </div>

  @if(session('success'))
    <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 font-medium">
      {{ session('success') }}
    </div>
  @endif

  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse text-sm">
        <thead>
          <tr class="bg-slate-50/75 border-b border-slate-200 text-slate-600 font-semibold text-xs uppercase tracking-wider">
            <th class="px-6 py-4">Client</th>
            <th class="px-6 py-4">No HP</th>
            <th class="px-6 py-4">Lokasi & Tanggal</th>
            <th class="px-6 py-4">DP & Bukti Bayar</th>
            <th class="px-6 py-4">ID Portofolio</th>
            <th class="px-6 py-4">Catatan</th>
            <th class="px-6 py-4">Tgl Masuk</th>
            <th class="px-6 py-4 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse($orders as $o)
            @include('admin.submissions.partials.order_drone_row', ['o' => $o])
          @empty
            <tr class="empty-state-row">
              <td colspan="8" class="px-6 py-12 text-center text-slate-500">
                <div class="flex flex-col items-center justify-center gap-2">
                  <svg viewBox="0 0 24 24" class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.6" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="9" cy="21" r="1"/>
                    <circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                  </svg>
                  <span class="font-medium">Belum ada pengajuan order unit drone.</span>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($orders->hasPages())
      <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
        {{ $orders->links() }}
      </div>
    @endif
  </div>
</div>

<!-- Modal for viewing payment proof -->
<div id="imageModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden">
  <div class="relative max-w-3xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-200 flex flex-col">
    <!-- Modal Header -->
    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
      <h3 class="font-bold text-slate-800 text-base">Bukti Pembayaran DP</h3>
      <button onclick="closeImageModal()" class="text-slate-400 hover:text-slate-600 text-lg transition focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
    <!-- Modal Body -->
    <div class="p-6 bg-slate-50 flex items-center justify-center max-h-[70vh] overflow-y-auto">
      <img id="modalImage" src="" class="max-w-full max-h-[60vh] rounded-lg shadow-md object-contain">
    </div>
    <!-- Modal Footer -->
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

<!-- Modal for viewing map -->
<div id="mapModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden">
  <div class="relative max-w-2xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-200 flex flex-col">
    <!-- Modal Header -->
    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
      <h3 class="font-bold text-slate-800 text-base">Detail Lokasi Pengerjaan</h3>
      <button onclick="closeMapModal()" class="text-slate-400 hover:text-slate-600 text-lg transition focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
    <!-- Modal Body -->
    <div class="p-6 bg-slate-50 flex flex-col gap-4">
      <div id="modal-map-address" class="text-xs text-slate-600 bg-slate-100 p-3 rounded-xl border border-slate-200/60 font-semibold leading-relaxed"></div>
      <div id="admin-detail-map" class="w-full h-[320px] rounded-xl border border-slate-200 shadow-sm bg-slate-100"></div>
    </div>
    <!-- Modal Footer -->
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

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
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

    // 1. Check if coordinates are embedded in the address string
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

    // 2. Fallback to Nominatim geocoder
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
        // Default Tegal Alun-alun
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
    if (e.key === 'Escape') closeMapModal();
  });

  // REAL-TIME CHECK FOR NEW ORDER REQUESTS
  let lastBookingId = {{ $orders->first()->id ?? 0 }};
  const tableBody = document.querySelector('tbody');
  
  setInterval(function() {
    if (lastBookingId <= 0) return;
    
    fetch(`{{ route('admin.submissions.fetch-new') }}?type=order_drone&last_id=${lastBookingId}`)
      .then(res => res.json())
      .then(data => {
        if (data.html && data.html.trim() !== '') {
          // Play Synthesized Chime (defined in admin.blade.php)
          if (window.playChime) window.playChime();
          
          // Remove empty row placeholder if it exists
          const emptyRow = tableBody.querySelector('.empty-state-row');
          if (emptyRow) {
            emptyRow.remove();
          }
          
          // Prepend new rows
          tableBody.insertAdjacentHTML('afterbegin', data.html);
          
          // Highlight new rows
          const newRows = tableBody.querySelectorAll('.new-row-highlight');
          newRows.forEach(row => {
            row.style.backgroundColor = 'rgba(56, 189, 248, 0.15)'; // light sky blue
            row.style.transition = 'background-color 2.5s ease';
            setTimeout(() => {
              row.style.backgroundColor = 'transparent';
              row.classList.remove('new-row-highlight');
            }, 100);
          });
          
          // Update lastBookingId
          lastBookingId = data.last_id;
        }
      })
      .catch(err => console.error("Error fetching new bookings:", err));
  }, 4000);
</script>
@endsection
