<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('favicon-256.png') }}">

    <meta name="description" content="Videograph Template">
    <meta name="keywords" content="Videograph, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mriki | Project</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">

    <!-- ====== LOGO SIZE FIX (gede & konsisten) ====== -->
    <style>
      .logo-fixed{min-height:64px;flex:0 0 160px;}
      @media (max-width:991.98px){.logo-fixed{flex:0 0 140px;}}
      .logo-img{display:block;height:40px;width:auto;object-fit:contain}
      .header__nav__option{min-height:64px}
      .header__nav__menu>ul{align-items:center}
      @media (max-width:991.98px){.header__nav__social{display:none!important}}

      /* ✅ LOGO JANGAN DIUBAH (tetap sesuai punyamu) */
      .header__logo{ left:-32px !important; position:relative; }

      .logo-img{
        transform: translate(-48px, 3px) scale(3.0) !important;
        -webkit-transform: translate(-48px, 3px) scale(3.0) !important;
        transform-origin: left center;
      }

      .header .row > .col-6.col-lg-2{ padding-left:0 !important; padding-right:0; }

      @media (max-width: 991.98px){
        .header__logo{ left:-24px !important; }
        .logo-img{
          transform: translate(-36px, 2px) scale(2.4) !important;
          -webkit-transform: translate(-36px, 2px) scale(2.4) !important;
        }
      }
      @media (max-width: 575.98px){
        .header__logo{ left:-16px !important; }
        .logo-img{
          transform: translate(-24px, 1px) scale(2.0) !important;
          -webkit-transform: translate(-24px, 1px) scale(2.0) !important;
        }
      }

      /* =========================================================
         NAVBAR TEXT SAJA CENTER (LOGO TETAP)
         - Yang di-center: menu teks (Dashboard/About/Portofolio/Services)
         - Logo tidak disentuh
         - Social tetap di kanan
         - Mobile tetap slicknav
         ========================================================= */
      @media (min-width: 992px){
        /* patokan absolute = container header (bukan logo) */
        .header .container{ position:relative; }

        /* social tetap kanan */
        .header__nav__option{ position:relative; }
        .header__nav__social{ margin-left:auto; position:relative; z-index:12; }

        /* menu dibuat absolute center secara GLOBAL */
        .header__nav__menu{
          position:absolute !important;
          left:36% !important;
          top:50% !important;
          transform:translate(-50%, -50%) !important;
          width:auto !important;
          flex:0 0 auto !important;
          z-index:11;
          max-width: calc(100% - 520px); /* ruang aman biar gak tabrakan logo+social */
        }

        .header__nav__menu > ul{
          justify-content:center !important;
          width:auto !important;
          margin:0 !important;
          flex-wrap:nowrap; /* biar 1 baris */
        }
      }

      /* Kalau layar agak sempit dan menu mulai tabrakan, ijinkan wrap biar tetap center */
      @media (min-width: 992px) and (max-width: 1199.98px){
        .header__nav__menu{ max-width: calc(100% - 420px); }
        .header__nav__menu > ul{ flex-wrap:wrap; row-gap:10px; }
      }

      /* =========================================================
         HERO FULL SCREEN (naik ke atas + hilangkan space hitam)
         ========================================================= */
      .hero{ position:relative; overflow:hidden; margin:0; padding:0; }
      .hero .owl-carousel,
      .hero .owl-stage-outer,
      .hero .owl-stage,
      .hero .owl-item{ height:100%; }

      .hero__slider{ height:100vh; min-height:560px; }

      .hero__item{
        height:100vh;
        min-height:560px;
        padding:0 !important;
        margin:0 !important;
        display:flex;
        align-items:center;
      }

      .hero__item.set-bg{
        background-size:cover !important;
        background-repeat:no-repeat !important;
        background-position:center 12% !important;
      }

      .hero__item::before{
        content:"";
        position:absolute;
        inset:0;
        background:linear-gradient(90deg, rgba(5,10,30,.65) 0%, rgba(5,10,30,.25) 55%, rgba(5,10,30,.15) 100%);
        pointer-events:none;
        z-index:0;
      }

      .hero__item .container{ position:relative; z-index:2; }
      .hero__text{ z-index:2; }

      @media (max-width: 575.98px){
        .hero__slider,
        .hero__item{ min-height:520px; }
        .hero__item.set-bg{ background-position:center 8% !important; }
        .hero__text h2{ font-size:36px !important; line-height:1.1; }
      }
      /* ===== LUXURY HERO STYLE ===== */

