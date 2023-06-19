<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the home page.
     */
    public static function index(): View
    {
        $user = User::where('id', auth()->user()->id)->firstOrFail();

        return view('user.index', compact('user'));
    }

    /**
     * Show the home page.
     */
    public static function homepage(): View
    {
        $movies = Movie::with([
            'genres',
            'actors',
            'directors',
            'reviews',
            'screenings' => function ($query) {
                $query->whereDate('time', Carbon::today())->orderBy('time', 'asc');
            },
            'screenings.hall',
        ])
            ->whereHas('screenings', function ($query) {
                $query->whereDate('time', Carbon::today());
            })
            ->get();

        return view('homepage', compact('movies'));
    }
}
