<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Screening;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use PDF;
use Log;

class TicketController extends Controller
{
    /**
     * Show all tickets from the user.
     */
    public function index(): View
    {
        $tickets = Ticket::where('user_id', auth()->user()->id)
            ->with('screening.movie', 'screening.hall')
            ->whereHas('screening', function ($query) {
                $query->where('time', '>', now());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show all past tickets from the user.
     */
    public function past(): View
    {
        $tickets = Ticket::where('user_id', auth()->user()->id)
            ->with('screening.movie', 'screening.hall')
            ->whereHas('screening', function ($query) {
                $query->where('time', '<', now());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('tickets.past', compact('tickets'));
    }

    /**
     * Show the form for creating a new ticket for a screening.
     */
    public function create(Screening $screening): View
    {
        return view('tickets.create', compact('screening'));
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

        Log::channel('users')->info(
            'Korisnik ' .
                auth()->user()->name .
                ' je kupio ' .
                $request->number_of_tickets .
                ' karte za projekciju ' .
                $screening->id .
                ' filma ' .
                $screening->movie->title .
                '.'
        );

        return redirect()->route('profile');
    }

    /**
     * Show the specified ticket.
     */
    public function show(Ticket $ticket): View
    {
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the pdf
     */
    public function pdf(Ticket $ticket): Response
    {
        $ticket->load('screening.movie', 'screening.hall', 'user');
        $pdf = PDF::loadView('pdf.ticket', compact('ticket'));

        return $pdf->download('ticket ' . $ticket->id . '.pdf');
    }
}
