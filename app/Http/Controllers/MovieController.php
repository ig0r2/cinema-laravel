<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovieController extends Controller
{
    /**
     * Show the movies page.
     */
    public function index() : View
    {
        return view('movies', [
            'movies' => Movie::with('genres')->with('actors')->with('directors')->get(),
        ]);
    }
}
