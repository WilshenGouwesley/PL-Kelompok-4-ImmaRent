<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Facility;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Admin dashboard: show booking requests, facilities, and users
    public function index(Request $request)
    {
        $bookingRequests = Booking::with(['facility', 'user'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')))
            ->latest()
            ->paginate(5, ['*'], 'bookings_page');

        $facilities = Facility::latest()->paginate(6, ['*'], 'facilities_page');

        $users = User::where('role', 'student')
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = $request->input('search');
                $query->where(fn ($q) => $q->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%"));
            })
            ->latest()
            ->paginate(7, ['*'], 'users_page');

        return view('admin.dashboard', [
            'bookingRequests' => $bookingRequests,
            'facilities' => $facilities,
            'users' => $users,
        ]);
    }
}
