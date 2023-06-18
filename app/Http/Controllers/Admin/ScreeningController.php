<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ScreeningExport;
use App\Http\Controllers\Controller;
use App\Models\Hall;
use App\Models\Movie;
use App\Models\Screening;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use PDF;
use Excel;

class ScreeningController extends Controller
{
    /**
     * Show the screenings page.
     */
    public function index(Request $request): View
    {
        $title = $request->input('title');
        $date = $request->input('date');

        $screenings = Screening::with('movie', 'hall')
            ->when($title, function ($query, $title) {
                $query->whereRelation('movie', 'title', 'like', "%{$title}%");
            })
            ->when($date, function ($query, $date) {
                $query->where('time', 'like', "%{$date}%");
            })
            ->orderBy('time', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.screenings.index', compact('screenings'));
    }

    /**
     * Download the screenings as a XLSX file.
     */
    public function xlsx(Screening $screening): object
    {
        return Excel::download(new ScreeningExport($screening), 'projekcija-' . $screening->id . '.xlsx');
    }

    /**
     * Show the form for creating a new screening.
     */
    public function create(): View
    {
        $movies = Movie::all();
        $halls = Hall::all();

        return view('admin.screenings.create', compact('movies', 'halls'));
    }

    /**
     * Store a new screening in the database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'movie' => 'required|integer',
            'hall' => 'required|integer',
            'time' => 'required|date',
            'price' => 'required|numeric',
            'type' => 'required|string',
        ]);

        Screening::create([
            'movie_id' => $request->input('movie'),
            'hall_id' => $request->input('hall'),
            'time' => $request->input('time'),
            'price' => $request->input('price'),
            'type' => $request->input('type'),
            'seats_available' => Hall::find($request->input('hall'))->capacity,
        ]);

        return redirect()->route('admin.screenings.index');
    }

    /**
     * Show the specified screening.
     */
    public function show(Screening $screening): View
    {
        $screening->load('movie', 'hall', 'tickets.user');
        return view('admin.screenings.show', compact('screening'));
    }

    /**
     * Show the pdf
     */
    public function pdf(Screening $screening): Response
    {
        $screening->load('movie', 'hall', 'tickets.user');
        $tickets = $screening->tickets;
        $pdf = PDF::loadView('pdf.screening', compact('screening', 'tickets'));

        return $pdf->download('projekcija ' . $screening->id . '.pdf');
    }

    /**
     * Delete the specified screening from the database.
     */
    public function destroy(Screening $screening): RedirectResponse
    {
        $screening->delete();

        return redirect()->route('admin.screenings.index');
    }
}
