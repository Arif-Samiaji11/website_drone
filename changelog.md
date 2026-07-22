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
  - Mengubah label status default `'baru'` menjadi **"Menunggu Validasi"** jika tidak ada bukti bayar DP, atau menjadi **"Menunggu Persetujuan"** jika bukti bayar DP sudah ada. Serta menampilkan status `'proses'` sebagai **"Diproses"**.
  - Menghapus transisi status otomatis dari `'baru'` ke `'proses'` pada `AdminBookingOrderController` agar status tetap "Menunggu Validasi" atau "Menunggu Persetujuan" sampai diproses secara manual oleh admin.
  - Menambahkan tombol aksi **"Kelola"** dinamis yang berubah warna menjadi kuning (amber) saat status pesanan adalah `'proses'`.
  - Mengimplementasikan pop-up modal **Kelola Pesanan** dengan dua tombol tindakan:
    - **Tindakan Kiri**: Chatting langsung dengan pemesan terkait, yang secara otomatis melacak atau menginisialisasi ID Discussion yang sesuai untuk pengguna tersebut berdasarkan email mereka.
    - **Tindakan Kanan**: Memproses Pesanan yang secara instan merubah status pesanan menjadi `'proses'` via AJAX POST request tanpa memuat ulang halaman.
- **Pembaruan Dashboard User**:
  - Mengubah dashboard user ([dashboard.blade.php](file:///e:/website_mriki/website_drone/resources/views/dashboard.blade.php)) agar memuat data riwayat pemesanan secara aktif berdasarkan email akun pengguna yang sedang login.
  - Menampilkan total jumlah transaksi pada grid status secara dinamis.
  - Menambahkan tabel **Riwayat Pengajuan & Pemesanan Anda** lengkap dengan detail jenis layanan, catatan, status pengajuan, nominal DP, tombol pratinjau bukti bayar, dan tombol pintasan chat ("Chat Admin") yang langsung terhubung ke ruang obrolan terkait.
  - Menyesuaikan visualisasi status agar sama dengan admin: **"Menunggu Validasi"** (status baru, tanpa bukti DP), **"Menunggu Persetujuan"** (status baru, ada bukti DP), dan **"Diproses"** (status proses).
  - Mengubah keempat kartu status di grid dashboard (Status, Email, Tipe Akun, dan Total Pengajuan) menjadi tautan (`<a>`) yang interaktif:
    - **Status** & **Email** mengarah langsung ke halaman edit profil (`profile.edit`).
    - **Tipe Akun** mengarah ke dashboard admin (`admin.dashboard`) jika login sebagai admin, atau edit profil jika sebagai user biasa.
    - **Total Pengajuan** mengarah langsung (smooth scroll anchor) ke tabel riwayat pengajuan di bagian bawah.

---

## Catatan Rilis & Struktur Proyek
- **Framework**: Laravel 11.x / 10.x (PHP 8.2+) dengan Laravel Breeze & Tailwind CSS.
- **Build Tool**: Vite untuk pemrosesan aset JS/CSS.
