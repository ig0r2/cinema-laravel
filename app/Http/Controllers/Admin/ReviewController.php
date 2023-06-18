<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Show all reviews
     */
    public function index(): View
    {
        $reviews = Review::with('movie', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.reviews.index', compact('reviews'));
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
