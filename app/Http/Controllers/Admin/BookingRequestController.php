<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Http\Request;

class BookingRequestController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with(['facility', 'user'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')))
            ->latest()
            ->paginate(5);

        return view('admin.bookings.index', [
            'bookings' => $bookings,
        ]);
    }

    // Tombol centang hijau pada wireframe: menyetujui permintaan booking.
    public function approve(Request $request, Booking $booking)
    {
        $booking->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $request->user()->id,
        ]);

        Notification::create([
            'user_id' => $booking->user_id,
            'booking_id' => $booking->id,
            'title' => $booking->facility->name,
            'message' => 'Permintaan booking Anda telah disetujui.',
            'type' => 'approved',
        ]);

        return back()->with('status', 'Booking disetujui.');
    }

    // Tombol silang merah pada wireframe: menolak permintaan booking.
    public function reject(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:255'],
        ]);

        $booking->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'rejection_reason' => $validated['rejection_reason'] ?? null,
        ]);

        Notification::create([
            'user_id' => $booking->user_id,
            'booking_id' => $booking->id,
            'title' => $booking->facility->name,
            'message' => 'Permintaan booking Anda ditolak.',
            'type' => 'rejected',
        ]);

        return back()->with('status', 'Booking ditolak.');
    }
}
