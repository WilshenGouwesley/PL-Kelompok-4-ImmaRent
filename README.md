# ImmaRent

Aplikasi peminjaman fasilitas sekolah untuk SMK Kristen Immanuel Pontianak. Siswa memilih fasilitas, tanggal, dan jam, lalu admin menyetujui atau menolak.

Dibuat dengan Laravel 13, Tailwind CSS 4, dan MySQL.

## Yang perlu disiapkan

**PHP 8.4+**, **Composer**, **Node.js**, dan **MySQL**. Paling mudah dengan [Laragon](https://laragon.org/), karena semuanya sudah termasuk.

## Cara menjalankan

```bash
git clone https://github.com/WilshenGouwesley/PL-Kelompok-4-ImmaRent.git
cd PL-Kelompok-4-ImmaRent

composer install
npm install

cp .env.example .env          
php artisan key:generate
```

Buat database kosong bernama `immarent`, lalu di file `.env` ubah bagian database:

```dotenv
DB_CONNECTION=mysql
DB_DATABASE=immarent
DB_USERNAME=root
DB_PASSWORD=
```

Lanjutkan:

```bash
php artisan migrate --seed
php artisan storage:link

composer run dev                   
php artisan serve             
```

Buka http://127.0.0.1:8000

## Akun untuk mencoba

| Peran | Email | Password |
|---|---|---|
| Admin | `admin@ski.sch.id` | `admin1234` |
| Siswa | `wilshen@ski.sch.id` | `12345678` |


## Pengaturan

Daftar kelas dan jam buka (bawaan 07:00 sampai 17:00) ada di `config/school.php`. Daftar kelasnya hanya contoh, sesuaikan dengan nama kelas sebenarnya.

## Kalau ada masalah

| Yang terjadi | Solusi |
|---|---|
| Halaman putih atau error | Baca baris terbawah `storage/logs/laravel.log` |
| `Unknown column` atau `table doesn't exist` | `php artisan migrate` |
| Foto tidak muncul | `php artisan storage:link` |
| Tampilan tidak berubah setelah `git pull` | Jalankan ulang `npm run dev`, lalu Ctrl + F5 |
| Ingin mengulang dari awal | `php artisan migrate:fresh --seed` (**semua data terhapus**) |


Proyek Kelompok 4, dibuat untuk mata pelajaran Pemrograman Lanjutan SMK Kristen Immanuel Pontianak.