/* Biar teks di tengah (vertikal) & rapi */
.hero .hero__item .container,
.hero .hero__item .row {
  height: 80vh;               /* tinggi hero */
}

.hero .hero__item .row {
  display: flex;
  align-items: center;        /* center vertikal */
}

/* Overlay gelap supaya teks lebih “cinematic” */
.hero .hero__item::before {
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(
    90deg,
    rgba(0, 0, 0, 0.68) 0%,
    rgba(0, 0, 0, 0.42) 45%,
    rgba(0, 0, 0, 0.10) 100%
  );
  z-index: 1;
}

/* Pastikan konten di atas overlay */
.hero .hero__item {
  position: relative;
}

.hero .hero__text {
  position: relative;
  z-index: 2;
  max-width: 520px;          /* biar headline nggak kepanjangan */
  padding: 18px 18px;
  border-left: 2px solid rgba(255, 255, 255, 0.22); /* aksen mewah */
}

/* Subjudul kecil: elegan, letter spacing */
.hero .hero__text span {
  display: inline-block;
  font-size: 13px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: rgba(255, 255, 255, 0.78);
  margin-bottom: 14px;
}

/* Headline: besar, clean, premium */
.hero .hero__text h2 {
  font-size: 46px;
  line-height: 1.15;
  font-weight: 700;
  color: #fff;
  margin-bottom: 22px;
  text-shadow: 0 12px 30px rgba(0,0,0,0.45);
}

/* Tombol: lebih “premium” */
.hero .hero__text .primary-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 14px 26px;
  border-radius: 999px;
  font-weight: 600;
  letter-spacing: 0.6px;
  border: 1px solid rgba(255,255,255,0.22);
  background: rgba(255,255,255,0.08);
  backdrop-filter: blur(8px);
  transition: all 0.25s ease;
}

.hero .hero__text .primary-btn:hover {
  transform: translateY(-2px);
  background: rgba(255,255,255,0.16);
  border-color: rgba(255,255,255,0.35);
}

/* Responsive: biar tetap rapih di HP */
@media (max-width: 991px) {
  .hero .hero__item .container,
  .hero .hero__item .row {
    height: 70vh;
  }
  .hero .hero__text h2 {
    font-size: 34px;
  }
  .hero .hero__text {
    max-width: 100%;
    border-left: none;
    padding: 14px 14px;
  }
}

    </style>
</head>

<body>
<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

@php
  use Illuminate\Support\Str;
  use App\Models\PortofolioUdara;
  use App\Models\PortofolioDarat;
  use App\Models\PortofolioServisDrone;
  use App\Models\PortofolioPenjualan;

  // Ambil 1 data terbaru dari masing-masing model
  $udara = PortofolioUdara::latest()->first();
  $darat = PortofolioDarat::latest()->first();
  $servis = PortofolioServisDrone::latest()->first();
  $penjualan = PortofolioPenjualan::latest()->first();

  // deteksi youtube
  $isYoutube = function ($url) {
      if (!$url) return false;
      return Str::contains($url, ['youtube.com', 'youtu.be']);
  };

  // cover url helper: kalau sudah http → pakai langsung, kalau tidak → asset()
  $coverUrl = function ($path) {
      if (!$path) return null;
      return Str::startsWith($path, ['http://', 'https://']) ? $path : asset($path);
  };

  // fallback bg untuk item yg cover-nya youtube / kosong
  $fallbackBg = asset('img/work/work-1.jpg');

  // siapkan 4 item work (1 per model)
  $workItems = [
      [
          'size' => 'wide__item',
          'data' => $udara,
          'tag1' => 'Portofolio',
          'tag2' => 'Udara',
      ],
      [
          'size' => 'small__item',
          'data' => $darat,
          'tag1' => 'Portofolio',
          'tag2' => 'Darat',
      ],
      [
          'size' => 'small__item',
          'data' => $servis,
          'tag1' => 'Portofolio',
          'tag2' => 'Servis Drone',
      ],
      [
          'size' => 'large__item',
          'data' => $penjualan,
          'tag1' => 'Portofolio',
          'tag2' => 'Penjualan',
      ],
  ];
@endphp

