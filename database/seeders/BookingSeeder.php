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
    private const DEMO_PLAN = ['pending', 'approved', 'approved', 'rejected', 'cancelled', 'pending', 'approved', 'cancelled'];

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
                ? self::DEMO_PLAN[$created]
                : fake()->randomElement(['pending', 'approved', 'approved', 'approved', 'rejected', 'cancelled']);

            $factory = Booking::factory()
                ->for($isDemo ? $demo : $students->random(), 'user')
                ->for($facilities->random(), 'facility');

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
