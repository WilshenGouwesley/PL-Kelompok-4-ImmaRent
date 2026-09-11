<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $baseQuery = Booking::with('facility')
            ->where('user_id', $userId);

        // ================= BOOKING DATA =================
        $bookings = (clone $baseQuery)
            ->when(
                $request->filled('date'),
                fn ($q) => $q->whereDate(
                    'booking_date',
                    $request->input('date')
                )
            )
            ->when(
                $request->filled('category'),
                fn ($q) => $q->whereHas(
                    'facility',
                    fn ($f) => $f->where(
                        'category',
                        $request->input('category')
                    )
                )
            )
            ->when(
                $request->filled('status'),
                fn ($q) => $q->where(
                    'status',
                    $request->input('status')
                )
            )
            ->when(
                $request->filled('search'),
                fn ($q) => $q->whereHas(
                    'facility',
                    fn ($f) => $f->where(
                        'name',
                        'like',
                        '%' . $request->input('search') . '%'
                    )
                )
            )
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();


        // ================= SUMMARY =================
        $counts = [
            'all' => (clone $baseQuery)->count(),
            'approved' => (clone $baseQuery)
                ->where('status', 'approved')
                ->count(),
            'rejected' => (clone $baseQuery)
                ->where('status', 'rejected')
                ->count(),
            'cancelled' => (clone $baseQuery)
                ->where('status', 'cancelled')
                ->count(),
        ];


        // ================= HISTORY ARRAY =================
        $historyCards = [
            [
                'facility_name' => 'Tiranus Hall 6',
                'date' => '20 August 2026',
                'start_time' => '14:00',
                'end_time' => '16:30',
                'floor' => '5th Floor',
                'purpose' => 'Worship rehearsal',
                'status' => 'approved',
                'status_text' => 'Approved',
                'status_description' => 'Approved on 19 August 2026',
            ],

            [
                'facility_name' => 'Tiranus Hall 6',
                'date' => '18 August 2026',
                'start_time' => '10:00',
                'end_time' => '12:00',
                'floor' => '5th Floor',
                'purpose' => 'Student meeting',
                'status' => 'rejected',
                'status_text' => 'Rejected',
                'status_description' => 'Rejected on 17 August 2026',
            ],

            [
                'facility_name' => 'Tiranus Hall 6',
                'date' => '15 August 2026',
                'start_time' => '13:00',
                'end_time' => '15:00',
                'floor' => '5th Floor',
                'purpose' => 'Worship rehearsal',
                'status' => 'cancelled',
                'status_text' => 'Cancelled',
                'status_description' => 'Cancelled on 15 August 2026',
            ],
        ];


        return view('history.index', [
            'bookings' => $bookings,
            'counts' => $counts,
            'historyCards' => $historyCards,
        ]);
    }
}