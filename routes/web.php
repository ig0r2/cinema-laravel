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
    Route::group(['prefix' => 'movies', 'as' => 'movies.'], function () {
        /**
         * Movie routes
         */
        Route::get('/', 'MovieController@index')->name('index');
        Route::get('/{movie}', 'MovieController@show')->name('show');
    });
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['prefix' => 'tickets', 'as' => 'tickets.'], function () {
            /**
             * Ticket routes
             */
            Route::get('/create/{screening}', 'TicketController@create')->name('create');
            Route::post('/{screening}', 'TicketController@store')->name('store');
            Route::get('/{ticket}', 'TicketController@show')->name('show');
            Route::get('/{ticket}/pdf', 'TicketController@pdf')->name('pdf');
        });
        Route::group(['prefix' => 'reviews', 'as' => 'reviews.'], function () {
            /**
             * Review routes
             */
            Route::post('/{movie}', 'ReviewController@store')->name('store');
        });
    });
});

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\Admin'], function () {
    /**
     * Admin middleware
     */
    Route::group(['middleware' => 'admin'], function () {
        Route::group(['prefix' => 'movies', 'as' => 'movies.'], function () {
            /**
             * Movie routes
             */
            Route::get('/', 'MovieController@index')->name('index');
            Route::get('/create', 'MovieController@create')->name('create');
            Route::post('/', 'MovieController@store')->name('store');
            Route::get('/{movie}/edit', 'MovieController@edit')->name('edit');
            Route::post('/{movie}', 'MovieController@update')->name('update');
            Route::get('/{movie}/delete', 'MovieController@destroy')->name('destroy');
        });
        Route::group(['prefix' => 'genres', 'as' => 'genres.'], function () {
            /**
             * Genre routes
             */
            Route::get('/', 'GenreController@index')->name('index');
            Route::get('/create', 'GenreController@create')->name('create');
            Route::post('/', 'GenreController@store')->name('store');
            Route::get('/{genre}/edit', 'GenreController@edit')->name('edit');
            Route::post('/{genre}', 'GenreController@update')->name('update');
            Route::get('/{genre}/delete', 'GenreController@destroy')->name('destroy');
        });
        Route::group(['prefix' => 'actors', 'as' => 'actors.'], function () {
            /**
             * Actor routes
             */
            Route::get('/', 'ActorController@index')->name('index');
            Route::get('/create', 'ActorController@create')->name('create');
            Route::post('/', 'ActorController@store')->name('store');
            Route::get('/{actor}/edit', 'ActorController@edit')->name('edit');
            Route::post('/{actor}', 'ActorController@update')->name('update');
            Route::get('/{actor}/delete', 'ActorController@destroy')->name('destroy');
        });
        Route::group(['prefix' => 'directors', 'as' => 'directors.'], function () {
            /**
             * Director routes
             */
            Route::get('/', 'DirectorController@index')->name('index');
            Route::get('/create', 'DirectorController@create')->name('create');
            Route::post('/', 'DirectorController@store')->name('store');
            Route::get('/{director}/edit', 'DirectorController@edit')->name('edit');
            Route::post('/{director}', 'DirectorController@update')->name('update');
            Route::get('/{director}/delete', 'DirectorController@destroy')->name('destroy');
        });
        Route::group(['prefix' => 'halls', 'as' => 'halls.'], function () {
            /**
             * Hall routes
             */
            Route::get('/', 'HallController@index')->name('index');
            Route::get('/create', 'HallController@create')->name('create');
            Route::post('/', 'HallController@store')->name('store');
            Route::get('/{hall}/edit', 'HallController@edit')->name('edit');
            Route::post('/{hall}', 'HallController@update')->name('update');
            Route::get('/{hall}/delete', 'HallController@destroy')->name('destroy');
        });
        Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
            /**
             * User routes
             */
            Route::get('/{user}/edit', 'UserController@edit')->name('edit');
            Route::post('/{user}', 'UserController@update')->name('update');
            Route::get('/{user}/delete', 'UserController@destroy')->name('destroy');
        });
    });
    /**
     * Manager middleware
     */
    Route::group(['middleware' => 'manager'], function () {
        Route::group(['prefix' => 'screenings', 'as' => 'screenings.'], function () {
            /**
             * Screening routes
             */
            Route::get('/', 'ScreeningController@index')->name('index');
            Route::get('/create', 'ScreeningController@create')->name('create');
            Route::post('/', 'ScreeningController@store')->name('store');
            Route::get('/{screening}', 'ScreeningController@show')->name('show');
            Route::get('/{screening}/pdf', 'ScreeningController@pdf')->name('pdf');
            Route::get('/{screening}/delete', 'ScreeningController@destroy')->name('destroy');
        });
        Route::group(['prefix' => 'tickets', 'as' => 'tickets.'], function () {
            /**
             * Ticket routes
             */
            Route::get('/', 'TicketController@index')->name('index');
            Route::get('/{ticket}/delete', 'TicketController@destroy')->name('destroy');
        });
        Route::group(['prefix' => 'reviews', 'as' => 'reviews.'], function () {
            /**
             * Review routes
             */
            Route::get('/', 'ReviewController@index')->name('index');
            Route::get('/{review}/delete', 'ReviewController@destroy')->name('destroy');
        });
        Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
            /**
             * User routes
             */
            Route::get('/', 'UserController@index')->name('index');
            Route::get('/{user}', 'UserController@show')->name('show');
            Route::get('/{user}/ban', 'UserController@ban')->name('ban');
            Route::get('/{user}/unban', 'UserController@unban')->name('unban');
        });
    });
});
