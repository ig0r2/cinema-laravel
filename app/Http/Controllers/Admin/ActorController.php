<?php

namespace App\Http\Controllers\Admin;

use App\Models\Actor;
use App\Http\Controllers\Controller;
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
        $actors = Actor::paginate(10);

        return view('admin.actors.index', compact('actors'));
    }

    /**
     * Show the form for creating a new actor.
     */
    public function create(): View
    {
        return view('admin.actors.create');
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

        return redirect()->route('admin.actors.index');
    }

    /**
     * Show the form for editing the specified actor.
     */
    public function edit(Actor $actor): View
    {
        return view('admin.actors.edit', compact('actor'));
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

        return redirect()->route('admin.actors.index');
    }

    /**
     * Delete the specified actor from the database.
     */
    public function destroy(Actor $actor): RedirectResponse
    {
        $actor->delete();

        return redirect()->route('admin.actors.index');
    }
}
