<?php

namespace App\Http\Controllers;

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
        return view('directors.index', [
            'directors' => Director::all(),
        ]);
    }

    /**
     * Show the form for creating a new director.
     */
    public function create(): View
    {
        return view('directors.create');
    }

    /**
     * Store a new director in the database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $imageName = \Str::replace(' ', '-', $request->input('name')) . '.' . $request->file('image')->extension();
        $imagePath = $request->file('image')->storeAs('images/directors', $imageName, 'public');

        Director::create([
            'name' => $request->input('name'),
            'image_url' => $imagePath,
        ]);

        return redirect()->route('directors.index');
    }

    /**
     * Show the form for editing the specified director.
     */
    public function edit(Director $director): View
    {
        return view('directors.edit', [
            'director' => $director,
        ]);
    }

    /**
     * Update the specified director in the database.
     */
    public function update(Request $request, Director $director): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $imageName = \Str::replace(' ', '-', $request->input('name')) . '.' . $request->file('image')->extension();
            $imagePath = $request->file('image')->storeAs('images/directors', $imageName, 'public');
        } else {
            $imagePath = $director->image_url;
        }

        $director->update([
            'name' => $request->input('name'),
            'image_url' => $imagePath,
        ]);

        return redirect()->route('directors.index');
    }

    /**
     * Delete the specified director from the database.
     */
    public function destroy(Director $director): RedirectResponse
    {
        $director->delete();

        return redirect()->route('directors.index');
    }
}
