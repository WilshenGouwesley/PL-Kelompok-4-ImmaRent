<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Facility;
use App\Models\Notification;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with('facility')
            ->ownedBy($request->user()->id)
            ->filter($request->only(['date', 'category', 'status', 'search']))
            ->orderByDesc('booking_date')
            ->orderByDesc('start_time')
            ->paginate(10)
            ->withQueryString()
            ->through(fn (Booking $booking) => $booking->toCard());

        return view('bookings.index', [
            'bookings' => $bookings,
            'categories' => Facility::categoryList(),
        ]);
    }

    public function create(Facility $facility)
    {
        return view('bookings.create', [
            'facility' => $facility,
        ]);
    }

    public function store(StoreBookingRequest $request)
    {
        $booking = Booking::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('bookings.show', $booking)
            ->with('status', 'Booking berhasil diajukan dan menunggu persetujuan.');
    }

    public function show(Request $request, Booking $booking)
    {
        $this->authorizeOwner($request, $booking);

        return view('bookings.show', [
            'booking' => $booking->load('facility'),
        ]);
    }

    public function cancel(Request $request, Booking $booking)
    {
        $this->authorizeOwner($request, $booking);

        if (! in_array($booking->status, ['pending', 'approved'], true)) {
            return back()->withErrors([
                'status' => 'Booking ini sudah tidak bisa dibatalkan.',
            ]);
        }

        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        Notification::forBooking($booking, 'cancelled', 'You cancelled this booking.');

        return back()->with('status', 'Booking dibatalkan.');
    }

    protected function authorizeOwner(Request $request, Booking $booking): void
    {
        abort_unless($booking->user_id === $request->user()->id, 403);
    }
}
