<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('homepage');
});

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::group(['middleware' => ['guest']], function () {
        /**
         * Register routes
         */
        Route::get('/register', 'RegisterController@index')->name('register');
        Route::post('/register', 'RegisterController@store')->name('register.store');
        /**
         * Login routes
         */
        Route::get('/login', 'LoginController@index')->name('login');
        Route::post('/login', 'LoginController@store')->name('login.store');
    });
    Route::group(['middleware' => ['auth']], function () {
        /**
         * Logout route
         */
        Route::get('/logout', 'LoginController@destroy')->name('logout');
        /**
         * Home route
         */
        Route::get('/home', 'HomeController@index')->name('home');
    });
});


Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/movies', 'MovieController@index')->name('movies.index');
});