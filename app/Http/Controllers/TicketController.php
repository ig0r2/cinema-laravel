<?php

namespace App\Http\Controllers;

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
        return view('tickets.index', [
            'tickets' => Ticket::all(),
        ]);
    }

    /**
     * Show the form for creating a new ticket for a screening.
     */
    public function create(Screening $screening): View
    {
        return view('tickets.create', [
            'screening' => $screening,
        ]);
    }

    /**
     * Store a new ticket in the database.
     */
    public function store(Screening $screening, Request $request): RedirectResponse
    {
        $request->validate([
            'number_of_tickets' => 'required|integer|min:1',
        ]);

        if ($screening->seats_available - $request->number_of_tickets < 0) {
            return redirect()
                ->back()
                ->withErrors([
                    'number_of_tickets' => 'There are not enough seats available for this screening.',
                ]);
        }

        for ($i = 0; $i < $request->number_of_tickets; $i++) {
            Ticket::create([
                'user_id' => auth()->user()->id,
                'screening_id' => $screening->id,
                'seat' => $screening->tickets->count() + 1 + $i,
                'price' => $screening->price,
            ]);
            $screening->seats_available--;
        }
        $screening->save();

        return redirect()->route('tickets.index');
    }

    /**
     * Show the specified ticket.
     */
    public function show(Ticket $ticket): View
    {
        return view('tickets.show', [
            'ticket' => $ticket,
        ]);
    }

    /**
     * Delete the specified ticket from the database.
     */
    public function destroy(Ticket $ticket): RedirectResponse
    {
        $ticket->delete();

        return redirect()->route('tickets.index');
    }
}
