<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Director;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DirectorController extends Controller
{
    /**
     * Show the directors page.
     */
    public function index(): View
    {
        $directors = Director::paginate(10);

        return view('admin.directors.index', compact('directors'));
    }

    /**
     * Show the form for creating a new director.
     */
    public function create(): View
    {
        return view('admin.directors.create');
    }

    /**
     * Store a new director in the database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        Director::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('admin.directors.index');
    }

    /**
     * Show the form for editing the specified director.
     */
    public function edit(Director $director): View
    {
        return view('admin.directors.edit', compact('director'));
    }

    /**
     * Update the specified director in the database.
     */
    public function update(Request $request, Director $director): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $director->update([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('admin.directors.index');
    }

    /**
     * Delete the specified director from the database.
     */
    public function destroy(Director $director): RedirectResponse
    {
        $director->delete();

        return redirect()->route('admin.directors.index');
    }
}
