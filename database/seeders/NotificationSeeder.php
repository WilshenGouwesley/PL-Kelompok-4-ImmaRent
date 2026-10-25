<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        if (Notification::exists()) {
            return;
        }

        // Satu notifikasi untuk tiap booking yang sudah diproses (bukan yang masih pending).
        Booking::with('facility')
            ->where('status', '!=', 'pending')
            ->get()
            ->each(fn (Booking $booking) => Notification::factory()->forBooking($booking)->create());

        // Separuhnya dibuat "sudah dibaca"; sisanya dibiarkan belum dibaca
        // supaya titik hijau di lonceng terlihat saat demo.
        $all = Notification::all();

        $all->shuffle()
            ->take((int) floor($all->count() / 2))
            ->each(fn (Notification $notification) => $notification->update(['read_at' => now()]));
    }
}
