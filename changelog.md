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
  - Menampilkan rincian tipe jadwal acara (Harian/Jam) di kolom Detail Pemesanan pada tabel aktivitas dashboard admin dan daftar booking drone.
- **Pembaruan Halaman Form Booking Drone**:
  - Menambahkan input dinamis **Rincian Jadwal Acara** pada pop-up modal **Booking Sekarang** di bawah kolom DP Booking Tanggal:
    - Dropdown berisi pilihan: **Acara Harian** dan **Acara Waktu Jam**.
    - Jika memilih **Acara Harian**: Menampilkan input untuk Tanggal Selesai Acara (date) dan Estimasi Waktu Selesai (time).
    - Jika memilih **Acara Waktu Jam**: Menampilkan info Tanggal Acara otomatis yang disesuaikan dengan Tanggal Booking, serta menampilkan input untuk Waktu Mulai Acara (time).
  - Menambahkan validasi dinamis di frontend (JS) dan backend (Laravel rules):
    - Mengunci tanggal pilihan minimal (*min date*) pada Tanggal Selesai Acara agar bernilai H+1 setelah Tanggal Booking/Acara.
    - Menolak pengiriman form via event handler `submit` jika Tanggal Selesai kurang dari atau sama dengan Tanggal Booking.
    - Menambahkan aturan backend `after:tanggal` untuk mencegah manipulasi request data.
  - Menambahkan migrasi database untuk menyimpan kolom `tipe_jadwal`, `tanggal_selesai_acara`, `estimasi_selesai_acara`, dan `waktu_mulai_acara` di tabel `booking_drones` serta memperbarui model dan request validation.
- **Pembaruan Dashboard User**:
  - Mengubah dashboard user ([dashboard.blade.php](file:///e:/website_mriki/website_drone/resources/views/dashboard.blade.php)) agar memuat data riwayat pemesanan secara aktif berdasarkan email akun pengguna yang sedang login.
  - Menampilkan total jumlah transaksi pada grid status secara dinamis.
  - Menambahkan tabel **Riwayat Pengajuan & Pemesanan Anda** lengkap dengan detail jenis layanan, catatan, status pengajuan, nominal DP, tombol pratinjau bukti bayar, dan tombol pintasan chat ("Chat Admin") yang langsung terhubung ke ruang obrolan terkait.
  - Menampilkan rincian tipe jadwal acara (Harian/Jam) yang dipesan di bawah kolom Detail Pengajuan.
  - Menyesuaikan visualisasi status agar sama dengan admin: **"Menunggu Validasi"** (status baru, tanpa bukti DP), **"Menunggu Persetujuan"** (status baru, ada bukti DP), dan **"Diproses"** (status proses).
  - Mengubah keempat kartu status di grid dashboard (Status, Email, Tipe Akun, dan Total Pengajuan) menjadi tautan (`<a>`) yang interaktif:
    - **Status** & **Email** mengarah langsung ke halaman edit profil (`profile.edit`).
    - **Tipe Akun** mengarah ke dashboard admin (`admin.dashboard`) jika login sebagai admin, atau edit profil jika sebagai user biasa.
    - **Total Pengajuan** mengarah langsung (smooth scroll anchor) ke tabel riwayat pengajuan di bagian bawah.

---

## Catatan Rilis & Struktur Proyek
- **Framework**: Laravel 11.x / 10.x (PHP 8.2+) dengan Laravel Breeze & Tailwind CSS.
- **Build Tool**: Vite untuk pemrosesan aset JS/CSS.
