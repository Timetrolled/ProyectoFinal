<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});


Route::get('/details/{id}', function ($id) {
    return view('details')->with(compact('id'));
});

Route::get('user/{id}','UserController@show');

Route::get('/register','RegistrationController@create');
Route::post('register','RegistrationController@store');


Route::get('/login', 'SessionsController@create');
Route::post('/login', 'SessionsController@store');
Route::get('/logout', 'SessionsController@destroy');



Route::get('is-auth', function () {
    $auth = Auth::user();
    return $auth;
    dd($auth);
});

Route::post('/addFilm/{filmId}', 'FilmController@store');
Route::get('/addFilm/{filmId}', 'FilmController@check');