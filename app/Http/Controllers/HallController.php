<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HallController extends Controller
{
    /**
     * Show the halls page.
     */
    public function index(): View
    {
        return view('halls.index', [
            'halls' => Hall::all(),
        ]);
    }

    /**
     * Show the form for creating a new hall.
     */
    public function create(): View
    {
        return view('halls.create');
    }

    /**
     * Store a new hall in the database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
            'capacity' => 'required|integer',
        ]);

        Hall::create([
            'name' => $request->input('name'),
            'capacity' => $request->input('capacity'),
        ]);

        return redirect()->route('halls.index');
    }

    /**
     * Show the form for editing the specified hall.
     */
    public function edit(Hall $hall): View
    {
        return view('halls.edit', [
            'hall' => $hall,
        ]);
    }

    /**
     * Update the specified hall in the database.
     */
    public function update(Request $request, Hall $hall): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
            'capacity' => 'required|integer',
        ]);

        $hall->update([
            'name' => $request->input('name'),
            'capacity' => $request->input('capacity'),
        ]);

        return redirect()->route('halls.index');
    }

    /**
     * Delete the specified hall from the database.
     */
    public function destroy(Hall $hall): RedirectResponse
    {
        $hall->delete();

        return redirect()->route('halls.index');
    }
}
