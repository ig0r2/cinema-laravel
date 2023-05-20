<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Show the login page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public static function index()
    {
        return view('auth.login');
    }

    /**
     * Login the user.
     *
     * @param \App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function store(LoginRequest $request)
    {
        if (!auth()->attempt($request->validated())) {
            return back()->withErrors(['email' => 'Pogrešan email ili lozinka.']);
        }

        return redirect()->intended('/home');
    }

    /**
     * Logout the user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function destroy()
    {
        session()->flush();
        auth()->logout();

        return redirect('/login');
    }
}
