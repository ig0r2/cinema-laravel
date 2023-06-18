<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovieController extends Controller
{
    /**
     * Show the movies page.
     */
    public function index(): View
    {
        $movies = Movie::all();

        return view('movies.index', compact('movies'));
    }

    /**
     * Show the specified movie.
     */
    public function show(int $movie_id): View
    {
        $movie = Movie::with([
            'genres',
            'actors',
            'directors',
            'reviews' => function ($query) {
                $query->with('user')->orderBy('created_at', 'desc');
            },
        ])->findOrFail($movie_id);

        return view('movies.show', compact('movie'));
    }
}
