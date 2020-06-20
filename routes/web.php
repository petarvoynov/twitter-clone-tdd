<?php

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
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/tweets', 'TweetsController@index')->name('tweets.index');
    Route::post('/tweets', 'TweetsController@store')->name('tweets.store');
    Route::patch('/tweets/{tweet}' , 'TweetsController@update')->name('tweets.update');
    Route::delete('/tweets/{tweet}' , 'TweetsController@destroy')->name('tweets.destroy');

    Route::post('/users/{user}/follow', 'UsersController@follow')->name('users.follow');
    Route::post('/users/{user}/unfollow', 'UsersController@unfollow')->name('users.unfollow');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
