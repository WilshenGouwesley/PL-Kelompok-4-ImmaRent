<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RejectBookingRequest;
use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Http\Request;

class BookingRequestController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with(['facility', 'user'])
            ->filter($request->only('status'))
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.bookings.index', [
            'bookings' => $bookings,
        ]);
    }

    public function approve(Request $request, Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return $this->alreadyReviewed();
        }

        $booking->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $request->user()->id,
        ]);

        Notification::forBooking($booking, 'approved', 'Permintaan booking Anda telah disetujui.');

        return back()->with('status', 'Booking disetujui.');
    }

    public function reject(RejectBookingRequest $request, Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return $this->alreadyReviewed();
        }

        $booking->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'rejection_reason' => $request->validated('rejection_reason'),
        ]);

        Notification::forBooking($booking, 'rejected', 'Permintaan booking Anda ditolak.');

        return back()->with('status', 'Booking ditolak.');
    }

    /** Booking yang sudah diproses/dibatalkan tidak boleh disetujui atau ditolak lagi. */
    protected function alreadyReviewed()
    {
        return back()->withErrors([
            'status' => 'Only pending requests can be approved or rejected.',
        ]);
    }
}
