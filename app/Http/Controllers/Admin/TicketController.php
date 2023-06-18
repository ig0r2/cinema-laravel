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

        $tickets = Ticket::with([
            'screening' => function ($query) {
                $query->with('movie')->orderBy('time', 'desc');
            },
        ])
            ->when($title, function ($query, $title) {
                $query->whereRelation('screening.movie', 'title', 'like', "%{$title}%");
            })
            ->when($date, function ($query, $date) {
                $query->whereRelation('screening', 'time', 'like', "%{$date}%");
            })
            ->when($user, function ($query, $user) {
                $query->whereRelation('user', 'name', 'like', "%{$user}%");
            })
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
