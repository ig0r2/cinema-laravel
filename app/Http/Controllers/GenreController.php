<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GenreController extends Controller
{
    /**
     * Show the genres page.
     */
    public function index(): View
    {
        return view('genres.index', [
            'genres' => Genre::all(),
        ]);
    }

    /**
     * Show the form for creating a new genre.
     */
    public function create(): View
    {
        return view('genres.create');
    }

    /**
     * Store a new genre in the database.
     */
    public function store(Request $request): RedirectResponse
    {
        $genre = new Genre();
        $genre->name = $request->input('name');
        $genre->save();

        return redirect()->route('genres.index');
    }

    /**
     * Show the form for editing the specified genre.
     */
    public function edit(Genre $genre): View
    {
        return view('genres.edit', [
            'genre' => $genre,
        ]);
    }

    /**
     * Update the specified genre in the database.
     */
    public function update(Genre $genre, Request $request): RedirectResponse
    {
        $genre->name = $request->input('name');
        $genre->save();

        return redirect()->route('genres.index');
    }

    /**
     * Delete the specified genre from the database.
     */
    public function destroy(Genre $genre): RedirectResponse
    {
        $genre->delete();

        return redirect()->route('genres.index');
    }
}
