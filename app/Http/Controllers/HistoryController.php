<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $baseQuery = Booking::with('facility')->where('user_id', $userId);

        $bookings = (clone $baseQuery)
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
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        $counts = [
            'all' => (clone $baseQuery)->count(),
            'approved' => (clone $baseQuery)->where('status', 'approved')->count(),
            'rejected' => (clone $baseQuery)->where('status', 'rejected')->count(),
            'cancelled' => (clone $baseQuery)->where('status', 'cancelled')->count(),
        ];

        return view('history.index', [
            'bookings' => $bookings,
            'counts' => $counts,
        ]);
    }
}
