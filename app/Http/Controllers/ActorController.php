<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActorController extends Controller
{
    /**
     * Show the actors page.
     */
    public function index(): View
    {
        return view('actors.index', [
            'actors' => Actor::all(),
        ]);
    }

    /**
     * Show the form for creating a new actor.
     */
    public function create(): View
    {
        return view('actors.create');
    }

    /**
     * Store a new actor in the database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        Actor::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('actors.index');
    }

    /**
     * Show the form for editing the specified actor.
     */
    public function edit(Actor $actor): View
    {
        return view('actors.edit', [
            'actor' => $actor,
        ]);
    }

    /**
     * Update the specified actor in the database.
     */
    public function update(Actor $actor, Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $actor->update([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('actors.index');
    }

    /**
     * Delete the specified actor from the database.
     */
    public function destroy(Actor $actor): RedirectResponse
    {
        $actor->delete();

        return redirect()->route('actors.index');
    }
}
