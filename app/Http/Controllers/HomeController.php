<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public static function index()
    {
        $user = User::with('tickets.screening.movie', 'tickets.screening.hall', 'reviews.movie', 'messages')
            ->where('id', auth()->user()->id)
            ->firstOrFail();
        $tickets = $user->tickets;
        $activeTickets = $tickets->where('screening.time', '>', now());
        $pastTickets = $tickets->where('screening.time', '<', now());
        $reviews = $user->reviews;
        $messages = $user->messages;

        return view('user.index', compact('user', 'tickets', 'activeTickets', 'pastTickets', 'reviews', 'messages'));
    }
}
