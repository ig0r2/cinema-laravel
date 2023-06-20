<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ScreeningController extends Controller
{
    /**
     * Show the home page.
     */
    public static function index(Request $request): View
    {
        $dateSelected = $request->query('date', Carbon::today()->format('Y-m-d'));

        $movies = Movie::with([
            'genres',
            'actors',
            'directors',
            'screenings' => function ($query) use ($dateSelected) {
                $query->whereDate('time', $dateSelected)->orderBy('time', 'asc');
            },
            'screenings.hall',
        ])
            ->withAvg('reviews as rating', 'rating')
            ->whereHas('screenings', function ($query) use ($dateSelected) {
                $query->whereDate('time', $dateSelected);
            })
            ->get();

        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $dates[] = Carbon::today()
                ->addDays($i)
                ->format('Y-m-d');
        }

        return view('screenings', compact('movies', 'dateSelected', 'dates'));
    }
}
