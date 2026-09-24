<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

<h1 align="center">🏟️ Booking Ratu Jaya</h1>

<p align="center">
  Sistem pemesanan lapangan olahraga berbasis web untuk GOR / Lapangan Ratu Jaya.
  <br>
  Dibangun dengan <strong>Laravel 12</strong>, <strong>Filament v3</strong>, dan <strong>Livewire v3</strong>.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-red?logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue?logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Filament-3.x-orange" alt="Filament 3">
  <img src="https://img.shields.io/badge/Livewire-3.x-pink" alt="Livewire 3">
  <img src="https://img.shields.io/badge/License-MIT-green" alt="MIT License">
</p>

---

## 📋 Tentang Proyek

**Booking Ratu Jaya** adalah aplikasi web untuk mempermudah proses pemesanan lapangan olahraga secara online. Sistem ini memiliki dua sisi utama:

- **Halaman Publik** — Pelanggan dapat melihat daftar lapangan yang tersedia, memilih tanggal & jam, dan mengisi formulir pemesanan.
- **Admin Panel (Filament)** — Admin dapat mengelola lapangan, mengonfirmasi/menolak booking, dan mengatur pengaturan umum aplikasi.

---

## ✨ Fitur Utama

| Fitur | Keterangan |
|---|---|
| 🏟️ **Manajemen Lapangan** | Tambah, edit, hapus lapangan beserta foto, harga, kategori, dan status |
| 📅 **Sistem Booking Online** | Pelanggan dapat memesan lapangan secara realtime via Livewire |
| ⏰ **Cek Ketersediaan** | Otomatis cek slot jam yang sudah dipesan agar tidak terjadi double booking |
| 📊 **Admin Dashboard** | Panel admin berbasis Filament dengan tabel, filter, dan statistik |
| ⚙️ **Pengaturan Aplikasi** | Kelola nama toko, nomor WhatsApp, dan info lainnya dari panel admin |
| 🔐 **Autentikasi Admin** | Login khusus admin untuk mengakses dashboard |

---

## 🛠️ Tech Stack

- **Backend** — [Laravel 12](https://laravel.com/)
- **Admin Panel** — [Filament v3](https://filamentphp.com/)
- **Frontend Reaktif** — [Livewire v3](https://livewire.laravel.com/)
- **Database** — SQLite (default) / MySQL
- **Build Tool** — [Vite](https://vitejs.dev/)
- **PHP** — 8.2+

---

## 🚀 Instalasi & Setup

### Prasyarat

Pastikan sudah terinstal:
- PHP >= 8.2
- Composer
- Node.js & NPM
- Git

### Langkah Instalasi

**1. Clone repositori**
```bash
git clone https://github.com/username/booking_ratujaya.git
cd booking_ratujaya
```

**2. Install dependensi PHP**
```bash
composer install
```

**3. Install dependensi Node.js**
```bash
npm install
```

**4. Salin file environment**
```bash
cp .env.example .env
```

**5. Generate application key**
```bash
php artisan key:generate
```

**6. Konfigurasi database**

Untuk SQLite (default, tidak perlu konfigurasi tambahan):
```bash
touch database/database.sqlite
```

Untuk MySQL, edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=booking_ratujaya
DB_USERNAME=root
DB_PASSWORD=your_password
```

**7. Jalankan migrasi dan seeder**
```bash
php artisan migrate --seed
```

**8. Buat storage symlink**
```bash
php artisan storage:link
```

**9. Jalankan development server**
```bash
composer run dev
# Atau jalankan secara terpisah:
# php artisan serve
# npm run dev
```

Akses aplikasi di: **http://localhost:8000**

---


## 🔑 Membuat Akun Admin

Karena seeder tidak otomatis membuat akun admin, jalankan perintah berikut setelah migrasi:

```bash
php artisan make:filament-user
```

Ikuti prompt yang muncul untuk mengisi **Nama**, **Email**, dan **Password**.

Setelah itu, akses admin panel di:

| Field | Value |
|---|---|
| URL | `http://localhost:8000/admin` |

> ⚠️ **Penting:** Gunakan password yang kuat di lingkungan produksi!

---

## 📁 Struktur Proyek

```
booking_ratujaya/
├── app/
│   ├── Filament/
│   │   ├── Resources/          # Resource Admin Panel (Booking, Lapangan, Setting)
│   │   └── Widgets/            # Widget dashboard
│   ├── Http/
│   │   └── Controllers/        # Controller (HomeController, dll.)
│   ├── Livewire/
│   │   └── BookingForm.php     # Komponen form booking realtime
│   └── Models/
│       ├── Booking.php         # Model pemesanan
│       ├── Lapangan.php        # Model lapangan olahraga
│       ├── Setting.php         # Model pengaturan aplikasi
│       └── User.php            # Model pengguna / admin
├── database/
│   ├── migrations/             # Skema database
│   └── seeders/                # Data awal (admin, setting, dll.)
├── resources/
│   ├── views/
│   │   ├── home.blade.php      # Halaman utama (daftar lapangan)
│   │   ├── detail.blade.php    # Detail lapangan
│   │   ├── livewire/           # View komponen Livewire
│   │   └── layouts/            # Layout utama
│   ├── css/                    # File CSS
│   └── js/                     # File JavaScript
├── routes/
│   └── web.php                 # Definisi rute web
├── .env.example                # Contoh konfigurasi environment
└── vite.config.js              # Konfigurasi Vite
```

---

## 🧪 Testing

```bash
composer run test
# Atau
php artisan test
```

---

## 🤝 Kontribusi

Kontribusi sangat disambut! Silakan:

1. Fork repositori ini
2. Buat branch fitur baru (`git checkout -b feature/nama-fitur`)
3. Commit perubahan (`git commit -m 'feat: tambah fitur X'`)
4. Push ke branch (`git push origin feature/nama-fitur`)
5. Buka Pull Request

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

<p align="center">
  Dibuat dengan ❤️ menggunakan <a href="https://laravel.com">Laravel</a>
</p>
