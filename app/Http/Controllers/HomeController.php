<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public static function index()
    {
        return view('user.index', [
            'user' => User::with('tickets.screening.movie', 'tickets.screening.hall')
                ->where('id', auth()->user()->id)
                ->firstOrFail(),
        ]);
    }
}
