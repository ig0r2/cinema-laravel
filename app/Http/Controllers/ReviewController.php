<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Log;

class ReviewController extends Controller
{
    /**
     * Store a new review in the database.
     */
    public function store(Request $request, Movie $movie): RedirectResponse
    {
        $request->validate([
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:10',
        ]);

        Review::create([
            'content' => $request->input('content'),
            'rating' => $request->input('rating'),
            'movie_id' => $movie->id,
            'user_id' => $request->user()->id,
        ]);

        Log::channel('users')->info(
            'Korisnik ' . auth()->user()->name . ' je ostavio recenziju za film ' . $movie->title . '.'
        );

        return redirect()->route('movies.show', $movie);
    }
}
