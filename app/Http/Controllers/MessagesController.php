<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $conversations = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function($message) use ($user) {
                return $message->sender_id === $user->id ? $message->receiver_id : $message->sender_id;
            });

        return view('messages.index', compact('conversations'));
    }

    public function show($userId)
    {
        $otherUser = User::findOrFail($userId);
        $messages = Message::where(function($query) use ($userId) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $userId);
        })->orWhere(function($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        return view('messages.show', compact('messages', 'otherUser'));
    }

    public function compose()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('messages.compose', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);

        return redirect()->route('messages.show', $request->receiver_id)
            ->with('success', 'Message sent successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('user_type', 'parent')
            ->where(function($q) use ($query) {
                $q->where('email', 'like', "%{$query}%")
                  ->orWhere('name', 'like', "%{$query}%");
            })
            ->where('id', '!=', Auth::id())
            ->take(5)
            ->get(['id', 'name', 'email']);
        return response()->json($users);
    }
}