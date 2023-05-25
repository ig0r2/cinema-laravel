<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Director;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovieController extends Controller
{
    /**
     * Show the movies page.
     */
    public function index(): View
    {
        return view('movies.index', [
            'movies' => Movie::all(),
        ]);
    }

    /**
     * Show the form for creating a new movie.
     */
    public function create(): View
    {
        return view('movies.create', [
            'genres' => Genre::all(),
            'actors' => Actor::all(),
            'directors' => Director::all(),
        ]);
    }

    /**
     * Store a new movie in the database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string',
            'release_date' => 'required|date',
            'runtime' => 'required|integer',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'genres' => 'required|array',
            'actors' => 'required|array',
            'directors' => 'required|array',
        ]);

        $imagePath = $request->file('image')->store('movies', 'public_images');

        $movie = Movie::create([
            'title' => $request->input('title'),
            'release_date' => $request->input('release_date'),
            'runtime' => $request->input('runtime'),
            'description' => $request->input('description'),
            'image_url' => $imagePath,
        ]);

        $movie->genres()->attach($request->input('genres'));
        $movie->actors()->attach($request->input('actors'));
        $movie->directors()->attach($request->input('directors'));

        return redirect()->route('movies.index');
    }

    /**
     * Show the specified movie.
     */
    public function show(int $movie_id): View
    {
        return view('movies.show', [
            'movie' => Movie::with('genres', 'actors', 'directors', 'reviews.user')->findOrFail($movie_id),
        ]);
    }

    /**
     * Show the form for editing the specified movie.
     */
    public function edit(Movie $movie): View
    {
        return view('movies.edit', [
            'movie' => $movie,
            'genres' => Genre::all(),
            'actors' => Actor::all(),
            'directors' => Director::all(),
        ]);
    }

    /**
     * Update the specified movie in the database.
     */
    public function update(Request $request, Movie $movie): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string',
            'release_date' => 'required|date',
            'runtime' => 'required|integer',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'genres' => 'required|array',
            'actors' => 'required|array',
            'directors' => 'required|array',
        ]);

        $movie->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('movies', 'public_images');

            $movie->update([
                'image_url' => $imagePath,
            ]);
        }

        $movie->genres()->sync($request->input('genres'));
        $movie->actors()->sync($request->input('actors'));
        $movie->directors()->sync($request->input('directors'));

        return redirect()->route('movies.index');
    }

    /**
     * Delete the specified movie from the database.
     */
    public function destroy(Movie $movie): RedirectResponse
    {
        $movie->delete();

        return redirect()->route('movies.index');
    }
}
