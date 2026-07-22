<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('favicon-256.png') }}">

    <meta name="description" content="Portofolio Mriki_Project - Drone, Foto Video, WCC, Unit DJI">
    <meta name="keywords" content="Mriki_Project, portfolio, drone, wedding, event, proyek, DJI, WCC">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mriki_Project | Portofolio</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- Css Styles (Laravel asset) -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">

    <!-- ====== LOGO SIZE FIX: samakan dengan halaman lain (gede) ====== -->
    <style>
      .logo-fixed{min-height:64px;flex:0 0 160px;}
      @media (max-width:991.98px){.logo-fixed{flex:0 0 140px;}}
      .logo-img{display:block;height:40px;width:auto;object-fit:contain}
      .header__nav__option{min-height:64px}
      .header__nav__menu>ul{align-items:center}
      @media (max-width:991.98px){.header__nav__social{display:none!important}}
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

      /* ✅ NAVBAR TEKS SAJA CENTER (LOGO TETAP) */
      @media (min-width: 992px){
        .header .container{ position:relative; }

        .header__nav__option{ position:relative; }
        .header__nav__social{ margin-left:auto; position:relative; z-index:12; }

        .header__nav__menu{
          position:absolute !important;
          left:36% !important;
          top:50% !important;
          transform:translate(-50%, -50%) !important;
          width:auto !important;
          flex:0 0 auto !important;
          z-index:11;
          max-width: calc(100% - 520px); /* ruang aman logo + social */
        }

        .header__nav__menu > ul{
          justify-content:center !important;
          width:auto !important;
          margin:0 !important;
          flex-wrap:nowrap;
        }
      }
      @media (min-width: 992px) and (max-width: 1199.98px){
        .header__nav__menu{ max-width: calc(100% - 420px); }
        .header__nav__menu > ul{ flex-wrap:wrap; row-gap:10px; }
      }

      /* Footer logo */
      .footer__top__logo img{
        height:80px !important;
        width:auto !important;
        object-fit:contain;
      }
      @media (max-width:575.98px){
        .footer__top__logo img{ height:60px !important; }
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

    // Ambil 1 data dari tiap model (yang terbaru)
    $udara      = PortofolioUdara::latest()->first();
    $darat      = PortofolioDarat::latest()->first();
    $servis     = PortofolioServisDrone::latest()->first();
    $penjualan  = PortofolioPenjualan::latest()->first();

    // Helper deteksi youtube
    $isYoutube = function ($url) {
        if (!$url) return false;
        return Str::contains($url, ['youtube.com', 'youtu.be']);
    };

    // Helper url cover: kalau sudah http → pakai langsung, kalau tidak → asset()
    $coverUrl = function ($path) {
        if (!$path) return asset('img/portfolio/portfolio-1.jpg'); // fallback default
        return Str::startsWith($path, ['http://', 'https://']) ? $path : asset($path);
    };

    // Data yang akan ditampilkan (1 item per model)
    $items = [
        [
            'filter' => 'udara',
            'label1' => 'Jasa Udara',
            'label2' => 'Portofolio Udara',
            'data'   => $udara
        ],
        [
            'filter' => 'darat',
            'label1' => 'Foto/Video Darat',
            'label2' => 'Portofolio Darat',
            'data'   => $darat
        ],
        [
            'filter' => 'servis',
            'label1' => 'Servis Drone',
            'label2' => 'Maintenance',
            'data'   => $servis
        ],
        [
            'filter' => 'penjualan',
            'label1' => 'Penjualan',
            'label2' => 'Unit DJI',
            'data'   => $penjualan
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
              <img src="{{ asset('img/logo.png') }}" alt="Mriki_Project Logo" class="logo-img">
            </a>
          </div>
        </div>

        <div class="col-6 col-lg-10">
          <div class="header__nav__option d-flex align-items-center justify-content-lg-between justify-content-end gap-3">
            <nav class="header__nav__menu mobile-menu flex-grow-1">
              <ul class="d-flex flex-wrap gap-3 mb-0">
                <li class="{{ request()->routeIs('home') ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
                <li class="{{ request()->routeIs('about') ? 'active' : '' }}"><a href="{{ route('about') }}">About</a></li>
                <li class="{{ request()->routeIs('portfolio') ? 'active' : '' }}"><a href="{{ route('portfolio') }}">Portfolio</a></li>
                <li class="{{ request()->routeIs('services') ? 'active' : '' }}"><a href="{{ route('services') }}">Services</a></li>
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

<!-- Breadcrumb Begin -->
<div class="breadcrumb-option spad set-bg" data-setbg="{{ asset('img/breadcrumb-bg.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Portofolio Mriki_Project</h2>
                    <div class="breadcrumb__links">
                        <a href="{{ route('home') }}">Home</a>
                        <span>Portfolio</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Portfolio Section Begin -->
<section class="portfolio spad">
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <ul class="portfolio__filter">
                    <li class="active" data-filter="*">Semua</li>
                    <li data-filter=".udara">Portofolio Udara</li>
                    <li data-filter=".darat">Portofolio Darat</li>
                    <li data-filter=".servis">Portofolio Servis Drone</li>
                    <li data-filter=".penjualan">Portofolio Penjualan</li>
                </ul>
            </div>
        </div>

        <div class="row portfolio__gallery">

            @foreach($items as $it)
                @php
                    $p = $it['data'];
                    if (!$p) continue;

                    $cover = $p->cover;
                    $bg = $coverUrl($cover);
                    $youtube = $isYoutube($cover);
                @endphp

                <div class="col-lg-4 col-md-6 col-sm-6 mix {{ $it['filter'] }}">
                    <div class="portfolio__item">
                        <div class="portfolio__item__video set-bg"
                             data-setbg="{{ $youtube ? asset('img/portfolio/portfolio-1.jpg') : $bg }}">
                            @if($youtube)
                                <a href="{{ $cover }}" class="play-btn video-popup"><i class="fa fa-play"></i></a>
                            @endif
                        </div>

                        <div class="portfolio__item__text">
                            <h4>{{ $p->judul }}</h4>
                            <ul>
                                <li>{{ $it['label1'] }}</li>
                                <li>{{ $it['label2'] }}</li>
                            </ul>

                            <div style="margin-top:8px; opacity:.9; font-size:13px;">
                                <span><i class="fa fa-map-marker"></i> {{ $p->lokasi }}</span>
                                <span style="margin-left:12px;"><i class="fa fa-calendar"></i> {{ $p->tanggal }}</span>
                            </div>

                            <p style="margin-top:10px;">
                                {{ \Illuminate\Support\Str::limit($p->deskripsi, 110) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

    </div>
</section>
<!-- Portfolio Section End -->

<!-- Footer Section Begin -->
<footer class="footer">
    <div class="container">

        <div class="footer__top">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="footer__top__logo">
                        <a href="{{ route('home') }}">
                          <img src="{{ asset('img/logo.png') }}" alt="Mriki_Project">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="footer__top__social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-dribbble"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-youtube-play"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer__option">
            <div class="row">

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="footer__option__item">
                        <h5>Tentang Mriki_Project</h5>
                        <p>
                            Mriki_Project berdiri sejak 2019. Mulai dari penjualan unit drone, berkembang ke jasa udara,
                            dokumentasi event & proyek, servis drone, foto/video darat, hingga WCC.
                        </p>
                        <a href="{{ route('about') }}" class="read__more">Baca selengkapnya <span class="arrow_right"></span></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="footer__option__item">
                        <h5>Menu</h5>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('about') }}">About</a></li>
                            <li><a href="{{ route('portfolio') }}">Portfolio</a></li>
                            <li><a href="{{ route('services') }}">Services</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="footer__option__item">
                        <h5>Layanan</h5>
                        <ul>
                            <li><a href="{{ route('services') }}">Jual Beli DJI</a></li>
                            <li><a href="{{ route('services') }}">Jasa Udara</a></li>
                            <li><a href="{{ route('services') }}">Servis Drone</a></li>
                            <li><a href="{{ route('services') }}">Foto/Video Darat</a></li>
                            <li><a href="{{ route('services') }}">WCC</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="footer__option__item">
                        <h5>Newsletter</h5>
                        <p>Dapatkan update promo & info terbaru dari Mriki_Project.</p>
                        <form action="#">
                            <input type="text" placeholder="Email">
                            <button type="submit"><i class="fa fa-send"></i></button>
                        </form>
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
<!-- Footer Section End -->

<!-- Js Plugins (Laravel asset) -->
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