<!-- Header Section Begin -->
<header class="header">
  <div class="container">
    <div class="row align-items-center">

      <div class="col-6 col-lg-2">
        <div class="header__logo logo-fixed d-flex align-items-center">
          <a href="{{ route('home') }}" class="d-inline-flex align-items-center">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo-img">
          </a>
        </div>
      </div>

      <div class="col-6 col-lg-10">
        <div class="header__nav__option d-flex align-items-center justify-content-lg-between justify-content-end gap-3">
          <nav class="header__nav__menu mobile-menu flex-grow-1">
            <ul class="d-flex flex-wrap gap-3 mb-0">
              <li class="{{ request()->routeIs('home') ? 'active' : '' }}"><a href="{{ route('home') }}">Dashboard</a></li>
              <li class="{{ request()->routeIs('about') ? 'active' : '' }}"><a href="{{ route('about') }}">About</a></li>
              <li class="{{ request()->routeIs('portfolio') ? 'active' : '' }}"><a href="{{ route('portfolio') }}">Portofolio</a></li>
              <li class="{{ request()->routeIs('services') ? 'active' : '' }}"><a href="{{ route('services') }}">Services</a></li>

              {{-- ================= AUTH (Breeze) ================= --}}
              @if (Route::has('login'))
                @auth
                  <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                  <li class="menu-item-has-children">
                    <a href="#">{{ auth()->user()->name ?? 'Account' }}</a>
                    <ul class="dropdown">
                      @if (Route::has('profile.edit'))
                        <li><a href="{{ route('profile.edit') }}">Profile</a></li>
                      @endif
                      <li>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                          Logout
                        </a>
                      </li>
                    </ul>
                  </li>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                @endauth
              @endif
              {{-- =============== END AUTH ================= --}}
            </ul>
          </nav>

          <div class="header__nav__social d-none d-lg-flex">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-dribbble"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
            <a href="#"><i class="fa fa-youtube-play"></i></a>
          </div>
        </div>
      </div>

    </div>
    <div id="mobile-menu-wrap"></div>
  </div>
</header>
<!-- Header End -->

<!-- Hero Section Begin -->
<section class="hero">
    <div class="hero__slider owl-carousel">

        <!-- Slide 1 -->
        <div class="hero__item set-bg" data-setbg="{{ asset('img/hero/hero-1.jpg') }}">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-6">
                        <div class="hero__text">
                            <span>Website resmi Mriki_Project</span>
                            <h2>Solusi Layanan Videographer dan Pilot Drone</h2>
                            <a href="{{ route('login') }}" class="primary-btn">Booking Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="hero__item set-bg" data-setbg="{{ asset('img/hero/hero-1.jpg') }}">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-6">
                        <div class="hero__text">
                            <span>Website resmi Mriki_Project</span>
                            <h2>Layanan Fhotographer untuk Segala Jenis Kebutuhan</h2>
                            <a href="{{ route('login') }}" class="primary-btn">Booking Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="hero__item set-bg" data-setbg="{{ asset('img/hero/hero-1.jpg') }}">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-6">
                        <div class="hero__text">
                            <span>Website resmi Mriki_Project</span>
                            <h2>Melayani Penjualan Maupun Pembeliaan Unit Drone Profesional</h2>
                            <a href="{{ route('login') }}" class="primary-btn">Pesan Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <!-- Slide 4 -->
        <div class="hero__item set-bg" data-setbg="{{ asset('img/hero/hero-1.jpg') }}">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-6">
                        <div class="hero__text">
                            <span>Website resmi Mriki_Project</span>
                            <h2>Tersedia Layanan Servis, Maintenance, Perbaikan Unit Drone</h2>
                            <a href="{{ route('login') }}" class="primary-btn">Pesan Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Hero Section End -->

