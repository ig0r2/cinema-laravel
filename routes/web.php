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
    Route::group(['prefix' => 'dashboard'], function () {
        Route::group(['prefix' => 'genres'], function () {
            /**
             * Genre routes
             */
            Route::get('/', 'GenreController@index')->name('genres.index');
            Route::get('/create', 'GenreController@create')->name('genres.create');
            Route::post('/', 'GenreController@store')->name('genres.store');
            // Route::get('/{genre}', 'GenreController@show')->name('genres.show');
            Route::get('/{genre}/edit', 'GenreController@edit')->name('genres.edit');
            Route::post('/{genre}', 'GenreController@update')->name('genres.update');
            Route::get('/{genre}/delete', 'GenreController@destroy')->name('genres.destroy');
        });
    });
});
