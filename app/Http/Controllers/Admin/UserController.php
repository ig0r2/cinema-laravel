<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UserExport;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Excel;

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
     * Download the users as an Excel file.
     */
    public function xlsx()
    {
        return Excel::download(new UserExport(), 'users.xlsx');
    }

    /**
     * Show the user
     */
    public function show(User $user): View
    {
        $user->load('tickets.screening.movie', 'tickets.screening.hall', 'reviews.movie', 'messages');
        $tickets = $user->tickets;
        $activeTickets = $tickets->where('screening.time', '>', now());
        $pastTickets = $tickets->where('screening.time', '<', now());
        $reviews = $user->reviews;
        $messages = $user->messages;
        $logs = $user->logs;

        return view(
            'admin.users.show',
            compact('user', 'tickets', 'activeTickets', 'pastTickets', 'reviews', 'messages', 'logs')
        );
    }

    /**
     * Show the user edit page.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'role' => 'required|int|between:0,2',
        ]);
        $user->update($request->only('role'));

        return redirect()
            ->back()
            ->with('success', 'User updated.');
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
