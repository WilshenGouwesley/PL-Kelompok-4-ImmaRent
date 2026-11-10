<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $limit = max(10, min((int) $request->input('limit', 10), 200));

        $rows = $user->bookingNotifications()
            ->with('booking.facility')
            ->latest()
            ->take($limit + 1)
            ->get();

        $hasMore = $rows->count() > $limit;
        $rows = $rows->take($limit);

        $notifications = $rows->map(function (Notification $notification) {
            $booking = $notification->booking;
            $facility = $booking?->facility;
            $type = $notification->type ?? 'pending';

            return [
                'id' => $notification->id,
                'facility_name' => $facility?->name ?? $notification->title,
                'image' => $facility?->image ? asset('storage/' . $facility->image) : asset('image/transparan.png'),
                'date' => $booking?->booking_date->format('d F Y') ?? '-',
                'start_time' => $booking ? Carbon::parse($booking->start_time)->format('H:i') : '-',
                'end_time' => $booking ? Carbon::parse($booking->end_time)->format('H:i') : '-',
                'floor' => $facility?->location ?? '-',
                'purpose' => $booking?->purpose ?? '-',
                'status' => $type,
                'status_text' => ucfirst($type),
                'status_description' => $notification->created_at->diffForHumans(),
                'unread' => is_null($notification->read_at),
            ];
        });

        // Tandai yang baru saja ditampilkan sebagai sudah dibaca
        // (flag 'unread' sudah dihitung di atas, jadi titik hijau di kartu masih muncul sekali).
        $user->bookingNotifications()
            ->unread()
            ->whereIn('id', $rows->pluck('id'))
            ->update(['read_at' => now()]);

        return view('notifications.index', [
            'notifications' => $notifications,
            'hasMore' => $hasMore,
            'nextLimit' => $limit + 10,
        ]);
    }

    public function markAsRead(Request $request, Notification $notification)
    {
        abort_unless($notification->user_id === $request->user()->id, 403);

        $notification->update(['read_at' => now()]);

        return back();
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()->bookingNotifications()->unread()->update(['read_at' => now()]);

        return back()->with('status', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
