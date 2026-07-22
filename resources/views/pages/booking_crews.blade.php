<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-white leading-tight">
        {{ __('Booking Photographer / Videographer') }}
      </h2>
    </div>
  </x-slot>

  <!-- Google Fonts & FontAwesome (Sesuai dengan welcome/dashboard) -->
  <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">

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
    
    .vg-card:hover {
      border-color: rgba(0, 199, 255, 0.45);
      background: #242f4c;
      transform: translateY(-2px);
    }

    /* Pulse effect untuk floating button */
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

  @php
    // Siapkan JSON data layanan+paket di sisi PHP
    $servicesJson = collect($services ?? [])->map(function ($s) {
      return [
        'slug' => (string) $s->slug,
        'nama' => (string) $s->nama,
        'packages' => collect($s->paket ?? [])->map(function ($p) {
          return [
            'id' => (string) $p->kode,
            'name' => (string) $p->nama,
            'desc' => (string) ($p->deskripsi ?? ''),
          ];
        })->values()->all(),
      ];
    })->values()->all();
  @endphp

  <!-- Area Konten Utama (Slate-Blue / Navy Theme) -->
  <div class="py-12 vg-theme min-h-[calc(100vh-12rem)] relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Header Area -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-white uppercase" style="letter-spacing: 1px;">Photographer / Videographer</h1>
        <p class="text-white/70 text-sm mt-2" style="font-family: 'Josefin Sans', sans-serif;">
          Dihalaman ini anda akan melihat kumpulan portofolio dari beberapa project yang kami kerjakan.
        </p>
      </div>

      @if(session('success'))
        <div class="mb-8 p-4 rounded-2xl bg-green-500/10 border border-green-500/30 text-green-400 font-semibold" style="font-family: 'Josefin Sans', sans-serif;">
          <i class="fa fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
      @endif

      <div class="grid lg:grid-cols-3 gap-8">
        
        <!-- LIST PORTOFOLIO -->
        <div class="lg:col-span-2 space-y-6">
          <div class="grid sm:grid-cols-2 gap-6">
            @forelse($portofolios as $p)
              @php
                $raw = trim($p->youtube_url ?? '');
                $youtubeId = null;

                if ($raw !== '') {
                  if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $raw)) {
                    $youtubeId = $raw;
                  } elseif (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|shorts/|embed/|live/))([0-9A-Za-z_-]{11})~', $raw, $m)) {
                    $youtubeId = $m[1];
                  } elseif (preg_match('~(?:v=|\/)([0-9A-Za-z_-]{11})(?:[?&\/]|$)~', $raw, $m2)) {
                    $youtubeId = $m2[1];
                  }
                }

                if (!empty($p->cover)) {
                  $coverUrl = asset('storage/'.$p->cover);
                } elseif ($youtubeId) {
                  $coverUrl = "https://i.ytimg.com/vi/{$youtubeId}/hqdefault.jpg";
                } else {
                  $coverUrl = "https://via.placeholder.com/1200x675?text=No+Thumbnail";
                }
              @endphp

              <button
                type="button"
                class="text-left vg-card p-0 overflow-hidden flex flex-col justify-between h-full"
                data-yt="{{ $youtubeId ?? '' }}"
                data-title="{{ e($p->judul) }}"
                onclick="openVideoModal(this)"
              >
                <div class="w-full">
                  <div class="relative overflow-hidden rounded-t-20">
                    <img
                      src="{{ $coverUrl }}"
                      alt="Thumbnail"
                      class="w-full h-44 object-cover transition duration-300 hover:scale-105"
                      loading="lazy"
                    />

                    @if($youtubeId)
                      <div class="absolute inset-0 flex items-center justify-center bg-black/35 hover:bg-black/50 transition">
                        <div class="rounded-full bg-black/60 px-4 py-2 text-white text-xs font-semibold flex items-center gap-2 border border-white/10">
                          <i class="fa fa-play text-red-500"></i> PLAY VIDEO
                        </div>
                      </div>
                      <div class="absolute top-3 left-3 text-[10px] font-bold bg-[#e53637] text-white px-2.5 py-1 rounded-lg uppercase tracking-wide">
                        YouTube
                      </div>
                    @else
                      <div class="absolute top-3 left-3 text-[10px] font-bold bg-[#00c7ff] text-white px-2.5 py-1 rounded-lg uppercase tracking-wide">
                        Foto
                      </div>
                    @endif
                  </div>

                  <div class="p-5">
                    <div class="font-bold text-lg text-white mb-2 line-clamp-1 tracking-wide">{{ $p->judul }}</div>
                    <div class="text-xs text-[#00c7ff] mb-3" style="font-family: 'Josefin Sans', sans-serif; font-weight: 500;">
                      <i class="fa fa-map-marker mr-1"></i> {{ $p->lokasi ?? '-' }} @if($p->tanggal) · {{ $p->tanggal }} @endif
                    </div>

                    @if($p->deskripsi)
                      <p class="text-sm text-white/70 line-clamp-2" style="font-family: 'Josefin Sans', sans-serif; line-height: 1.5;">{{ $p->deskripsi }}</p>
                    @endif
                  </div>
                </div>
              </button>
            @empty
              <div class="vg-card text-center text-white/50 py-12 sm:col-span-2" style="font-family: 'Josefin Sans', sans-serif;">
                Belum ada portofolio crew.
              </div>
            @endforelse
          </div>

          <div class="mt-6 dark-pagination">
            {{ $portofolios->links() }}
          </div>
        </div>

        <!-- PANEL INFO -->
        <div>
          <div class="vg-card relative">
            <div class="font-bold text-lg text-white mb-2 tracking-wide">BOOKING CREWS</div>
            <div class="text-xs text-white/50 mb-6" style="font-family: 'Josefin Sans', sans-serif;">
              1) Pilih layanan dulu → 2) pilih paket → 3) isi form pemesanan.
            </div>

            <div class="space-y-4 p-4 rounded-xl border border-white/5 bg-[#151a30] mb-6">
              <div>
                <div class="text-[10px] text-white/40 uppercase tracking-wider mb-1" style="font-family: 'Josefin Sans', sans-serif;">Layanan dipilih</div>
                <div class="font-bold text-white text-base" id="serviceLabel">-</div>
              </div>

              <div>
                <div class="text-[10px] text-white/40 uppercase tracking-wider mb-1" style="font-family: 'Josefin Sans', sans-serif;">Paket dipilih</div>
                <div class="font-bold text-[#00c7ff] text-base" id="packageLabel">Belum dipilih</div>
              </div>
            </div>

            <div class="text-xs text-white/60 mb-0" style="font-family: 'Josefin Sans', sans-serif; line-height: 1.6;">
              Setelah layanan & paket dipilih, kamu akan diarahkan ke halaman inputan pemesanan sesuai paket tersebut.
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- ========================================== -->
    <!-- FLOATING ACTION BUTTONS -->
    <!-- ========================================== -->
    
    <!-- Kanan Bawah: Pilih Layanan Button (Membuka Modal) -->
    <button onclick="openServiceModal()" 
            class="fixed bottom-6 right-6 z-[9999] bg-[#e53637] text-white hover:bg-[#b22425] font-extrabold py-3.5 px-6 rounded-full shadow-2xl flex items-center gap-2 text-xs uppercase tracking-widest transition duration-300 pulse-btn focus:outline-none">
      <i class="fa fa-th-list text-sm"></i>
      Pilih Paket Jasa
    </button>

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

  <!-- ========================================== -->
  <!-- MODAL PILIH LAYANAN + PAKET -->
  <!-- ========================================== -->
  <div id="serviceModal" class="fixed inset-0 z-[99999] hidden">
    <div class="absolute inset-0 bg-black/85 backdrop-blur-md" onclick="closeServiceModal()"></div>

    <div class="relative w-full h-full flex items-center justify-center p-4">
      <div class="relative w-full max-w-xl bg-[#202940] rounded-2xl overflow-hidden shadow-2xl border border-white/10">
        <div class="flex items-center justify-between px-6 py-4 border-b border-white/10">
          <div class="font-bold text-white text-base uppercase tracking-wide">Pilih Layanan & Paket</div>

          <button type="button"
            class="px-3.5 py-1.5 rounded-lg bg-red-600 text-white text-xs font-bold hover:bg-red-500 transition uppercase tracking-wide"
            onclick="closeServiceModal()">
            Tutup
          </button>
        </div>

        <div class="p-6 space-y-5">
          <div class="text-xs text-white/50" style="font-family: 'Josefin Sans', sans-serif;">
            Langkah: 1) pilih layanan → 2) pilih paket → 3) lanjut isi form pemesanan.
          </div>

          <div>
            <div class="text-xs font-semibold text-white/80 uppercase tracking-wider mb-2" style="font-family: 'Josefin Sans', sans-serif;">Pilih Layanan</div>

            <div class="grid grid-cols-2 gap-3" id="serviceButtons">
              @forelse(($services ?? collect()) as $s)
                <button type="button"
                  class="service-btn px-3 py-2.5 rounded-xl border border-white/10 bg-[#151a30] text-white/85 font-semibold hover:bg-[#202940] transition text-sm"
                  data-service="{{ $s->slug }}"
                  onclick="chooseService('{{ $s->slug }}', true)">
                  {{ $s->nama }}
                </button>
              @empty
                <div class="col-span-2 text-xs text-amber-500 bg-amber-500/10 border border-amber-500/20 rounded-xl px-4 py-3" style="font-family: 'Josefin Sans', sans-serif;">
                  Belum ada layanan di database.
                </div>
              @endforelse
            </div>
          </div>

          <div>
            <div class="flex items-center justify-between gap-2 mb-2">
              <div class="text-xs font-semibold text-white/80 uppercase tracking-wider" style="font-family: 'Josefin Sans', sans-serif;">Pilih Paket</div>
              <div class="text-xs text-[#00c7ff]" id="serviceHint">Pilih layanan dulu.</div>
            </div>

            <div id="packageList" class="grid gap-3 mt-2 overflow-y-auto max-h-[180px] pr-1"></div>
          </div>
        </div>

        <div class="px-6 py-4 border-t border-white/10 bg-[#151a30] text-xs text-white/60" style="font-family: 'Josefin Sans', sans-serif;">
          Layanan: <span class="font-semibold text-white" id="modalServiceLabel">-</span> ·
          Paket: <span class="font-semibold text-[#00c7ff]" id="modalPackageLabel">Belum dipilih</span>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript Logic -->
  <script>
    // ========= DATA DARI DATABASE (services + packages) =========
    const SERVICES = @json($servicesJson);

    const PACKAGES = {};
    SERVICES.forEach(s => { PACKAGES[s.slug] = s.packages || []; });

    function getServiceName(slug) {
      const s = SERVICES.find(x => x.slug === slug);
      return s ? s.nama : slug;
    }

    // ========= VIDEO MODAL =========
    const videoModal = document.getElementById('videoModal');
    const videoFrame = document.getElementById('videoFrame');
    const videoTitle = document.getElementById('videoTitle');
    const videoModalBox = document.getElementById('videoModalBox');

    function openVideoModal(btn) {
      const yt = btn.getAttribute('data-yt');
      const title = btn.getAttribute('data-title') || 'Video';
      if (!yt) return;
      videoTitle.textContent = title;
      videoModal.classList.remove('hidden');
      videoFrame.src = `https://www.youtube.com/embed/${yt}?autoplay=1&rel=0`;
      document.body.classList.add('overflow-hidden');
    }

    function closeVideoModal() {
      videoModal.classList.add('hidden');
      videoFrame.src = '';
      document.body.classList.remove('overflow-hidden');
      if (document.fullscreenElement) document.exitFullscreen().catch(()=>{});
    }

    function toggleModalFullscreen() {
      if (!document.fullscreenElement) {
        videoModalBox.requestFullscreen?.().catch(()=>{});
      } else {
        document.exitFullscreen?.().catch(()=>{});
      }
    }

    // ========= STATE + LABEL =========
    const serviceLabel = document.getElementById('serviceLabel');
    const packageLabel = document.getElementById('packageLabel');

    const serviceModal = document.getElementById('serviceModal');
    const packageList = document.getElementById('packageList');
    const modalServiceLabel = document.getElementById('modalServiceLabel');
    const modalPackageLabel = document.getElementById('modalPackageLabel');
    const serviceHint = document.getElementById('serviceHint');

    let selectedService = (SERVICES[0]?.slug) || '';
    let selectedPackage = '';

    function openServiceModal() {
      serviceModal.classList.remove('hidden');
      document.body.classList.add('overflow-hidden');
      syncMainLabels();
      syncModalLabels();
      styleServiceActiveInModal();
      renderPackages();
    }

    function closeServiceModal() {
      serviceModal.classList.add('hidden');
      document.body.classList.remove('overflow-hidden');
    }

    function chooseService(v, fromModal = false) {
      selectedService = v;
      selectedPackage = '';
      syncMainLabels();
      syncModalLabels();
      styleServiceActiveInModal();
      renderPackages();
      if (fromModal) serviceHint.textContent = 'Silakan pilih paket di bawah.';
    }

    function styleServiceActiveInModal() {
      const btns = document.querySelectorAll('#serviceButtons .service-btn');
      btns.forEach(btn => {
        const slug = btn.getAttribute('data-service');
        if (slug === selectedService) {
          btn.className = "service-btn px-3 py-2.5 rounded-xl border border-[#e53637] bg-[#e53637]/15 text-[#e53637] font-extrabold transition text-sm";
        } else {
          btn.className = "service-btn px-3 py-2.5 rounded-xl border border-white/10 bg-[#151a30] text-white/85 font-semibold hover:bg-[#202940] transition text-sm";
        }
      });
    }

    function syncMainLabels() {
      serviceLabel.textContent = selectedService ? getServiceName(selectedService) : '-';
      if (!selectedPackage) { packageLabel.textContent = 'Belum dipilih'; return; }
      const found = findPackageById(selectedService, selectedPackage);
      packageLabel.textContent = found ? found.name : 'Belum dipilih';
    }

    function syncModalLabels() {
      modalServiceLabel.textContent = selectedService ? getServiceName(selectedService) : '-';
      if (!selectedPackage) { modalPackageLabel.textContent = 'Belum dipilih'; return; }
      const found = findPackageById(selectedService, selectedPackage);
      modalPackageLabel.textContent = found ? found.name : 'Belum dipilih';
    }

    function findPackageById(serviceSlug, id) {
      const items = PACKAGES[serviceSlug] || [];
      return items.find(p => p.id === id) || null;
    }

    function renderPackages() {
      const items = PACKAGES[selectedService] || [];
      packageList.innerHTML = '';

      if (!selectedService) {
        serviceHint.textContent = 'Belum ada layanan.';
        return;
      }

      serviceHint.textContent = `Paket untuk ${getServiceName(selectedService)}`;

      if (items.length === 0) {
        const box = document.createElement('div');
        box.className = 'text-xs text-amber-500 bg-amber-500/10 border border-amber-500/20 rounded-xl px-4 py-3';
        box.textContent = 'Belum ada paket untuk layanan ini.';
        packageList.appendChild(box);
        return;
      }

      items.forEach(p => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'text-left w-full p-4 rounded-xl border border-white/10 bg-[#151a30] hover:bg-[#202940] hover:border-[#00c7ff] transition text-white';
        btn.innerHTML = `
          <div class="font-bold text-white tracking-wide">${escapeHtml(p.name)}</div>
          <div class="text-xs text-white/60 mt-1.5 leading-relaxed">${escapeHtml(p.desc || '')}</div>
          <div class="text-[10px] text-[#00c7ff] font-semibold mt-3.5 uppercase tracking-wide"><i class="fa fa-check-circle mr-1"></i> Klik untuk pilih</div>
        `;
        btn.addEventListener('click', () => selectPackageAndGo(p));
        packageList.appendChild(btn);
      });
    }

    function selectPackageAndGo(p) {
      selectedPackage = p.id;
      syncMainLabels();
      syncModalLabels();
      closeServiceModal();

      const baseUrl = "{{ route('booking.crews.form') }}";
      const url = new URL(baseUrl, window.location.origin);
      url.searchParams.set('layanan', selectedService);
      url.searchParams.set('paket', selectedPackage);
      window.location.href = url.toString();
    }

    function escapeHtml(str) {
      return (str ?? '').toString()
        .replaceAll('&','&amp;')
        .replaceAll('<','&lt;')
        .replaceAll('>','&gt;')
        .replaceAll('"','&quot;')
        .replaceAll("'","&#039;");
    }

    document.addEventListener('keydown', (e) => {
      if (e.key !== 'Escape') return;
      if (!videoModal.classList.contains('hidden')) closeVideoModal();
      if (!serviceModal.classList.contains('hidden')) closeServiceModal();
    });

    (function init() {
      if (!selectedService && SERVICES.length > 0) selectedService = SERVICES[0].slug;
      syncMainLabels();
      syncModalLabels();
      styleServiceActiveInModal();
    })();
  </script>
</x-app-layout>
