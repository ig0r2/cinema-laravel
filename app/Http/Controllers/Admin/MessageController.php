<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MessageController extends Controller
{
    /**
     * Show all messages
     */
    public function index(): View
    {
        $messages = Message::with('user')
            ->orderBy('reply', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Show the specified message.
     */
    public function show(Message $message): View
    {
        $message->load('user');
        return view('admin.messages.show', compact('message'));
    }

    /**
     * Reply to the specified message.
     */
    public function reply(Request $request, Message $message): RedirectResponse
    {
        if ($message->reply) {
            return redirect()->route('admin.messages.show', $message);
        }

        $request->validate([
            'reply' => 'required|string',
        ]);

        $message->update([
            'reply' => $request->input('reply'),
            'reply_by' => Auth::id(),
        ]);

        return redirect()->route('admin.messages.show', $message);
    }

    /**
     * Delete the specified message from the database.
     */
    public function destroy(Message $message): RedirectResponse
    {
        $message->delete();
        return redirect()->route('home');
    }
}
