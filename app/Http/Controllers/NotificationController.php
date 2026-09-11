<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
{
    // ================= NOTIFICATION DATA =================
    $notifications = [

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


    return view('notifications.index', [
        'notifications' => $notifications,
    ]);
}


    public function markAsRead(Request $request, Notification $notification)
    {
        abort_unless(
            $notification->user_id === $request->user()->id,
            403
        );

        $notification->update([
            'read_at' => now()
        ]);

        return back();
    }


    public function markAllAsRead(Request $request)
    {
        Notification::where('user_id', $request->user()->id)
            ->whereNull('read_at')
            ->update([
                'read_at' => now()
            ]);

        return back()->with(
            'status',
            'Semua notifikasi ditandai sudah dibaca.'
        );
    }
}