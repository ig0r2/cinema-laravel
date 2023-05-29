<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hall;
use App\Models\Movie;
use App\Models\Screening;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScreeningController extends Controller
{
    /**
     * Show the screenings page.
     */
    public function index(): View
    {
        $screenings = Screening::with('movie', 'hall')->get();

        return view('admin.screenings.index', compact('screenings'));
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
     * Delete the specified screening from the database.
     */
    public function destroy(Screening $screening): RedirectResponse
    {
        $screening->delete();

        return redirect()->route('admin.screenings.index');
    }
}
