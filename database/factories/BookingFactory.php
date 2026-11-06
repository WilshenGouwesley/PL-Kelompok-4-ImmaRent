<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    private const PURPOSES = [
        'Worship rehearsal', 'Student meeting', 'Competition coaching', 'Group study',
        'Extra class', 'Practical exam', 'Club activity',
    ];

    public function definition(): array
    {
        $date = Carbon::instance(fake()->dateTimeBetween('-30 days', '+30 days'));

        $start = fake()->numberBetween(7, 15);
        $end = min($start + fake()->numberBetween(1, 3), 17);

        return [
            'user_id' => User::factory(),
            'facility_id' => Facility::factory(),
            'booking_date' => $date->toDateString(),
            'start_time' => sprintf('%02d:00', $start),
            'end_time' => sprintf('%02d:00', $end),
            'purpose' => fake()->randomElement(self::PURPOSES),
            'status' => 'pending',
            ...$this->timestampsFor($date),
        ];
    }

    /**
     * Pindahkan booking ke tanggal tertentu. Waktu pengajuannya ikut disesuaikan
     * (pakai SEBELUM approved()/rejected()/cancelled(), supaya urutan waktunya masuk akal).
     */
    public function onDate(Carbon|string $date): static
    {
        $date = Carbon::parse($date);

        return $this->state(fn () => ['booking_date' => $date->toDateString()] + $this->timestampsFor($date));
    }

    /** Booking diajukan 1-7 hari sebelum tanggal pakai, tapi tidak boleh di masa depan. */
    private function timestampsFor(Carbon $date): array
    {
        $createdAt = $date->copy()->subDays(fake()->numberBetween(1, 7));

        if ($createdAt->greaterThan(now())) {
            $createdAt = now()->subMinutes(fake()->numberBetween(5, 600));
        }

        return ['created_at' => $createdAt, 'updated_at' => $createdAt];
    }

    public function pending(): static
    {
        return $this->state(fn () => ['status' => 'pending']);
    }

    public function approved(?int $adminId = null): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
            'approved_at' => $this->reviewedAt($attributes, 48),
            'approved_by' => $adminId ?? User::factory()->admin(),
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'rejected_at' => $this->reviewedAt($attributes, 48),
            'rejection_reason' => fake()->randomElement([
                'The room is already reserved for a school event.',
                'Please choose another time slot.',
                'Not enough lead time for this request.',
            ]),
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'cancelled_at' => $this->reviewedAt($attributes, 72),
        ]);
    }

    /** Waktu diproses = beberapa jam setelah dibuat, dan tidak melewati "sekarang". */
    private function reviewedAt(array $attributes, int $maxHours): Carbon
    {
        $at = Carbon::parse($attributes['created_at'])->addHours(fake()->numberBetween(1, $maxHours));

        return $at->greaterThan(now()) ? now() : $at;
    }
}
