<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Facility;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        // ================= BOOKING DATA (dengan filter) =================
        $bookings = Booking::with('facility')
            ->ownedBy($userId)
            ->filter($request->only(['date', 'category', 'status', 'search']))
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        // ================= SUMMARY (satu query, dikelompokkan per status) =================
        $byStatus = Booking::ownedBy($userId)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $counts = [
            'all' => (int) $byStatus->sum(),
            'approved' => (int) ($byStatus['approved'] ?? 0),
            'rejected' => (int) ($byStatus['rejected'] ?? 0),
            'cancelled' => (int) ($byStatus['cancelled'] ?? 0),
        ];

        return view('history.index', [
            'bookings' => $bookings,
            'counts' => $counts,
            'historyCards' => $bookings->getCollection()->map(fn (Booking $booking) => $booking->toCard()),
            'categories' => Facility::categoryList(),
        ]);
    }
}
