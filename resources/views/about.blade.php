<!DOCTYPE html>
<html lang="id">

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

    <!-- ====== Override kecil agar logo SAMA dengan halaman HOME ====== -->
    <style>
      .logo-fixed{min-height:64px;flex:0 0 160px;}
      @media (max-width:991.98px){.logo-fixed{flex:0 0 140px;}}
      .logo-img{display:block;height:40px;width:auto;object-fit:contain}
      .header__nav__option{min-height:64px}
      .header__nav__menu>ul{align-items:center}
      @media (max-width:991.98px){.header__nav__social{display:none!important}}
    </style>

    <style>
      /* Dorong wrapper logo lebih kiri (LOGO TETAP, JANGAN DIUBAH) */
      .header__logo{
        left:-32px !important;
      }

      /* Samakan visual logo: translate + scale (SAMA dengan home) */
      .logo-img{
        transform: translate(-48px, 3px) scale(3.0) !important;
        -webkit-transform: translate(-48px, 3px) scale(3.0) !important;
        transform-origin: left center;
      }

      /* Pastikan kolom pertama benar-benar tanpa padding kiri */
      .header .row > .col-6.col-lg-2{ padding-left:0 !important; padding-right:0; }

      /* Responsif logo */
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
         ✅ NAVBAR TEKS SAJA DI TENGAH (LOGO TIDAK DIUBAH)
         - Center menu berdasarkan .container header (global)
         - Social tetap di kanan
         - Mobile tetap slicknav normal
         ========================================================= */
      @media (min-width: 992px){
        .header .container{ position:relative; }

        /* social tetap kanan */
        .header__nav__option{ position:relative; }
        .header__nav__social{ margin-left:auto; position:relative; z-index:12; }

        /* menu absolute center */
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

      /* layar medium: biar gak tabrakan, tapi tetap center */
      @media (min-width: 992px) and (max-width: 1199.98px){
        .header__nav__menu{ max-width: calc(100% - 420px); }
        .header__nav__menu > ul{ flex-wrap:wrap; row-gap:10px; }
      }
    </style>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    @php
        $safe = function ($name) {
            return \Illuminate\Support\Facades\Route::has($name) ? route($name) : '#';
        };
    @endphp

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row align-items-center">

                {{-- ✅ LOGO: dibuat SAMA persis dengan halaman HOME --}}
                <div class="col-6 col-lg-2">
                    <div class="header__logo logo-fixed d-flex align-items-center">
                        <a href="{{ $safe('home') }}" class="d-inline-flex align-items-center">
                            <img src="{{ asset('img/logo.png') }}"
                                 alt="Mriki_Project Logo"
                                 width="160" height="40"
                                 class="logo-img">
                        </a>
                    </div>
                </div>

                {{-- NAV --}}
                <div class="col-6 col-lg-10">
                    <div class="header__nav__option d-flex align-items-center justify-content-lg-between justify-content-end gap-3">
                        <nav class="header__nav__menu mobile-menu flex-grow-1">
                            <ul class="d-flex flex-wrap gap-3 mb-0">
                                <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                                    <a href="{{ $safe('home') }}">Home</a>
                                </li>

                                <li class="{{ request()->routeIs('about') ? 'active' : '' }}">
                                    <a href="{{ $safe('about') }}">Tentang</a>
                                </li>

                                <li class="{{ request()->routeIs('portfolio') ? 'active' : '' }}">
                                    <a href="{{ $safe('portfolio') }}">Portofolio</a>
                                </li>

                                <li class="{{ request()->routeIs('services') ? 'active' : '' }}">
                                    <a href="{{ $safe('services') }}">Layanan</a>
                                </li>
                            </ul>
                        </nav>

                        <div class="header__nav__social d-none d-lg-flex">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
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
                        <h2>Tentang Mriki_Project</h2>
                        <div class="breadcrumb__links">
                            <a href="{{ $safe('home') }}">Home</a>
                            <span>Tentang</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- About Section Begin -->
    <section class="about spad">
        <div class="container">
            <div class="row">

                {{-- FOTO ABOUT (boleh ganti file gambarnya) --}}
                <div class="col-lg-6">
                    <div class="about__pic">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="about__pic__item about__pic__item--large set-bg"
                                     data-setbg="{{ asset('img/about/about-1.jpg') }}"></div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="about__pic__item set-bg" data-setbg="{{ asset('img/about/about-2.jpg') }}"></div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="about__pic__item set-bg" data-setbg="{{ asset('img/about/about-3.jpg') }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TEKS ABOUT --}}
                <div class="col-lg-6">
                    <div class="about__text">
                        <div class="section-title">
                            <span>Mriki_Project</span>
                            <h2>Sejarah & Perjalanan</h2>
                        </div>

                        {{-- Highlight 2 layanan (kotak kecil) --}}
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="services__item">
                                    <div class="services__item__icon">
                                        <img src="{{ asset('img/icons/si-1.png') }}" alt="">
                                    </div>
                                    <h4>Jasa Udara Drone</h4>
                                    <p>Dokumentasi udara cinematic untuk event & project sejak 2021.</p>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="services__item">
                                    <div class="services__item__icon">
                                        <img src="{{ asset('img/icons/si-2.png') }}" alt="">
                                    </div>
                                    <h4>Servis & Maintenance</h4>
                                    <p>Perbaikan & perawatan unit drone dimulai sejak 2023.</p>
                                </div>
                            </div>
                        </div>

                        {{-- SEJARAH FULL --}}
                        <div class="about__text__desc">
                            <p>
                                Sejarah Mriki_Project dimulai pada tahun <strong>2019</strong>, berawal dari bidang
                                <strong>penjualan unit drone toys</strong>. Memasuki tahun <strong>2021</strong>, Mriki_Project
                                mulai menyediakan unit profesional dari brand <strong>DJI</strong> dan mulai menerima pekerjaan jasa
                                pengambilan kebutuhan <strong>surveying</strong> di beberapa jalan tol dan jalan rusak untuk kebutuhan
                                pembaruan/pemeliharaan.
                            </p>

                            <p>
                                Di periode yang sama, Mriki_Project juga berjalan dengan layanan dokumentasi
                                <strong>wedding udara</strong>, <strong>event acara</strong>, <strong>hari besar</strong>, serta
                                <strong>yearbook sekolah</strong> dari SMP hingga SMA/SMK.
                            </p>

                            <p>
                                Memasuki tahun <strong>2022</strong>, Mriki_Project mengikuti kursus pelatihan non-sertifikat
                                untuk memperdalam bidang layanan jasa drone. Pada tahun <strong>2023</strong>, Mriki_Project mulai
                                menyediakan layanan <strong>servis & maintenance all unit drone</strong> sekaligus membuka layanan
                                darat sebagai <strong>photographer & videographer</strong>, dan berjalan sampai sekarang.
                            </p>

                            <p>
                                Mulai tahun <strong>2026</strong>, Mriki_Project menambah layanan darat khusus
                                <strong>WCC (Wedding Content Creator)</strong>, dan terus berjalan hingga saat ini.
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- About Section End -->

    <!-- Testimonial Section Begin -->
    <section class="testimonial spad set-bg" data-setbg="{{ asset('img/testimonial-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title center-title">
                        <span>Dipercaya Klien</span>
                        <h2>Apa kata mereka?</h2>
                    </div>
                </div>
            </div>

            {{-- Testimoni template (boleh kamu ganti isi nanti) --}}
            <div class="row">
                <div class="testimonial__slider owl-carousel">

                    <div class="col-lg-4">
                        <div class="testimonial__item">
                            <div class="testimonial__text">
                                <p>Hasil dokumentasi rapi, komunikasi enak, dan output videonya cinematic.</p>
                            </div>
                            <div class="testimonial__author">
                                <div class="testimonial__author__pic">
                                    <img src="{{ asset('img/testimonial/ta-1.jpg') }}" alt="">
                                </div>
                                <div class="testimonial__author__text">
                                    <h5>Klien Event</h5>
                                    <span>Dokumentasi</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="testimonial__item">
                            <div class="testimonial__text">
                                <p>Survey lokasi cepat, aman, dan hasilnya membantu untuk laporan proyek.</p>
                            </div>
                            <div class="testimonial__author">
                                <div class="testimonial__author__pic">
                                    <img src="{{ asset('img/testimonial/ta-2.jpg') }}" alt="">
                                </div>
                                <div class="testimonial__author__text">
                                    <h5>Klien Proyek</h5>
                                    <span>Survey</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="testimonial__item">
                            <div class="testimonial__text">
                                <p>Servis unit drone cepat, jelas diagnosa, dan unit kembali normal.</p>
                            </div>
                            <div class="testimonial__author">
                                <div class="testimonial__author__pic">
                                    <img src="{{ asset('img/testimonial/ta-3.jpg') }}" alt="">
                                </div>
                                <div class="testimonial__author__text">
                                    <h5>Klien Servis</h5>
                                    <span>Maintenance</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
    <!-- Testimonial Section End -->

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

    <!-- Footer Section Begin -->
    <footer class="footer">
        <div class="container">
            <div class="footer__top">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                      <div class="footer__top__logo">
                        <a href="{{ $safe('home') }}">
                          <img src="{{ asset('img/logo.png') }}"
                               alt="Mriki_Project"
                               style="height:80px;width:auto;object-fit:contain;"
                               class="footer-logo-img">
                        </a>
                      </div>
                    </div>

                    <style>
                      @media (max-width: 575.98px){
                        .footer-logo-img{ height:60px !important; }
                      }
                    </style>

                    <div class="col-lg-6 col-md-6">
                        <div class="footer__top__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
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
                            <h5>Tentang Kami</h5>
                            <p>
                                Mriki_Project melayani jual-beli drone DJI, jasa udara drone, servis/maintenance,
                                tim darat foto & video, serta WCC untuk kebutuhan wedding.
                            </p>
                            <a href="{{ $safe('about') }}" class="read__more">
                                Selengkapnya <span class="arrow_right"></span>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3 col-sm-3">
                        <div class="footer__option__item">
                            <h5>Menu</h5>
                            <ul>
                                <li><a href="{{ $safe('home') }}">Home</a></li>
                                <li><a href="{{ $safe('portfolio') }}">Portofolio</a></li>
                                <li><a href="{{ $safe('services') }}">Layanan</a></li>
                                <li><a href="{{ $safe('contact') }}">Kontak</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3 col-sm-3">
                        <div class="footer__option__item">
                            <h5>Layanan</h5>
                            <ul>
                                <li><a href="{{ $safe('order.drone') }}">Jual Beli Drone DJI</a></li>
                                <li><a href="{{ $safe('booking.drone') }}">Jasa Udara Drone</a></li>
                                <li><a href="{{ $safe('servis.drone') }}">Servis & Maintenance</a></li>
                                <li><a href="{{ $safe('booking.crews') }}">Foto & Video Darat</a></li>
                                <li><a href="#">WCC (Wedding Content Creator)</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12">
                        <div class="footer__option__item">
                            <h5>Kontak Cepat</h5>
                            <p>Masukkan email untuk konsultasi/penawaran. Kami akan balas secepatnya.</p>
                            <form action="{{ $safe('contact') }}" method="GET">
                                <input type="text" name="email" placeholder="Email">
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