<!-- Services Section Begin -->
<section class="services spad">
  <div class="container">
    <div class="row">

      <div class="col-lg-4">
        <div class="services__title">
          <div class="section-title">
            <span>Tersedia 4 Layanan</span>
            <h2>Konsultasikan Segera!</h2>
          </div>

          <p>
            Mriki_Project menyediakan layanan dokumentasi udara & darat, perawatan unit drone,
            serta pemesanan drone sesuai kebutuhan profesional.
          </p>

          <a href="{{ \Illuminate\Support\Facades\Route::has('services') ? route('services') : '#' }}"
             class="primary-btn">
            View all services
          </a>
        </div>
      </div>

      <div class="col-lg-8">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="services__item">
              <div class="services__item__icon d-flex align-items-center justify-content-center"
                   style="width:72px;height:72px;border:1px solid rgba(0,199,255,.55);border-radius:8px;">
                <i class="fa fa-paper-plane" style="font-size:26px;color:#00c7ff;"></i>
              </div>
              <h4>Booking Jasa Drone</h4>
              <p>Layanan foto & video udara untuk dokumentasi project, event, dan kebutuhan komersial.</p>
              @if (\Illuminate\Support\Facades\Route::has('booking.drone'))
                <a href="{{ route('booking.drone') }}" class="read__more">Booking sekarang <span class="arrow_right"></span></a>
              @endif
            </div>
          </div>

          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="services__item">
              <div class="services__item__icon d-flex align-items-center justify-content-center"
                   style="width:72px;height:72px;border:1px solid rgba(0,199,255,.55);border-radius:8px;">
                <i class="fa fa-video-camera" style="font-size:26px;color:#00c7ff;"></i>
              </div>
              <h4>Photographer & Videographer</h4>
              <p>Dokumentasi darat profesional untuk event, produk, company profile, dan konten media.</p>
              @if (\Illuminate\Support\Facades\Route::has('booking.crews'))
                <a href="{{ route('booking.crews') }}" class="read__more">Booking sekarang <span class="arrow_right"></span></a>
              @endif
            </div>
          </div>

          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="services__item">
              <div class="services__item__icon d-flex align-items-center justify-content-center"
                   style="width:72px;height:72px;border:1px solid rgba(0,199,255,.55);border-radius:8px;">
                <i class="fa fa-cog" style="font-size:26px;color:#00c7ff;"></i>
              </div>
              <h4>Servis Unit Drone</h4>
              <p>Perawatan, perbaikan, dan pengecekan drone agar tetap optimal dan aman digunakan.</p>
              @if (\Illuminate\Support\Facades\Route::has('servis.drone'))
                <a href="{{ route('servis.drone') }}" class="read__more">Konsultasi servis <span class="arrow_right"></span></a>
              @endif
            </div>
          </div>

          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="services__item">
              <div class="services__item__icon d-flex align-items-center justify-content-center"
                   style="width:72px;height:72px;border:1px solid rgba(0,199,255,.55);border-radius:8px;">
                <i class="fa fa-cube" style="font-size:26px;color:#00c7ff;"></i>
              </div>
              <h4>Order Unit Drone</h4>
              <p>Pemesanan unit drone dengan konsultasi spesifikasi sesuai kebutuhan pekerjaan.</p>
              @if (\Illuminate\Support\Facades\Route::has('order.drone'))
                <a href="{{ route('order.drone') }}" class="read__more">Order sekarang <span class="arrow_right"></span></a>
              @endif
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>
<!-- Services Section End -->

<!-- Work Section Begin (UPDATED: ambil dari models) -->
<section class="work">
  <div class="work__gallery">
    <div class="grid-sizer"></div>

    @foreach($workItems as $w)
      @php
        $p = $w['data'];
        if (!$p) continue;

        $cover = $p->cover;
        $youtube = $isYoutube($cover);

        $bg = $youtube ? $fallbackBg : ($coverUrl($cover) ?? $fallbackBg);
        $videoLink = $youtube ? $cover : null;
      @endphp

      <div class="work__item {{ $w['size'] }} set-bg" data-setbg="{{ $bg }}">
        @if($videoLink)
          <a href="{{ $videoLink }}" class="play-btn video-popup"><i class="fa fa-play"></i></a>
        @endif

        <div class="work__item__hover">
          <h4>{{ $p->judul }}</h4>
          <ul>
            <li>{{ $w['tag1'] }}</li>
            <li>{{ $w['tag2'] }}</li>
          </ul>
        </div>
      </div>
    @endforeach

  </div>
</section>
<!-- Work Section End -->

<!-- Counter Section Begin -->
<section class="counter">
    <div class="container">
        <div class="counter__content">
            <div class="row">

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter__item">
                        <div class="counter__item__text">
                            <img src="{{ asset('img/icons/ci-1.png') }}" alt="">
                            <h2 class="counter_num">2019</h2>
                            <p>Mulai Berjalan</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter__item second__item">
                        <div class="counter__item__text">
                            <img src="{{ asset('img/icons/ci-2.png') }}" alt="">
                            <h2 class="counter_num">4</h2>
                            <p>Layanan Utama</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter__item third__item">
                        <div class="counter__item__text">
                            <img src="{{ asset('img/icons/ci-3.png') }}" alt="">
                            <h2 class="counter_num">2023</h2>
                            <p>Mulai Servis</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter__item four__item">
                        <div class="counter__item__text">
                            <img src="{{ asset('img/icons/ci-4.png') }}" alt="">
                            <h2 class="counter_num">2026</h2>
                            <p>Mulai WCC</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- Counter Section End -->

