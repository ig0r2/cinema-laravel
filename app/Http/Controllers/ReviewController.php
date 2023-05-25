<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

        return redirect()->route('movies.show', $movie);
    }

    /**
     * Delete the given review.
     */
    public function destroy(Movie $movie, Review $review): RedirectResponse
    {
        $review->delete();

        return redirect()->route('movies.show', $movie);
    }
}
