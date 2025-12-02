# 🧺 Loundry'sS — Smart Laundry Service & Machine Rental System

Sistem manajemen layanan laundry dan rental mesin cuci yang modern dan terintegrasi dengan pembayaran digital.

## 📋 Deskripsi

Loundry'sS adalah aplikasi web berbasis Laravel yang menyediakan platform untuk layanan laundry dan rental mesin cuci self-service. Aplikasi ini memungkinkan pengguna untuk memesan layanan laundry, menyewa mesin cuci, melacak pesanan, dan melakukan pembayaran secara online menggunakan Midtrans Payment Gateway.

Sistem ini dilengkapi dengan 3 role pengguna:
- **User**: Pelanggan yang dapat memesan layanan dan rental mesin
- **Branch Admin**: Admin cabang yang mengelola pesanan, mesin, dan paket layanan
- **Main Admin**: Super admin yang dapat melihat semua cabang dan analytics

## ✨ Fitur Utama

### Untuk Pelanggan (User)
- 🛒 **Pemesanan Layanan Laundry**: Order paket laundry dengan berbagai pilihan layanan
- 🧺 **Rental Mesin Cuci**: Sewa mesin cuci self-service per jam
- 💳 **Pembayaran Online**: Integrasi dengan Midtrans (VA, E-Wallet, QRIS, dll)
- 📍 **Pickup & Delivery**: Layanan antar jemput laundry
- 📊 **Tracking Pesanan**: Monitor status pesanan secara real-time
- 🎮 **Mini Game**: Game interaktif sambil menunggu laundry selesai
- ⭐ **Review & Rating**: Memberikan feedback untuk layanan
- 🧾 **Invoice Digital**: Download invoice untuk setiap transaksi
- 🎁 **Promo & Diskon**: Lihat promo yang tersedia

### Untuk Admin Cabang (Branch Admin)
- 📦 **Manajemen Pesanan**: Kelola dan update status pesanan
- 🏪 **Manajemen Paket Layanan**: Tambah, edit, hapus paket laundry
- 🔧 **Manajemen Mesin**: Monitor dan kelola ketersediaan mesin
- 📈 **Analytics & Reports**: Dashboard dengan grafik dan statistik
- 👥 **Manajemen Pelanggan**: Lihat data pelanggan cabang
- 💰 **Laporan Keuangan**: Tracking revenue dan transaksi

### Untuk Main Admin
- 🏢 **Multi-Branch Management**: Monitoring semua cabang
- 👨‍💼 **Manajemen Admin Cabang**: Kelola akun admin tiap cabang
- 📊 **Consolidated Analytics**: Dashboard gabungan dari semua cabang
- 📈 **Performance Metrics**: Perbandingan performa antar cabang

## 🛠️ Teknologi yang Digunakan

### Backend
- **Laravel 12** - PHP Framework
- **Livewire 3** - Full-stack framework untuk Laravel
- **SQLite** - Database (mudah dipindahkan ke MySQL/PostgreSQL)
- **Midtrans PHP SDK** - Payment gateway integration

### Frontend
- **Tailwind CSS 4** - Utility-first CSS framework
- **Alpine.js** (via Livewire) - JavaScript framework
- **Chart.js** - Library untuk visualisasi data
- **SweetAlert2** - Modal dan alert yang modern
- **Vite** - Asset bundler

### Development Tools
- **Composer** - PHP dependency manager
- **NPM** - Node package manager
- **Pest PHP** - Testing framework
- **Laravel Pint** - Code style fixer

## 📦 Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js & NPM (untuk build assets)
- SQLite (atau MySQL/PostgreSQL)

## 🚀 Cara Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/SamSimmons-pixel/project-managemen-pelayanan-loundry-salman-al-sundawi-250458302012.git
cd project-managemen-pelayanan-loundry-salman-al-sundawi-250458302012
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Setup Environment

```bash
# Copy file .env.example menjadi .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

File `.env` sudah dikonfigurasi untuk menggunakan SQLite secara default. Database akan dibuat otomatis saat migrasi.

Jika ingin menggunakan MySQL, ubah di `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Konfigurasi Midtrans (Opsional)

Untuk mengaktifkan pembayaran online, tambahkan kredensial Midtrans di `.env`:
```env
MIDTRANS_MERCHANT_ID=your_merchant_id
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_IS_PRODUCTION=false
```

Dapatkan kredensial dari [Midtrans Dashboard](https://dashboard.midtrans.com/)

### 6. Migrasi Database

```bash
# Buat database dan tabel
php artisan migrate

# (Opsional) Jalankan seeder untuk data dummy
php artisan db:seed
```

### 7. Build Assets

```bash
# Development build
npm run dev

# Production build
npm run build
```

## 🎯 Cara Menjalankan Project

### Development Mode

**Opsi 1: Jalankan manual (3 terminal terpisah)**

```bash
# Terminal 1 - Laravel server
php artisan serve

# Terminal 2 - Queue worker
php artisan queue:listen

# Terminal 3 - Vite dev server
npm run dev
```

**Opsi 2: Jalankan otomatis dengan composer (recommended)**

```bash
composer run dev
```

Aplikasi akan berjalan di: **http://localhost:8000**

### Production Deployment

```bash
# Build assets untuk production
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Setup web server (Nginx/Apache)
# Point document root ke /public
```

## 👥 Default Akun

Setelah menjalankan seeder, gunakan akun berikut untuk login:

### Main Admin
- Email: `admin@loundryss.com`
- Password: `password`

### Branch Admin  
- Email: `branch1@loundryss.com`
- Password: `password`

### User
- Email: `user@example.com`
- Password: `password`

> **⚠️ Penting**: Ubah password default setelah login pertama!

## 📁 Struktur Project

```
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Controllers
│   │   └── Middleware/      # Middleware
│   ├── Livewire/           # Livewire components
│   │   ├── Admin/          # Admin components
│   │   ├── Auth/           # Authentication
│   │   └── User/           # User components
│   └── Models/             # Eloquent models
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/            # Database seeders
├── resources/
│   ├── views/              # Blade templates
│   │   ├── livewire/       # Livewire views
│   │   ├── admin/          # Admin views
│   │   └── user/           # User views
│   └── css/                # Stylesheets
├── routes/
│   └── web.php             # Web routes
└── public/                 # Public assets
```

## 🧪 Testing

```bash
# Jalankan semua test
php artisan test

# Atau dengan Pest
./vendor/bin/pest
```

## 🐛 Troubleshooting

### Error: "No application encryption key has been specified"
```bash
php artisan key:generate
```

### Error: "SQLSTATE[HY000]: General error: 1 no such table"
```bash
php artisan migrate:fresh
```

### Assets tidak termuat
```bash
npm run build
php artisan optimize:clear
```

### Port 8000 sudah digunakan
```bash
php artisan serve --port=8001
```

## 📝 License

Project ini menggunakan [MIT License](LICENSE).

## 👨‍💻 Developer

**Salman Al Sundawi**  
NIM: 250458302012  
Program Studi: Teknik Informatika

---

<p align="center">Made with ❤️ for Final Project</p>
