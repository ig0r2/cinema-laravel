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
        $user = User::where('id', auth()->user()->id)->firstOrFail();

        return view('user.index', compact('user'));
    }
}
