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
        Route::group(['prefix' => 'movies'], function () {
            /**
             * Movie routes
             */
            Route::get('/', 'MovieController@index')->name('movies.index');
            Route::get('/create', 'MovieController@create')->name('movies.create');
            Route::post('/', 'MovieController@store')->name('movies.store');
            // Route::get('/{movie}', 'MovieController@show')->name('movies.show');
            Route::get('/{movie}/edit', 'MovieController@edit')->name('movies.edit');
            Route::post('/{movie}', 'MovieController@update')->name('movies.update');
            Route::get('/{movie}/delete', 'MovieController@destroy')->name('movies.destroy');
        });
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
        Route::group(['prefix' => 'actors'], function () {
            /**
             * Actor routes
             */
            Route::get('/', 'ActorController@index')->name('actors.index');
            Route::get('/create', 'ActorController@create')->name('actors.create');
            Route::post('/', 'ActorController@store')->name('actors.store');
            // Route::get('/{actor}', 'ActorController@show')->name('actors.show');
            Route::get('/{actor}/edit', 'ActorController@edit')->name('actors.edit');
            Route::post('/{actor}', 'ActorController@update')->name('actors.update');
            Route::get('/{actor}/delete', 'ActorController@destroy')->name('actors.destroy');
        });
        Route::group(['prefix' => 'directors'], function () {
            /**
             * Director routes
             */
            Route::get('/', 'DirectorController@index')->name('directors.index');
            Route::get('/create', 'DirectorController@create')->name('directors.create');
            Route::post('/', 'DirectorController@store')->name('directors.store');
            // Route::get('/{director}', 'DirectorController@show')->name('directors.show');
            Route::get('/{director}/edit', 'DirectorController@edit')->name('directors.edit');
            Route::post('/{director}', 'DirectorController@update')->name('directors.update');
            Route::get('/{director}/delete', 'DirectorController@destroy')->name('directors.destroy');
        });
        Route::group(['prefix' => 'halls', 'as' => 'halls.'], function () {
            /**
             * Hall routes
             */
            Route::get('/', 'HallController@index')->name('index');
            Route::get('/create', 'HallController@create')->name('create');
            Route::post('/', 'HallController@store')->name('store');
            // Route::get('/{hall}', 'HallController@show')->name('show');
            Route::get('/{hall}/edit', 'HallController@edit')->name('edit');
            Route::post('/{hall}', 'HallController@update')->name('update');
            Route::get('/{hall}/delete', 'HallController@destroy')->name('destroy');
        });
        Route::group(['prefix' => 'screenings', 'as' => 'screenings.'], function () {
            /**
             * Screening routes
             */
            Route::get('/', 'ScreeningController@index')->name('index');
            Route::get('/create', 'ScreeningController@create')->name('create');
            Route::post('/', 'ScreeningController@store')->name('store');
            // Route::get('/{screening}', 'ScreeningController@show')->name('show');
            // Route::get('/{screening}/edit', 'ScreeningController@edit')->name('edit');
            // Route::post('/{screening}', 'ScreeningController@update')->name('update');
            Route::get('/{screening}/delete', 'ScreeningController@destroy')->name('destroy');
        });
    });
});
