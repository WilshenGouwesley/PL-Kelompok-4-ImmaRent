<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'booking_id',
        'title',
        'message',
        'type',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    // ================= RELATIONSHIPS =================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    // ================= SCOPES =================

    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('read_at');
    }

    // ================= HELPERS =================

    /**
     * Buat notifikasi untuk pemilik sebuah booking.
     * Dipakai di tempat yang sama bentuknya: approve, reject, dan cancel.
     */
    public static function forBooking(Booking $booking, string $type, string $message): self
    {
        return static::create([
            'user_id' => $booking->user_id,
            'booking_id' => $booking->id,
            'title' => $booking->facility->name,
            'message' => $message,
            'type' => $type,
        ]);
    }
}
