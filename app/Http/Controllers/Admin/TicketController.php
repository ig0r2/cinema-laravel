<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Screening;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{
    /**
     * Show the tickets page.
     */
    public function index(Request $request): View
    {
        $title = $request->input('title');
        $user = $request->input('user');
        $date = $request->input('date');

        $tickets = Ticket::join('screenings', 'tickets.screening_id', '=', 'screenings.id')
            ->join('movies', 'screenings.movie_id', '=', 'movies.id')
            ->join('users', 'tickets.user_id', '=', 'users.id')
            ->when($title, function ($query, $title) {
                return $query->where('movies.title', 'like', '%' . $title . '%');
            })
            ->when($user, function ($query, $user) {
                return $query->where('users.name', 'like', '%' . $user . '%');
            })
            ->when($date, function ($query, $date) {
                return $query->where('screenings.time', 'like', '%' . $date . '%');
            })
            ->select('tickets.*')
            ->orderBy('screenings.time', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.tickets.index', compact('tickets'));
    }

    /**
     * Delete the specified ticket from the database.
     */
    public function destroy(Ticket $ticket): RedirectResponse
    {
        $ticket->delete();

        return redirect()->route('admin.tickets.index');
    }
}
