<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScreeningController extends Controller
{
    /**
     * Show the specified screening.
     */
    public function show(int $screening_id): View
    {
        $screening = Screening::with('movie', 'hall', 'tickets.user')->findOrFail($screening_id);
        return view('screenings.show', compact('screening'));
    }
}
