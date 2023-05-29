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
    public function index(): View
    {
        $tickets = Ticket::with('screening.movie', 'user')->get();

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
