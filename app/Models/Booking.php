<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'facility_id',
        'booking_date',
        'start_time',
        'end_time',
        'purpose',
        'status',
        'approved_at',
        'approved_by',
        'rejected_at',
        'rejection_reason',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    // ================= RELATIONSHIPS =================

    /** Peminjam (siswa yang mengajukan). */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }

    /** Admin yang menyetujui (kolom approved_by). */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    // ================= SCOPES =================

    public function scopeOwnedBy(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Peminjaman aktif: sudah disetujui dan BELUM selesai (akan datang atau sedang berlangsung).
     * Memakai zona waktu aplikasi (Asia/Pontianak), karena jam booking adalah jam dinding lokal.
     */
    public function scopeActiveLoans(Builder $query): Builder
    {
        $today = now()->toDateString();
        $time = now()->format('H:i:s');

        return $query->where('status', 'approved')->where(function (Builder $q) use ($today, $time) {
            $q->whereDate('booking_date', '>', $today)
                ->orWhere(fn (Builder $t) => $t->whereDate('booking_date', $today)->where('end_time', '>', $time));
        });
    }

    /** Booking yang disetujui pada bulan berjalan (dihitung dari waktu persetujuan). */
    public function scopeApprovedThisMonth(Builder $query): Builder
    {
        return $query->where('status', 'approved')
            ->whereBetween('approved_at', [now()->startOfMonth(), now()->endOfMonth()]);
    }

    /**
     * Filter gabungan untuk halaman Bookings, History, dan Booking Requests (admin):
     * ['date' => Y-m-d, 'category' => ..., 'status' => ..., 'search' => nama fasilitas].
     * Kunci yang kosong/tidak ada diabaikan.
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['date'] ?? null, fn (Builder $q, string $date) => $q->whereDate('booking_date', $date))
            ->when($filters['status'] ?? null, fn (Builder $q, string $status) => $q->where('status', $status))
            ->when($filters['category'] ?? null, fn (Builder $q, string $category) => $q->whereHas(
                'facility',
                fn (Builder $f) => $f->where('category', $category)
            ))
            ->when($filters['search'] ?? null, fn (Builder $q, string $term) => $q->whereHas(
                'facility',
                fn (Builder $f) => $f->where('name', 'like', "%{$term}%")
            ));
    }

    /**
     * Booking aktif (pending/approved) yang bentrok dengan rentang waktu tertentu.
     * Bentrok jika: mulai_lama < selesai_baru DAN selesai_lama > mulai_baru
     * (slot yang hanya bersambung, mis. 08:00-10:00 lalu 10:00-12:00, tidak dianggap bentrok).
     */
    public function scopeOverlapping(Builder $query, int $facilityId, string $date, string $start, string $end): Builder
    {
        return $query
            ->where('facility_id', $facilityId)
            ->whereDate('booking_date', $date)
            ->whereIn('status', ['pending', 'approved'])
            ->where('start_time', '<', $end)
            ->where('end_time', '>', $start);
    }

    // ================= HELPERS =================

    /**
     * Bentuk array yang dipakai kartu booking di view Bookings & History.
     */
    public function toCard(): array
    {
        $note = match ($this->status) {
            'approved' => 'Approved on '.($this->approved_at?->format('d F Y') ?? '-'),
            'rejected' => 'Rejected on '.($this->rejected_at?->format('d F Y') ?? '-'),
            'cancelled' => 'Cancelled on '.($this->cancelled_at?->format('d F Y') ?? '-'),
            default => 'Waiting for approval',
        };

        return [
            'id' => $this->id,
            'facility_name' => $this->facility->name,
            'date' => $this->booking_date->format('d F Y'),
            'start_time' => Carbon::parse($this->start_time)->format('H:i'),
            'end_time' => Carbon::parse($this->end_time)->format('H:i'),
            'floor' => $this->facility->location,
            'purpose' => $this->purpose,
            'status' => $this->status,
            'status_text' => ucfirst($this->status),
            'status_description' => $note,
        ];
    }
}
