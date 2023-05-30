<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Show the users page.
     */
    public function index(): View
    {
        $users = User::with('tickets.screening.movie', 'tickets.screening.hall', 'reviews.movie')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the user
     */
    public function show(User $user): View
    {
        $user->load('tickets.screening.movie', 'tickets.screening.hall', 'reviews.movie');
        $tickets = $user->tickets;
        $activeTickets = $tickets->where('screening.time', '>', now());
        $pastTickets = $tickets->where('screening.time', '<', now());
        $reviews = $user->reviews;

        return view('admin.users.show', compact('user', 'tickets', 'activeTickets', 'pastTickets', 'reviews'));
    }

    /**
     * Delete the user.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted.');
    }
}
