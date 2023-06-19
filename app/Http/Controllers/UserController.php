<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Show the profile page.
     */
    public static function index(): View
    {
        $user = User::where('id', auth()->user()->id)->firstOrFail();

        return view('user.index', compact('user'));
    }
}
