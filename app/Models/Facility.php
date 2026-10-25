<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'location',
        'description',
        'capacity',
        'status',
        'image',
    ];

    // ================= RELATIONSHIPS =================

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // ================= SCOPES =================

    /** Hanya fasilitas yang masih bisa dibooking (bukan "retired"). */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /**
     * Filter gabungan: ['search' => nama, 'category' => ..., 'location' => ...].
     * Kunci yang kosong/tidak ada diabaikan, jadi aman dipanggil dengan $request->only([...]).
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, fn (Builder $q, string $term) => $q->where('name', 'like', "%{$term}%"))
            ->when($filters['category'] ?? null, fn (Builder $q, string $category) => $q->where('category', $category))
            ->when($filters['location'] ?? null, fn (Builder $q, string $location) => $q->where('location', $location));
    }

    // ================= HELPERS =================

    /** Daftar kategori unik, untuk dropdown filter. */
    public static function categoryList(): Collection
    {
        return static::query()->distinct()->orderBy('category')->pluck('category');
    }
}
