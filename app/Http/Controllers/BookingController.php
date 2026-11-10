<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Facility;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
        // Jadwal yang sudah terisi (pending/approved) mulai hari ini, per tanggal, untuk kalender di form.
        $busy = $facility->bookings()
            ->whereIn('status', ['pending', 'approved'])
            ->whereDate('booking_date', '>=', now()->toDateString())
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->get(['booking_date', 'start_time', 'end_time'])
            ->groupBy(fn (Booking $booking) => $booking->booking_date->toDateString())
            ->map(fn ($group) => $group
                ->map(fn (Booking $booking) => [substr($booking->start_time, 0, 5), substr($booking->end_time, 0, 5)])
                ->values()
                ->all())
            ->all();

        $slots = $this->timeSlots();

        return view('bookings.create', [
            'facility' => $facility,
            'busy' => $busy,
            'classes' => config('school.classes'),
            'startSlots' => array_slice($slots, 0, -1),
            'endSlots' => array_slice($slots, 1),
            // tanggal & jam "sekarang" menurut server, supaya kalender tidak bergantung jam perangkat pengguna
            'today' => now()->toDateString(),
            'nowTime' => now()->format('H:i'),
        ]);
    }

    /** Pilihan jam untuk dropdown, mis. 07:00, 07:30, ... 17:00 (nilai 24 jam, label 12 jam). */
    protected function timeSlots(): array
    {
        $hours = config('school.booking_hours');
        $close = Carbon::createFromFormat('!H:i', $hours['close']);
        $slots = [];

        for ($time = Carbon::createFromFormat('!H:i', $hours['open']); $time->lte($close); $time->addMinutes($hours['step'])) {
            $slots[] = ['value' => $time->format('H:i'), 'label' => $time->format('h:i A')];
        }

        return $slots;
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
