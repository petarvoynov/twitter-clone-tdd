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

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'TweetsController@index')->name('tweets.index');
    Route::get('/tweets/{tweet}', 'TweetsController@show')->name('tweets.show');
    Route::post('/tweets', 'TweetsController@store')->name('tweets.store');
    Route::patch('/tweets/{tweet}' , 'TweetsController@update')->name('tweets.update');
    Route::delete('/tweets/{tweet}' , 'TweetsController@destroy')->name('tweets.destroy');
    Route::post('/tweets/{tweet}/like', 'LikeTweetsController@store')->name('tweets-like.store');
    Route::delete('/tweets/{tweet}/unlike', 'LikeTweetsController@destroy')->name('tweets-unlike.destroy');

    Route::post('/retweets/{tweet}', 'RetweetsController@store')->name('retweets.store');
    Route::delete('/retweets/{tweet}', 'RetweetsController@destroy')->name('retweets.destroy');

    Route::post('/users/{user}/follow', 'UsersController@follow')->name('users.follow');
    Route::post('/users/{user}/unfollow', 'UsersController@unfollow')->name('users.unfollow');

    Route::post('/tweets/{tweet}/comments', 'CommentsController@store')->name('comments.store');
    Route::patch('/tweets/{tweet}/comments/{comment}', 'CommentsController@update')->name('comments.update');
    Route::delete('/tweets/{tweet}/comments/{comment}', 'CommentsController@destroy')->name('comments.destroy');

    Route::post('/comments/{comment}/like', 'LikeCommentsController@store')->name('likes.store');
    Route::delete('/comments/{comment}/unlike', 'LikeCommentsController@destroy')->name('likes.destroy');

    Route::get('/users/{user}', 'UsersController@show')->name('users.show');
    Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
    Route::patch('/users/{user}', 'UsersController@update')->name('users.update');
    Route::post('/users/{user}/profile-picture', 'UserProfilePictureController@store')->name('user-profile-picture.store');
    Route::get('/users/{user}/profile-picture/edit', 'UserProfilePictureController@edit')->name('user-profile-picture.edit');

    Route::post('/users/{user}/subscribe', 'UserSubscribesController@store')->name('user-subscribes.store');
    Route::delete('/users/{user}/unsubscribe', 'UserSubscribesController@destroy')->name('user-unsubscribes.destroy');

    Route::get('/notifications', 'NotificationsController@index')->name('notifications.index');
    Route::get('/unread-notifications', 'NotificationsController@unread')->name('notifications.unread');
    Route::get('/read-notifications', 'NotificationsController@read')->name('notifications.read');

    Route::get('/lists', 'TwitterListsController@index')->name('twitter-lists.index');
    Route::post('/lists', 'TwitterListsController@store')->name('twitter-lists.store');
    Route::get('/lists/create', 'TwitterListsController@create')->name('twitter-lists.create');
    Route::get('/lists/{list}', 'TwitterListsController@show')->name('twitter-lists.show');

    Route::post('/pinned-lists/{list}', 'PinnedListsController@store')->name('pinned-lists.store');
    Route::delete('/pinned-lists/{list}', 'PinnedListsController@destroy')->name('pinned-lists.destroy');

    Route::post('/lists/{list}/users/filter', 'TwitterListUsersController@filterNames')->name('twitter-list-users.filterNames');
    Route::post('/lists/{list}/users/{user}', 'TwitterListUsersController@store')->name('twitter-list-users.store');
    Route::delete('/lists/{list}/users/{user}', 'TwitterListUsersController@destroy')->name('twitter-list-users.destroy');
    Route::get('/lists/{list}/users/create', 'TwitterListUsersController@create')->name('twitter-list-users.create');

    Route::get('/bookmarks', 'BookmarksController@index')->name('bookmarks.index');
    Route::post('/tweets/{tweet}/bookmark', 'BookmarksController@store')->name('bookmarks.store');
    Route::delete('/tweets/{tweet}/unbookmark', 'BookmarksController@destroy')->name('bookmarks.destroy');
    Route::post('/bookmarks/search', 'BookmarksController@search')->name('bookmarks.search');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
