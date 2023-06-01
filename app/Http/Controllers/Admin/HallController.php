<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $halls = Hall::paginate(10);

        return view('admin.halls.index', compact('halls'));
    }

    /**
     * Show the form for creating a new hall.
     */
    public function create(): View
    {
        return view('admin.halls.create');
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

        return redirect()->route('admin.halls.index');
    }

    /**
     * Show the form for editing the specified hall.
     */
    public function edit(Hall $hall): View
    {
        return view('admin.halls.edit', compact('hall'));
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

        return redirect()->route('admin.halls.index');
    }

    /**
     * Delete the specified hall from the database.
     */
    public function destroy(Hall $hall): RedirectResponse
    {
        try {
            $hall->delete();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.halls.index')
                ->with('error', 'Hall is in use and cannot be deleted.');
        }

        return redirect()->route('admin.halls.index');
    }
}
