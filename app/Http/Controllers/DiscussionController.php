<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function index()
    {
        $categories = [
            'booking_drone' => [
                'title' => 'Booking Jasa Drone',
                'desc' => 'Diskusikan pemesanan jasa drone udara, dokumentasi event, pemetaan, dll.',
                'icon' => 'fa-calendar-check-o',
            ],
            'booking_crews' => [
                'title' => 'Photographer & Videographer',
                'desc' => 'Konsultasikan jasa photographer & videographer darat untuk berbagai kebutuhan.',
                'icon' => 'fa-camera',
            ],
            'servis_drone' => [
                'title' => 'Servis Unit Drone',
                'desc' => 'Tanyakan tentang progres perbaikan, estimasi biaya, kerusakan unit drone Anda.',
                'icon' => 'fa-wrench',
            ],
            'order_drone' => [
                'title' => 'Order Unit Drone',
                'desc' => 'Diskusikan pemesanan unit drone baru, ketersediaan stok, dan pengiriman.',
                'icon' => 'fa-shopping-cart',
            ],
        ];

        $discussions = Discussion::where('user_id', auth()->id())
            ->with(['messages' => function($q) {
                $q->orderBy('created_at', 'desc');
            }])
            ->get()
            ->keyBy('service_type');

        $data = [];
        foreach ($categories as $type => $info) {
            $disc = $discussions->get($type);
            $unread = 0;
            $lastMsg = null;
            
            if ($disc) {
                $unread = $disc->messages
                    ->where('sender_id', '!=', auth()->id())
                    ->where('is_read', false)
                    ->count();
                $lastMsg = $disc->messages->first();
            }

            $data[$type] = array_merge($info, [
                'unread' => $unread,
                'last_message' => $lastMsg ? $lastMsg->message : null,
                'last_message_time' => $lastMsg ? $lastMsg->created_at->diffForHumans() : null,
            ]);
        }

        return view('discussion.list', compact('data'));
    }

    public function chat(string $service_type)
    {
        $validTypes = ['booking_drone', 'booking_crews', 'servis_drone', 'order_drone'];
        if (!in_array($service_type, $validTypes)) {
            abort(404);
        }

        $titles = [
            'booking_drone' => 'Booking Jasa Drone',
            'booking_crews' => 'Photographer & Videographer',
            'servis_drone' => 'Servis Unit Drone',
            'order_drone' => 'Order Unit Drone',
        ];

        $discussion = Discussion::firstOrCreate(
            ['user_id' => auth()->id(), 'service_type' => $service_type],
            ['title' => $titles[$service_type]]
        );

        $discussion->messages()
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $discussion->load('messages.sender');

        return view('discussion.index', compact('discussion', 'service_type'));
    }

    public function sendMessage(Request $request, string $service_type)
    {
        $validTypes = ['booking_drone', 'booking_crews', 'servis_drone', 'order_drone'];
        if (!in_array($service_type, $validTypes)) {
            abort(404);
        }

        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $titles = [
            'booking_drone' => 'Booking Jasa Drone',
            'booking_crews' => 'Photographer & Videographer',
            'servis_drone' => 'Servis Unit Drone',
            'order_drone' => 'Order Unit Drone',
        ];

        $discussion = Discussion::firstOrCreate(
            ['user_id' => auth()->id(), 'service_type' => $service_type],
            ['title' => $titles[$service_type]]
        );

        $discussion->touch();

        $discussion->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return redirect()->route('diskusi.chat', $service_type)->with('success', 'Pesan terkirim.');
    }

    public function getUnreadCount()
    {
        $count = \App\Models\DiscussionMessage::whereHas('discussion', function ($q) {
            $q->where('user_id', auth()->id());
        })->where('sender_id', '!=', auth()->id())->where('is_read', false)->count();

        return response()->json(['count' => $count]);
    }

    public function getMessages(string $service_type)
    {
        $validTypes = ['booking_drone', 'booking_crews', 'servis_drone', 'order_drone'];
        if (!in_array($service_type, $validTypes)) {
            return response()->json(['error' => 'Invalid category'], 400);
        }

        $titles = [
            'booking_drone' => 'Booking Jasa Drone',
            'booking_crews' => 'Photographer & Videographer',
            'servis_drone' => 'Servis Unit Drone',
            'order_drone' => 'Order Unit Drone',
        ];

        $discussion = Discussion::firstOrCreate(
            ['user_id' => auth()->id(), 'service_type' => $service_type],
            ['title' => $titles[$service_type]]
        );

        $discussion->messages()
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = $discussion->messages()
            ->with('sender')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'sender_id' => $msg->sender_id,
                    'sender_name' => $msg->sender->name,
                    'message' => $msg->message,
                    'time' => $msg->created_at->format('H:i'),
                    'is_user' => $msg->sender_id === auth()->id(),
                ];
            });

        return response()->json(['messages' => $messages]);
    }

    public function getUnreadByCategory()
    {
        $discussions = Discussion::where('user_id', auth()->id())
            ->with(['messages' => function($q) {
                $q->where('sender_id', '!=', auth()->id())->where('is_read', false);
            }])
            ->get();

        $unread = [
            'booking_drone' => 0,
            'booking_crews' => 0,
            'servis_drone' => 0,
            'order_drone' => 0,
        ];

        foreach ($discussions as $disc) {
            $unread[$disc->service_type] = $disc->messages->count();
        }

        return response()->json($unread);
    }
}
