<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Notification>
 */
class NotificationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'booking_id' => null,
            'title' => fake()->randomElement(['Computer Laboratory', 'Tiranus Hall 6', 'LCD Projector']),
            'message' => 'Permintaan booking Anda telah disetujui.',
            'type' => 'approved',
            'read_at' => null,
        ];
    }

    public function read(): static
    {
        return $this->state(fn () => ['read_at' => now()]);
    }

    /** Bangun notifikasi yang sesuai dengan status sebuah booking yang sudah ada. */
    public function forBooking(Booking $booking): static
    {
        $at = match ($booking->status) {
            'approved' => $booking->approved_at,
            'rejected' => $booking->rejected_at,
            'cancelled' => $booking->cancelled_at,
            default => $booking->created_at,
        } ?? now();

        $message = match ($booking->status) {
            'approved' => 'Permintaan booking Anda telah disetujui.',
            'rejected' => 'Permintaan booking Anda ditolak.',
            'cancelled' => 'You cancelled this booking.',
            default => 'Permintaan booking Anda sedang menunggu persetujuan.',
        };

        return $this->state(fn () => [
            'user_id' => $booking->user_id,
            'booking_id' => $booking->id,
            'title' => $booking->facility->name,
            'type' => $booking->status,
            'message' => $message,
            'created_at' => $at,
            'updated_at' => $at,
        ]);
    }
}
