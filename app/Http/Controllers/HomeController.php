<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Facility;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Home (before login): menampilkan daftar fasilitas yang tersedia
    public function index(Request $request)
    {
        if ($request->user()) {
            return redirect()->route('dashboard');
        }

        $featuredFacilities = [
            [
                'name' => 'Computer Laboratory',
                'location' => 'IELTS Centre',
                'image' => 'image/transparan.png',
            ],
            [
                'name' => 'Basketball Court',
                'location' => 'Sports Building',
                'image' => 'image/transparan.png',
            ],
            [
                'name' => 'Auditorium',
                'location' => 'Main Building',
                'image' => 'image/transparan.png',
            ],
            [
                'name' => 'Science Laboratory',
                'location' => 'Laboratory Building',
                'image' => 'image/transparan.png',
            ],
            [
                'name' => 'Meeting Room',
                'location' => 'Administration Building',
                'image' => 'image/transparan.png',
            ],
            [
                'name' => 'Music Room',
                'location' => 'Arts Building',
                'image' => 'image/transparan.png',
            ],
        ];

        return view('home.guest', [
            'featuredFacilities' => $featuredFacilities,
        ]);
    }

    // Home (after login) / Dashboard: menampilkan ringkasan status peminjaman user
    public function dashboard(Request $request)
    {
        $user = $request->user();

        $activeLoans = Booking::where('user_id', $user->id)
            ->where('status', 'approved')
            ->whereDate('booking_date', '>=', now()->toDateString())
            ->count();

        $approvedThisMonth = Booking::where('user_id', $user->id)
            ->where('status', 'approved')
            ->whereMonth('approved_at', now()->month)
            ->whereYear('approved_at', now()->year)
            ->count();

        $awaitingConfirmation = Booking::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $latestLoans = Booking::with('facility')
            ->where('user_id', $user->id)
            ->latest('booking_date')
            ->take(3)
            ->get();

        $featuredFacilities = Facility::where('status', 'active')
            ->latest()
            ->take(3)
            ->get();

        return view('home.dashboard', [
            'activeLoans' => $activeLoans,
            'approvedThisMonth' => $approvedThisMonth,
            'awaitingConfirmation' => $awaitingConfirmation,
            'latestLoans' => $latestLoans,
            'featuredFacilities' => $featuredFacilities,
        ]);
    }
}
