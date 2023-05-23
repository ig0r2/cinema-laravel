<?php

namespace App\Http\Controllers;

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
        return view('screenings.index', [
            'screenings' => Screening::with('movie')
                ->with('hall')
                ->get(),
        ]);
    }

    /**
     * Show the form for creating a new screening.
     */
    public function create(): View
    {
        return view('screenings.create', [
            'movies' => Movie::all(),
            'halls' => Hall::all(),
        ]);
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
        ]);

        return redirect()->route('screenings.index');
    }

    /**
     * Delete the specified screening from the database.
     */
    public function destroy(Screening $screening): RedirectResponse
    {
        $screening->delete();

        return redirect()->route('screenings.index');
    }
}
