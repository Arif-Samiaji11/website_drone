# Changelog

Semua perubahan dan perkembangan pada proyek **website_drone** akan dicatat di file ini. Format ini terinspirasi dari [Keep a Changelog](https://keepachangelog.com/id/1.0.0/).

---

## [1.0.0] - 2026-07-22
### Added
- **Initial Commit & Git Setup**: Inisialisasi repositori Git dan push perdana ke GitHub ([Arif-Samiaji11/website_drone](https://github.com/Arif-Samiaji11/website_drone)).
- **Sistem Keanggotaan & Autentikasi**:
  - Integrasi Laravel Breeze untuk Login, Register, Reset Password, Verifikasi Email, dan Manajemen Profil.
  - Penambahan kolom `is_admin` pada tabel `users` untuk membedakan hak akses admin dan user biasa.
- **Fitur Portofolio**:
  - CRUD Portofolio Darat (`portofolio_darats`) lengkap dengan tautan YouTube.
  - CRUD Portofolio Udara (`portofolio_udaras`).
  - CRUD Portofolio Penjualan (`portofolio_penjualans`).
  - CRUD Portofolio Servis Drone (`portofolio_servis_drones`).
- **Sistem Pemesanan (Booking & Order)**:
  - Form pemesanan Crew (`booking_crews`) lengkap dengan pilihan layanan & paket darat.
  - Form pemesanan unit Drone (`booking_drones`).
  - Form pemesanan pembelian Drone (`order_drones`).
  - Form pengajuan Servis Drone (`servis_drones`).
  - Manajemen Down Payment (DP) untuk transaksi pemesanan (`dp_fields`).
- **Sistem Diskusi & Konsultasi**:
  - Modul Chat/Diskusi interaktif (`discussions` & `discussion_messages`) antara pelanggan dan admin.
  - Sistem pelacakan status pesan dibaca (`is_read`) dan tipe servis terkait diskusi.
- **Manajemen Blog / Berita**:
  - Modul Berita (`news_items`) dengan pengelolaan slug URL dinamis.
- **Pengaturan Global Admin**:
  - Konfigurasi Rekening Pembayaran dan Pengaturan Admin (`admin_settings`) yang fleksibel.

### Changed
- **Pembaruan Dashboard Admin**: 
  - Mengubah tampilan dashboard admin ([dashboard.blade.php](file:///e:/website_mriki/website_drone/resources/views/admin/dashboard.blade.php)) menjadi lebih modern, profesional, dan user-friendly.
  - Mengintegrasikan ringkasan statistik (total data & jumlah data baru) dari **Booking Drone**, **Booking Crews**, **Order Drone**, dan **Servis Drone**.
  - Menampilkan tabel **Aktivitas & Pengajuan Terbaru** yang menggabungkan 8 data teranyar dari keempat layanan di atas lengkap dengan status, detail, dan integrasi peta interaktif Leaflet serta modal bukti pembayaran DP.
  - Memperbarui controller ([AdminDashboardController.php](file:///e:/website_mriki/website_drone/app/Http/Controllers/Admin/AdminDashboardController.php)) untuk memuat data agregat secara realtime.

---

## Catatan Rilis & Struktur Proyek
- **Framework**: Laravel 11.x / 10.x (PHP 8.2+) dengan Laravel Breeze & Tailwind CSS.
- **Build Tool**: Vite untuk pemrosesan aset JS/CSS.
