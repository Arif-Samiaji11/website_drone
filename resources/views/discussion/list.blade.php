<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-white leading-tight">
        {{ __('Menu Diskusi Layanan') }}
      </h2>
    </div>
  </x-slot>

  <!-- Google Fonts & FontAwesome -->
  <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">

  <!-- Style Khusus Tema Slate-Blue / Navy Cinematic (Sama Persis dengan dashboard) -->
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
      transform: translateY(-3px);
    }

    .vg-icon-box {
      width: 54px;
      height: 54px;
      border: 1px solid rgba(0, 199, 255, 0.4);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #00c7ff;
      font-size: 20px;
      background-color: rgba(0, 199, 255, 0.05);
    }

    /* Tombol luxury */
    .vg-btn-primary {
      background: #e53637;
      border: 1px solid #e53637;
      border-radius: 999px;
      color: #fff;
      font-weight: 600;
      padding: 10px 20px;
      text-transform: uppercase;
      font-size: 11px;
      letter-spacing: 0.5px;
      cursor: pointer;
      transition: all 0.25s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
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
  <div class="py-12 vg-theme min-h-[calc(100vh-12rem)]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Header Area -->
      <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold tracking-tight text-white uppercase" style="letter-spacing: 1.5px;">Ruang Hubungi Admin</h1>
        <p class="text-white/60 text-sm mt-2 max-w-xl mx-auto" style="font-family: 'Josefin Sans', sans-serif;">
          Silakan pilih ruang diskusi sesuai dengan jenis layanan yang ingin ditanyakan untuk mempermudah admin dalam merespons.
        </p>
      </div>

      <!-- GRID KATEGORI DISKUSI -->
      <div class="grid md:grid-cols-2 gap-8">
        @foreach($data as $type => $info)
          <div class="vg-card flex flex-col justify-between relative group">
            
            <!-- Badges Unread (Real-time) -->
            <span class="category-unread-badge absolute -top-2.5 -right-2.5 bg-[#e53637] text-white text-[10px] font-extrabold w-6 h-6 rounded-full flex items-center justify-center border-2 border-[#1a2035] shadow-lg animate-bounce"
                  data-category="{{ $type }}"
                  style="{{ $info['unread'] > 0 ? '' : 'display: none;' }}">
              {{ $info['unread'] }}
            </span>

            <div>
              <div class="flex items-center gap-4 mb-5">
                <div class="vg-icon-box">
                  <i class="fa {{ $info['icon'] }}"></i>
                </div>
                <div>
                  <h3 class="font-bold text-lg text-white uppercase tracking-wide">{{ $info['title'] }}</h3>
                  <span class="text-[10px] text-white/40 uppercase tracking-widest" style="font-family: 'Josefin Sans', sans-serif;">Kategori</span>
                </div>
              </div>

              <p class="text-sm text-white/70 mb-6 leading-relaxed" style="font-family: 'Josefin Sans', sans-serif;">
                {{ $info['desc'] }}
              </p>
            </div>

            <!-- Last Message Box -->
            <div class="border-t border-white/5 pt-4 mt-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
              <div class="min-w-0 flex-1">
                <div class="text-[9px] text-[#00c7ff] uppercase tracking-wider mb-1" style="font-family: 'Josefin Sans', sans-serif;">Pesan Terakhir</div>
                <p class="text-xs text-white/50 truncate max-w-xs" style="font-family: 'Josefin Sans', sans-serif;">
                  {{ $info['last_message'] ?? 'Belum ada percakapan.' }}
                </p>
              </div>

              <div class="flex items-center justify-between sm:justify-end gap-3 shrink-0">
                @if($info['last_message_time'])
                  <span class="text-[10px] text-white/40" style="font-family: 'Josefin Sans', sans-serif;">
                    {{ $info['last_message_time'] }}
                  </span>
                @endif
                <a href="{{ route('diskusi.chat', $type) }}" class="vg-btn-primary">
                  Buka Chat <i class="fa fa-chevron-right ml-1"></i>
                </a>
              </div>
            </div>

          </div>
        @endforeach
      </div>

    </div>
  </div>

  <!-- Polling Jumlah Unread Kategori -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const badges = document.querySelectorAll('.category-unread-badge');

      function checkUnreadByCategory() {
        fetch("{{ route('diskusi.unread-by-category') }}")
          .then(res => res.json())
          .then(data => {
            badges.forEach(badge => {
              const cat = badge.getAttribute('data-category');
              const count = data[cat] || 0;
              if (count > 0) {
                badge.textContent = count;
                badge.style.display = 'flex';
                badge.classList.add('animate-bounce');
              } else {
                badge.style.display = 'none';
                badge.classList.remove('animate-bounce');
              }
            });
          })
          .catch(err => console.error("Error fetching unread by category:", err));
      }

      // Check every 4 seconds
      setInterval(checkUnreadByCategory, 4000);
    });
  </script>
</x-app-layout>