<section class="latest spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="section-title center-title">
          <span>Blog Mriki_Project</span>
          <h2>Update Terbaru</h2>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="latest__slider owl-carousel">
        @foreach($latestNews as $n)
          <div class="col-lg-4">
            <div class="blog__item latest__item">
              <h4>{{ $n->title }}</h4>
              <ul>
                <li>{{ optional($n->published_at)->format('M d, Y') }}</li>
                <li>{{ $n->source }}</li>
              </ul>
              <p>{{ $n->excerpt ?? 'Baca detail selengkapnya di sumber.' }}</p>
              <a href="{{ $n->url }}" target="_blank">Read more <span class="arrow_right"></span></a>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<section class="callto spad set-bg" data-setbg="{{ asset('img/callto-bg.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="callto__text">
                    <h2>Butuh Dokumentasi Drone yang Cinematic & Profesional?</h2>
                    <p>Booking sekarang untuk layanan Drone, Tim Darat, Servis Unit Drone, atau Order Unit Drone.</p>

                    @php
                        $safe = function ($name) {
                            return \Illuminate\Support\Facades\Route::has($name) ? route($name) : '#';
                        };
                    @endphp

                    <a href="{{ $safe('booking.drone') }}">Booking Jasa Drone</a>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="container">
        <div class="footer__option">
            <div class="row">

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="footer__option__item">
                        <h5>Tentang Mriki_Project</h5>
                        <p>
                            Mriki_Project melayani dokumentasi udara (drone) dan tim darat / udara untuk kebutuhan event, company profile,
                            hingga progress proyek. Fokus kami: hasil rapi, aman, dan sinematik.
                        </p>
                        <a href="{{ \Illuminate\Support\Facades\Route::has('about') ? route('about') : '#' }}" class="read__more">
                            Selengkapnya <span class="arrow_right"></span>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="footer__option__item">
                        <h5>Menu</h5>
                        <ul>
                            <li><a href="{{ \Illuminate\Support\Facades\Route::has('home') ? route('home') : '#' }}">Dashboard</a></li>
                            <li><a href="{{ \Illuminate\Support\Facades\Route::has('portfolio') ? route('portfolio') : '#' }}">Portofolio</a></li>
                            <li><a href="{{ \Illuminate\Support\Facades\Route::has('services') ? route('services') : '#' }}">Layanan</a></li>
                            <li><a href="{{ \Illuminate\Support\Facades\Route::has('contact') ? route('contact') : '#' }}">Kontak</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="footer__option__item">
                        <h5>Layanan</h5>
                        <ul>
                            <li><a href="{{ \Illuminate\Support\Facades\Route::has('booking.drone') ? route('booking.drone') : '#' }}">Booking Jasa Drone</a></li>
                            <li><a href="{{ \Illuminate\Support\Facades\Route::has('booking.crews') ? route('booking.crews') : '#' }}">Booking Tim Darat</a></li>
                            <li><a href="{{ \Illuminate\Support\Facades\Route::has('servis.drone') ? route('servis.drone') : '#' }}">Servis Unit Drone</a></li>
                            <li><a href="{{ \Illuminate\Support\Facades\Route::has('order.drone') ? route('order.drone') : '#' }}">Order Unit Drone</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="footer__option__item">
                        <h5>Kontak Cepat</h5>
                        <p>Tinggalkan email untuk konsultasi/penawaran. Kami balas secepatnya.</p>

                        <form action="{{ \Illuminate\Support\Facades\Route::has('contact') ? route('contact') : '#' }}" method="GET">
                            <input type="text" name="email" placeholder="Email kamu">
                            <button type="submit"><i class="fa fa-send"></i></button>
                        </form>

                        <div style="margin-top:14px;">
                            <a href="#" style="margin-right:12px;"><i class="fa fa-instagram"></i></a>
                            <a href="#" style="margin-right:12px;"><i class="fa fa-youtube-play"></i></a>
                            <a href="#" style="margin-right:12px;"><i class="fa fa-whatsapp"></i></a>
                            <a href="#"><i class="fa fa-envelope"></i></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="footer__copyright">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p class="footer__copyright__text">
                        Copyright &copy;
                        <script>document.write(new Date().getFullYear());</script>
                        Mriki_Project. All rights reserved.
                    </p>
                </div>
            </div>
        </div>

    </div>
</footer>

<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('js/mixitup.min.js') }}"></script>
<script src="{{ asset('js/masonry.pkgd.min.js') }}"></script>
<script src="{{ asset('js/jquery.slicknav.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
