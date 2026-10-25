<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Data dasar: dibutuhkan di semua environment.
        $this->call([
            AdminUserSeeder::class,
            FacilitySeeder::class,
        ]);

        // Data contoh (siswa, booking, notifikasi): hanya untuk development & testing,
        // supaya tidak ikut terisi data palsu di server produksi.
        if (app()->environment('local', 'testing')) {
            $this->call([
                StudentSeeder::class,
                BookingSeeder::class,
                NotificationSeeder::class,
            ]);
        }
    }
}
