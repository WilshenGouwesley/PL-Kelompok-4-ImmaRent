<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    private function getFeaturedFacilities()
    {
        return [
            [
                'name' => 'Computer Laboratory',
                'location' => 'IELTS Centre',
                'image' => 'image/computerlaboratory.png',
            ],
            [
                'name' => 'Basketball Court',
                'location' => 'Sports Building',
                'image' => 'image/basketballcourt.png',
            ],
            [
                'name' => 'Auditorium',
                'location' => 'Main Building',
                'image' => 'image/auditorium.png',
            ],
            [
                'name' => 'Science Laboratory',
                'location' => 'Laboratory Building',
                'image' => 'image/science_lab.png',
            ],
            [
                'name' => 'Meeting Room',
                'location' => 'Administration Building',
                'image' => 'image/meeting_room.png',
            ],
            [
                'name' => 'Music Room',
                'location' => 'Arts Building',
                'image' => 'image/music_studio.png',
            ],
        ];
    }


    // Home sebelum login
    public function index(Request $request)
    {
        if ($request->user()) {
            return redirect()->route('dashboard');
        }

        $featuredFacilities = $this->getFeaturedFacilities();

        return view('home.guest', [
            'featuredFacilities' => $featuredFacilities,
        ]);
    }


    // Home setelah login / Dashboard
    public function dashboard(Request $request)
    {
        $user = $request->user();

        // Tiga angka di kartu ringkasan Home. Definisinya ada di scope model Booking,
        // jadi angkanya selalu sama dengan yang tampil di halaman Bookings & History.
        $activeLoans = Booking::ownedBy($user->id)->activeLoans()->count();
        $approvedThisMonth = Booking::ownedBy($user->id)->approvedThisMonth()->count();
        $awaitingConfirmation = Booking::ownedBy($user->id)->pending()->count();

        $latestLoans = Booking::with('facility')
            ->where('user_id', $user->id)
            ->latest('booking_date')
            ->take(3)
            ->get();

        $featuredFacilities = $this->getFeaturedFacilities();

        return view('home.dashboard', [
            'activeLoans' => $activeLoans,
            'approvedThisMonth' => $approvedThisMonth,
            'awaitingConfirmation' => $awaitingConfirmation,
            'latestLoans' => $latestLoans,
            'featuredFacilities' => $featuredFacilities,
        ]);
    }
}