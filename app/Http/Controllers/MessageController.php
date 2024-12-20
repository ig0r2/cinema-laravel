<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Log;

class MessageController extends Controller
{
    /**
     * Show all messages from the user.
     */
    public function index(): View
    {
        $messages = Message::where('user_id', Auth::id())
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new message.
     */
    public function create(): View
    {
        return view('messages.create');
    }

    /**
     * Store a new message in the database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'subject' => 'required|string',
            'content' => 'required|string',
        ]);

        Message::create([
            'user_id' => Auth::id(),
            'subject' => $request->input('subject'),
            'content' => $request->input('content'),
        ]);

        Log::channel('users')->info(
            'Korisnik ' . auth()->user()->name . ' je poslao novu poruku (naslov: ' . $request->input('subject') . ')'
        );

        return redirect()->route('messages.index');
    }

    /**
     * Show the specified message.
     */
    public function show(Message $message): View
    {
        $message->load('user');
        return view('messages.show', compact('message'));
    }
}
