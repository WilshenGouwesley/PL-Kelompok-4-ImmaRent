<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'gender',
        'class',
        'phone_number',
        'date_of_birth',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'date_of_birth' => 'date',
            'password' => 'hashed',
        ];
    }

    protected static function booted(): void
    {
        // Hapus file foto dari storage saat akun dihapus, supaya tidak ada file yatim.
        static::deleting(function (User $user) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
        });
    }

    // ================= RELATIONSHIPS =================

    /** Booking yang DIAJUKAN user ini. */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /** Booking yang DISETUJUI user ini (khusus admin, lewat kolom approved_by). */
    public function approvedBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'approved_by');
    }

    /**
     * Notifikasi booking milik user.
     * Sengaja tidak dinamai notifications(): nama itu sudah dipakai trait Notifiable
     * untuk sistem notifikasi bawaan Laravel (tabel/kolom berbeda).
     */
    public function bookingNotifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    // ================= SCOPES =================

    public function scopeStudents(Builder $query): Builder
    {
        return $query->where('role', 'student');
    }

    /** Cari berdasarkan nama atau email. */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $query->when($term, fn (Builder $q) => $q->where(
            fn (Builder $w) => $w->where('name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
        ));
    }

    // ================= HELPERS =================

    /**
     * URL foto profil ($user->avatar_url), atau null kalau belum punya foto.
     * Butuh `php artisan storage:link` supaya folder storage bisa diakses dari browser.
     */
    protected function avatarUrl(): Attribute
    {
        return Attribute::get(fn () => $this->avatar ? asset('storage/'.$this->avatar) : null);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function hasUnreadBookingNotifications(): bool
    {
        return $this->bookingNotifications()->unread()->exists();
    }
}
