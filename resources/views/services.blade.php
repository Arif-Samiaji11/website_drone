<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('favicon-256.png') }}">

    <meta name="description" content="Mriki_Project - Jasa Drone, Servis Drone, Foto Video, WCC, Jual Beli DJI">
    <meta name="keywords" content="Mriki_Project, drone, DJI, jasa drone, servis drone, foto, video, wcc">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mriki_Project | Layanan</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- Css Styles (Laravel asset biar konsisten) -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">

    <style>
        /* Optional: rapihin tampilan ikon layanan (tetap nyatu sama style template) */
        .services__item__icon {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .services__item__icon i {
            font-size: 40px;
            line-height: 1;
            color: #00c7ff;
        }
        .services__item h4 {
            margin-top: 18px;
        }

        /* =========================
           ✅ SAMAKAN LOGO (TETAP) + NAV TEKS CENTER
           ========================= */

        .logo-fixed { min-height: 64px; flex: 0 0 160px; }
        @media (max-width: 991.98px) { .logo-fixed { flex: 0 0 140px; } }

        .logo-img {
            display: block;
            height: 40px;
            width: auto;
            object-fit: contain;
        }

        .header__nav__option { min-height: 64px; }
        .header__nav__menu > ul { align-items: center; }
        @media (max-width: 991.98px) { .header__nav__social { display: none !important; } }

        /* LOGO: biarkan seperti sebelumnya */
        .header__logo { left: -32px !important; position: relative; }

        .logo-img{
            transform: translate(-48px, 3px) scale(3.0) !important;
            -webkit-transform: translate(-48px, 3px) scale(3.0) !important;
            transform-origin: left center;
        }

        .header .row > .col-6.col-lg-2 { padding-left: 0 !important; padding-right: 0 !important; }

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

        /* ✅ NAVBAR TEKS SAJA CENTER (DESKTOP) */
        @media (min-width: 992px){
            .header .container{ position:relative; }

            .header__nav__option{ position:relative; }
            .header__nav__social{
                margin-left:auto;
                position:relative;
                z-index:12;
            }

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

        /* ✅ Footer logo (boleh tetap, tapi rapihin) */
        .footer__top__logo a{ display:inline-flex; align-items:center; }
        .footer-logo-img{
            height: 80px;
            width: auto;
            object-fit: contain;
            display:block;
        }
        @media (max-width: 575.98px){
            .footer-logo-img{ height: 60px; }
        }
    </style>
</head>

<body>
<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

<!-- Header Section Begin -->
<header class="header">
    <div class="container">
        <div class="row align-items-center">

            <!-- ✅ LOGO (TETAP) -->
            <div class="col-6 col-lg-2">
                <div class="header__logo logo-fixed d-flex align-items-center">
                    <a href="{{ route('home') }}" class="d-inline-flex align-items-center">
                        <img src="{{ asset('img/logo.png') }}" alt="Mriki_Project Logo" width="160" height="40" class="logo-img">
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
                    <h2>Layanan Kami</h2>
                    <div class="breadcrumb__links">
                        <a href="{{ route('home') }}">Home</a>
                        <span>Services</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Services Section Begin -->
<section class="services-page spad">
    <div class="container">
        <div class="row">

            <!-- 1) Jual Beli DJI -->
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="services__item">
                    <div class="services__item__icon">
                        <i class="fa fa-tags" aria-hidden="true"></i>
                    </div>
                    <h4>Jual Beli Drone Profesional (DJI)</h4>
                    <p>
                        Penyediaan unit DJI dan kebutuhan pendukung. Konsultasi pilihan unit sesuai kebutuhan,
                        serta rekomendasi setup yang aman dan siap dipakai.
                    </p>
                </div>
            </div>

            <!-- 2) Jasa Udara Drone -->
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="services__item">
                    <div class="services__item__icon">
                        <i class="fa fa-rocket" aria-hidden="true"></i>
                    </div>
                    <h4>Jasa Udara (Drone)</h4>
                    <p>
                        Pengambilan gambar dan video dari udara untuk wedding, event, dokumentasi proyek,
                        company profile, serta kebutuhan konten yang cinematic.
                    </p>
                </div>
            </div>

            <!-- 3) Servis & Maintenance Drone -->
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="services__item">
                    <div class="services__item__icon">
                        <span style="position:relative; display:inline-block; width:46px; height:46px;">
                            <i class="fa fa-wrench" aria-hidden="true"
                               style="position:absolute; left:50%; top:50%; transform:translate(-50%,-50%) rotate(45deg);"></i>
                            <i class="fa fa-wrench" aria-hidden="true"
                               style="position:absolute; left:50%; top:50%; transform:translate(-50%,-50%) rotate(-45deg);"></i>
                        </span>
                    </div>
                    <h4>Servis & Maintenance Drone</h4>
                    <p>
                        Perawatan, pengecekan, perbaikan, dan penanganan unit drone. Fokus pada kondisi unit
                        supaya tetap stabil, aman, dan performanya terjaga.
                    </p>
                </div>
            </div>

            <!-- 4) Foto & Video Darat -->
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="services__item">
                    <div class="services__item__icon">
                        <i class="fa fa-camera" aria-hidden="true"></i>
                    </div>
                    <h4>Photographer & Videographer (Darat)</h4>
                    <p>
                        Dokumentasi darat untuk wedding, event, dan kebutuhan konten. Cocok untuk detail momen,
                        close-up, dan storytelling yang lebih dekat.
                    </p>
                </div>
            </div>

            <!-- 5) WCC -->
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="services__item">
                    <div class="services__item__icon">
                        <span style="position:relative; display:inline-block; width:46px; height:46px;">
                            <i class="fa fa-heart" aria-hidden="true"
                               style="position:absolute; left:50%; top:48%; transform:translate(-50%,-50%); font-size:36px; opacity:.25;"></i>
                            <i class="fa fa-play-circle" aria-hidden="true"
                               style="position:absolute; left:50%; top:52%; transform:translate(-50%,-50%); font-size:42px;"></i>
                        </span>
                    </div>
                    <h4>WCC (Wedding Content Creator)</h4>
                    <p>
                        Konten wedding untuk media sosial: highlight cepat, behind-the-scenes, dan momen penting.
                        File siap upload dengan gaya yang rapi dan konsisten.
                    </p>
                </div>
            </div>

            <!-- 6) Konsultasi -->
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="services__item">
                    <div class="services__item__icon">
                        <i class="fa fa-comments" aria-hidden="true"></i>
                    </div>
                    <h4>Konsultasi & Perencanaan Shoot</h4>
                    <p>
                        Bantu susun kebutuhan shot, lokasi, jadwal, dan output. Cocok buat yang pengin hasil rapi,
                        tapi tetap praktis dan tepat sasaran.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- Services Section End -->

<!-- Call To Action Section Begin -->
<section class="callto sp__callto">
    <div class="container">
        <div class="callto__services spad set-bg" data-setbg="{{ asset('img/calltos-bg.jpg') }}">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-10 text-center">
                    <div class="callto__text">
                        <h2>KONSULTASIKAN KEBUTUHAN DRONE & KONTEN ANDA</h2>
                        <p>Mulai dari pilihan unit, pengambilan gambar udara, servis drone, sampai dokumentasi darat & WCC.</p>
                        <a href="#">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Call To Action Section End -->

<!-- Footer Section Begin -->
<footer class="footer">
    <div class="container">
        <div class="footer__top">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="footer__top__logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('img/logo.png') }}" alt="Mriki_Project" class="footer-logo-img">
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
                            Sejak 2019, Mriki_Project berkembang dari penjualan unit drone hingga layanan profesional:
                            jasa udara, servis drone, dokumentasi darat, dan WCC.
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
                            <li><a href="{{ route('services') }}">Foto/Video</a></li>
                            <li><a href="{{ route('services') }}">WCC</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="footer__option__item">
                        <h5>Newsletter</h5>
                        <p>Dapatkan update promo & info layanan terbaru dari Mriki_Project.</p>
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
