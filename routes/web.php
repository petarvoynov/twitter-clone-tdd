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
    Route::get('/tweets/{tweet}', 'TweetsController@show')->name('tweets.show');
    Route::post('/tweets', 'TweetsController@store')->name('tweets.store');
    Route::patch('/tweets/{tweet}' , 'TweetsController@update')->name('tweets.update');
    Route::delete('/tweets/{tweet}' , 'TweetsController@destroy')->name('tweets.destroy');
    Route::post('/tweets/{tweet}/like', 'LikeTweetsController@store')->name('tweets-like.store');
    Route::delete('/tweets/{tweet}/unlike', 'LikeTweetsController@destroy')->name('tweets-unlike.destroy');

    Route::post('/tweets/{tweet}/retweet', 'RetweetsController@store')->name('retweets.store');
    Route::delete('/tweets/{tweet}/unretweet', 'RetweetsController@destroy')->name('retweets.destroy');

    Route::post('/users/{user}/follow', 'UsersController@follow')->name('users.follow');
    Route::post('/users/{user}/unfollow', 'UsersController@unfollow')->name('users.unfollow');

    Route::post('/tweets/{tweet}/comments', 'CommentsController@store')->name('comments.store');

    Route::post('/comments/{comment}/like', 'LikeCommentsController@store')->name('likes.store');
    Route::delete('/comments/{comment}/unlike', 'LikeCommentsController@destroy')->name('likes.destroy');

    Route::get('/users/{user}', 'UsersController@show')->name('users.show');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
