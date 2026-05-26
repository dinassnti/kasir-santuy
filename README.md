# Kasir Santuy 🖥️🛒

**Kasir Santuy** adalah aplikasi Point of Sales (POS) berbasis web yang dirancang untuk mempermudah manajemen transaksi, inventaris barang, dan pelaporan keuangan toko secara efisien dan responsif. Aplikasi ini dibangun menggunakan framework **Laravel** dan didukung oleh ekosistem modern untuk performa yang optimal.

*Catatan: Aplikasi ini saat ini sedang dalam **Masa Perbaikan dan Pengembangan Lebih Lanjut (Under Development / Maintenance)** untuk memaksimalkan performa fitur sistem serta memperketat sistem pembatasan Hak Akses (Akses Kontrol / Multi-user) agar lebih aman dan optimal.*

---

## Struktur Fitur & Manajemen Data (Tabel Sistem)
Aplikasi ini mengelola berbagai entitas data utama untuk mendukung operasional kasir secara menyeluruh, yang meliputi:
- **Profil (User):** Mengelola informasi data diri pengguna yang terdaftar di dalam sistem.
- **Data Staff:** Mengatur informasi karyawan beserta pembagian perannya dalam operasional toko.
- **Hak Akses (Role & Permission) *[Dalam Perbaikan]*:** Mengatur pembatasan akses sistem (seperti Admin dan Staff) agar setiap fungsi aplikasi berjalan sesuai porsi tanggung jawabnya.
- **Toko:** Mengatur konfigurasi dan identitas utama toko (Nama toko, alamat, kontak, dll).
- **Kategori:** Pengelompokan produk untuk mempermudah pencarian dan pengorganisasian barang.
- **Produk:** Manajemen data barang yang dijual, meliputi nama, harga, kode produk (SKU), dan relasi kategorinya.
- **Manajemen Stok:** Melacak sirkulasi, jumlah ketersediaan, serta riwayat penambahan atau pengurangan stok barang secara real-time.
- **Diskon:** Pengaturan potongan harga otomatis maupun manual yang dapat diterapkan pada produk atau event tertentu saat transaksi.
- **Transaksi:** Proses kasir (checkout) utama yang mencatat pembelian produk oleh pelanggan beserta metode pembayarannya.
- **Laporan Transaksi:** Rekapitulasi dan visualisasi data penjualan berkala untuk analisis keuntungan dan performa toko.

---

## Teknologi yang Digunakan
- **Back-End:** Laravel (PHP)
- **Database:** MySQL
- **Front-End:** Tailwind CSS / Bootstrap & JavaScript (Vite / Mix)
- **Package Manager:** Composer (PHP) & NPM (Node.js)

---

## Panduan Instalasi & Replikasi Project

Ikuti langkah-langkah di bawah ini secara berurutan untuk menjalankan project **Kasir Santuy** di perangkat lokal Anda.

### 1. Prasyarat (Prerequisites)
Sebelum memulai, pastikan perangkat Anda sudah terinstal perangkat lunak berikut:
* **PHP** (Minimal versi 8.1 atau sesuai kebutuhan Laravel project ini)
* **MySQL / XAMPP**
* **Composer** (Gunakan perintah `composer --version` di terminal untuk mengeceknya)
* **Node.js & NPM**

---

### 2. Langkah-Langkah Menjalankan Project
Buka terminal atau Command Prompt (`cmd`), masuk ke direktori folder project (`kasir-santuy-main`), lalu jalankan perintah-perintah berikut:

#### A. Install Dependencies PHP
Unduh semua library PHP yang dibutuhkan oleh Laravel yang terdaftar di `composer.json`:
```
composer install
```

#### B. Konfigurasi Environment File
Salin file konfigurasi .env.example menjadi .env untuk mengatur konfigurasi lokal Anda:
````
copy .env.example .env
````

* **Di PowerShell / Linux / macOS:**
```
cp .env.example .env
```

#### C. Generate Application Security Key
Buat key enkripsi unik untuk aplikasi Anda yang akan disimpan di dalam file `.env`:
```
php artisan key:generate
```

#### D. Migrasi Database
Jalankan migrasi untuk membuat seluruh struktur tabel (User, Produk, Kategori, Diskon, Staff, Transaksi, Toko, Manajemen Stok, dan Laporan) ke dalam database Anda:
```
php artisan migrate
```

#### E. Kompilasi Asset Front-End
Install dependencies Node.js dan lakukan build pada asset front-end (CSS/JavaScript) menggunakan Vite/Webpack:
```
npm install
npm run build
```

#### F. Menjalankan Server Lokal
Aplikasi sekarang siap digunakan! Jalankan server pengembangan lokal Laravel dengan perintah:
```
php artisan serve
```
