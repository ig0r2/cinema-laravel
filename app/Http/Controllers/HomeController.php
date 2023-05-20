<?php

namespace App\Http\Controllers;

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
            'user' => auth()->user()
        ]);
    }
}
