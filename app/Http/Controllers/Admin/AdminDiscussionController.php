<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discussion;
use Illuminate\Http\Request;

class AdminDiscussionController extends Controller
{
    public function index()
    {
        $discussions = Discussion::with('user', 'messages')
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('admin.discussion.index', compact('discussions'));
    }

    public function show(Discussion $discussion)
    {
        // Mark messages from others (client) as read
        $discussion->messages()
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $discussion->load('user', 'messages.sender');

        return view('admin.discussion.show', compact('discussion'));
    }

    public function sendMessage(Request $request, Discussion $discussion)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $discussion->touch();

        $discussion->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return redirect()->route('admin.diskusi.show', $discussion)->with('success', 'Balasan berhasil dikirim.');
    }

    public function getUnreadCount()
    {
        $count = \App\Models\DiscussionMessage::where('sender_id', '!=', auth()->id())->where('is_read', false)->count();

        return response()->json(['count' => $count]);
    }

    public function getMessages(Discussion $discussion)
    {
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
                    'time' => $msg->created_at->format('d M H:i'),
                    'is_admin' => $msg->sender_id === auth()->id(),
                ];
            });

        return response()->json(['messages' => $messages]);
    }

    public function getListStatus()
    {
        $discussions = Discussion::with(['messages' => function($q) {
            $q->orderBy('created_at', 'desc');
        }])->get();

        $data = $discussions->map(function ($d) {
            $unreadCount = $d->messages
                ->where('sender_id', '!=', auth()->id())
                ->where('is_read', false)
                ->count();
            
            $lastMsg = $d->messages->first();

            return [
                'id' => $d->id,
                'unread_count' => $unreadCount,
                'last_message' => $lastMsg ? $lastMsg->message : '(Belum ada pesan)',
                'updated_at' => $d->updated_at->diffForHumans(),
            ];
        });

        return response()->json($data);
    }
}
