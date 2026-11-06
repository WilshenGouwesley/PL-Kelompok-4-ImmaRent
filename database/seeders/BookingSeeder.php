<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    private const TOTAL = 40;

    /** Akun demo selalu mendapat satu contoh dari tiap status, supaya semua badge terlihat. */
    /**
     * [status, selisih hari dari hari ini]. Tanggalnya sengaja pasti, supaya kartu di Home
     * akun demo selalu berisi: 2 peminjaman aktif, 2 menunggu persetujuan, dst.
     */
    private const DEMO_PLAN = [
        ['pending', 2],
        ['approved', 3],
        ['approved', 8],
        ['rejected', -4],
        ['cancelled', 5],
        ['pending', 12],
        ['approved', -6],
        ['cancelled', -10],
    ];

    public function run(): void
    {
        if (Booking::exists()) {
            return; // jangan menggandakan data contoh
        }

        $students = User::students()->get();
        $facilities = Facility::active()->get();
        $adminId = User::where('role', 'admin')->value('id');

        if ($students->isEmpty() || $facilities->isEmpty()) {
            return;
        }

        $demo = $students->firstWhere('email', 'siswa@ski.sch.id') ?? $students->first();

        $created = 0;
        $attempts = 0;

        while ($created < self::TOTAL && $attempts < self::TOTAL * 10) {
            $attempts++;

            $isDemo = $created < count(self::DEMO_PLAN);
            $status = $isDemo
                ? self::DEMO_PLAN[$created][0]
                : fake()->randomElement(['pending', 'approved', 'approved', 'approved', 'rejected', 'cancelled']);

            $factory = Booking::factory()
                ->for($isDemo ? $demo : $students->random(), 'user')
                ->for($facilities->random(), 'facility');

            if ($isDemo) {
                $factory = $factory->onDate(now()->addDays(self::DEMO_PLAN[$created][1]));
            }

            $booking = match ($status) {
                'approved' => $factory->approved($adminId)->make(),
                'rejected' => $factory->rejected()->make(),
                'cancelled' => $factory->cancelled()->make(),
                default => $factory->pending()->make(),
            };

            // Hanya booking aktif (pending/approved) yang tidak boleh bentrok jadwalnya.
            $isActive = in_array($status, ['pending', 'approved'], true);

            if ($isActive && Booking::overlapping(
                $booking->facility_id,
                $booking->booking_date->toDateString(),
                $booking->start_time,
                $booking->end_time,
            )->exists()) {
                continue;
            }

            $booking->save();
            $created++;
        }
    }
}
