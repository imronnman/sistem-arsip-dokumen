# Sistem Arsip Dokumen (Digital Document Archive)

Aplikasi web **Sistem Arsip Dokumen** sederhana berbasis **CodeIgniter 4** dan **MySQL** yang dirancang untuk mengelola, mengarsipkan, melihat pratinjau (*preview*), serta mengunduh berkas dokumen digital secara aman, rapi, dan responsif.

Dibuat untuk memenuhi tugas: **Technical Test – Web Developer**.

---

## Fitur Utama

### 1. Autentikasi Pengguna
* Login menggunakan kombinasi email dan password terenkripsi (`password_hash` / `password_verify`).
* Filter autentikasi (*Middleware*) untuk membatasi akses URL hanya untuk pengguna yang telah terotentikasi.
* Manajemen sesi (*Session*) dan Logout.

### 2. Manajemen Kategori Arsip (CRUD)
* Menampilkan daftar kategori beserta jumlah arsip yang tersimpan.
* Tambah kategori baru dengan modal responsif.
* Edit nama dan deskripsi kategori.
* Hapus kategori dengan konfirmasi interaktif SweetAlert2.

### 3. Manajemen Arsip Dokumen (CRUD)
* Menampilkan daftar arsip dokumen lengkap (Judul, Kategori, Format, Ukuran, Tanggal Unggah).
* Filter daftar arsip berdasarkan kategori.
* Unggah berkas baru dengan validasi ekstensi (`PDF`, `JPG`, `JPEG`, `PNG`) dan batasan ukuran berkas (Maks. 5 MB).
* Pratinjau berkas (*Preview Document*) langsung di peramban web (*browser*).
* Unduh berkas (*Download*) dengan nama file asli saat diunggah.
* Edit metadata arsip dan opsi penggantian file lama secara otomatis.
* Hapus arsip dokumen beserta penghapusan berkas fisik di server secara bersih.

### 4. Manajemen Pengguna & Petugas (CRUD Users)
* Menampilkan daftar seluruh pengguna/petugas yang memiliki akses ke sistem.
* Tambah akun pengguna baru langsung dari dalam antarmuka aplikasi.
* Edit nama, email, dan reset/ganti password pengguna.
* Hapus akun pengguna (dilengkapi proteksi agar pengguna tidak bisa menghapus akunnya sendiri yang sedang aktif login).

### 5. Tampilan & UI/UX
* Tampilan antarmuka modern dan responsif berbasis **Bootstrap 5.3** dan **Bootstrap Icons**.
* Notifikasi *Flash Message* interaktif dan konfirmasi aksi menggunakan **SweetAlert2**.

---

## Spesifikasi Teknologi

* **Framework:** CodeIgniter 4 (v4.3.8)
* **Bahasa Pemrograman:** PHP >= 8.0 / 8.1 / 8.2
* **Database:** MySQL / MariaDB
* **Frontend:** Bootstrap 5.3, Bootstrap Icons, SweetAlert2
* **Web Server:** Apache (XAMPP / Laragon)

---

## Kredensial Akun Pengujian (Testing)

Untuk keperluan review dan pengujian aplikasi, silakan gunakan akun berikut:

| Peran | Alamat Email | Password |
| :--- | :--- | :--- |
| **Administrator** | `admin@arsip.com` | `password123` |

---

## Panduan Instalasi Lokal

### 1. Clone atau Unduh Repository
Letakkan folder proyek di dalam direktori web server Anda (misalnya `htdocs` untuk XAMPP):
```bash
cd C:\xampp\htdocs\
git clone https://github.com/username/sistem-arsip.git
```

### 2. Konfigurasi Database
1. Buka **XAMPP Control Panel**, nyalakan modul **Apache** dan **MySQL**.
2. Akses phpMyAdmin di peramban web: `http://localhost/phpmyadmin/`
3. Buat database baru bernama:
   ```sql
   CREATE DATABASE db_arsip_dokumen;
   ```
4. Impor file **`database.sql`** yang tersedia di direktori *root* proyek ini ke dalam database `db_arsip_dokumen`.

### 3. Konfigurasi File Lingkungan (`.env`)
Pastikan file `.env` sudah sesuai dengan konfigurasi server lokal Anda:
```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost/sistem-arsip/public/'

database.default.hostname = localhost
database.default.database = db_arsip_dokumen
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.port     = 3306
```

### 4. Menjalankan Aplikasi
Buka peramban web dan akses URL:
```text
http://localhost/sistem-arsip/public/
```
Anda akan diarahkan ke halaman login. Masukkan email dan password akun pengujian di atas.

---

## Struktur Direktori Proyek

```text
sistem-arsip/
├── app/
│   ├── Config/
│   │   ├── Filters.php      # Registrasi Auth Filter
│   │   └── Routes.php       # Definisi URL & Route Grouping
│   ├── Controllers/
│   │   ├── Archives.php     # Controller CRUD Arsip, Preview & Download
│   │   ├── Auth.php         # Controller Login & Logout
│   │   ├── Categories.php   # Controller CRUD Kategori
│   │   └── Dashboard.php    # Controller Ringkasan Statistik
│   ├── Filters/
│   │   └── AuthFilter.php   # Filter Keamanan Sesi Login
│   ├── Models/
│   │   ├── ArchiveModel.php
│   │   ├── CategoryModel.php
│   │   └── UserModel.php
│   └── Views/
│       ├── archives/        # Tampilan daftar, create, & edit arsip
│       ├── auth/            # Tampilan halaman login
│       ├── categories/      # Tampilan daftar kategori & modal
│       ├── dashboard/       # Tampilan ringkasan statistik
│       └── layout/          # Template master (Sidebar, Navbar, Footer)
├── public/
│   ├── uploads/
│   │   └── archives/        # Direktori penyimpanan berkas dokumen fisik
│   └── index.php            # Entry point aplikasi
├── database.sql             # Skrip SQL database & data awal pengujian
├── .env                     # File konfigurasi lokal
└── README.md                # Dokumentasi & panduan instalasi
```
