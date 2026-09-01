<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Facility;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with('facility')
            ->where('user_id', $request->user()->id)
            ->when($request->filled('date'), fn ($q) => $q->whereDate('booking_date', $request->input('date')))
            ->when($request->filled('category'), fn ($q) => $q->whereHas(
                'facility',
                fn ($f) => $f->where('category', $request->input('category'))
            ))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')))
            ->when($request->filled('search'), fn ($q) => $q->whereHas(
                'facility',
                fn ($f) => $f->where('name', 'like', '%' . $request->input('search') . '%')
            ))
            ->latest('booking_date')
            ->paginate(10)
            ->withQueryString();

        return view('bookings.index', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * Form booking, dibuka dari tombol "Book" pada kartu fasilitas.
     */
    public function create(Facility $facility)
    {
        return view('bookings.create', [
            'facility' => $facility,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'facility_id' => ['required', 'exists:facilities,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'purpose' => ['required', 'string', 'max:255'],
        ]);

        $overlaps = Booking::where('facility_id', $validated['facility_id'])
            ->whereDate('booking_date', $validated['booking_date'])
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']]);
            })
            ->exists();

        if ($overlaps) {
            return back()
                ->withInput()
                ->withErrors(['start_time' => 'Fasilitas ini sudah dibooking pada slot waktu tersebut.']);
        }

        $booking = Booking::create([
            ...$validated,
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

    /**
     * Sesuai wireframe: user bisa membatalkan booking berstatus
     * Pending maupun Approved (status berubah menjadi Cancelled).
     */
    public function cancel(Request $request, Booking $booking)
    {
        $this->authorizeOwner($request, $booking);

        if (! in_array($booking->status, ['pending', 'approved'], true)) {
            return back()->withErrors(['status' => 'Booking ini sudah tidak bisa dibatalkan.']);
        }

        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return back()->with('status', 'Booking dibatalkan.');
    }

    protected function authorizeOwner(Request $request, Booking $booking): void
    {
        abort_unless($booking->user_id === $request->user()->id, 403);
    }
}
