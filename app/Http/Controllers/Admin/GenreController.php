<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $genres = Genre::paginate(10);

        return view('admin.genres.index', compact('genres'));
    }

    /**
     * Show the form for creating a new genre.
     */
    public function create(): View
    {
        return view('admin.genres.create');
    }

    /**
     * Store a new genre in the database.
     */
    public function store(Request $request): RedirectResponse
    {
        $genre = new Genre();
        $genre->name = $request->input('name');
        $genre->save();

        return redirect()->route('admin.genres.index');
    }

    /**
     * Show the form for editing the specified genre.
     */
    public function edit(Genre $genre): View
    {
        return view('admin.genres.edit', compact('genre'));
    }

    /**
     * Update the specified genre in the database.
     */
    public function update(Genre $genre, Request $request): RedirectResponse
    {
        $genre->name = $request->input('name');
        $genre->save();

        return redirect()->route('admin.genres.index');
    }

    /**
     * Delete the specified genre from the database.
     */
    public function destroy(Genre $genre): RedirectResponse
    {
        $genre->delete();

        return redirect()->route('admin.genres.index');
    }
}
