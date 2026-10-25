# ImmaRent

Sistem reservasi fasilitas sekolah untuk SMK Kristen Immanuel Pontianak. Siswa bisa mencari dan mengajukan booking fasilitas, admin mengelola fasilitas, permintaan booking, dan akun pengguna.

## Tech Stack

- Laravel 13 (PHP 8.3+)
- Blade + Tailwind CSS v4 + Vite
- MySQL

## Instalasi

```bash
git clone <url-repo-ini>
cd PL-Kelompok-4-ImmaRent

composer install
npm install

cp .env.example .env
php artisan key:generate

# atur DB_DATABASE, DB_USERNAME, DB_PASSWORD di .env

php artisan migrate --seed
php artisan storage:link

npm run dev        # atau: npm run build

php artisan serve
```

Buka `http://127.0.0.1:8000`.

## Akun Admin Default

| Email | Password |
|---|---|
| `admin@ski.sch.id` | `admin1234` |

> Ganti password ini sebelum deploy. Akun siswa daftar sendiri lewat halaman Register.

## Reset Database

```bash
php artisan migrate:fresh --seed
```

## Fitur Utama

- **Siswa**: Home, Facilities (cari & booking), Bookings, History, Notifications, Profile
- **Admin**: Personal Information, Booking Requests (approve/reject), Facilities (CRUD), Users
