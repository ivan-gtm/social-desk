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

Route::get('/post/{post_id}', 'PostController@index');
Route::get('/user/{user_id}', 'UserController@index');
Route::get('/users', 'UsersController@index');
Route::get('/accounts', 'AccountsController@index');


Route::get('/calendar', 'CalendarController@index');
Route::get('/calendar/{year}/{month}/', 'CalendarController@monthView');
Route::get('/calendar/{year}/{month}/{day}/', 'CalendarController@dayView');


Route::get('/accounts/auto-follow','AutoFollowController@index');
Route::match(['get', 'post'], '/accounts/auto-follow/{account_id}/schedule','AutoFollowController@schedule');
Route::get('/accounts/auto-follow/{account_id}/log', 'AutoFollowController@log');
// Route::post('/accounts/auto-follow/{account_id}/schedule', 'AutoFollowController@save');
// Route::get('/accounts/auto-follow/{account_id}/schedule', 'AutoFollowController@schedule');


// AUTO TASKS
Route::get('/accounts/auto-follow/cron', 'AutoFollowController@cronJob');
Route::get('/accounts/auto-like/cron', 'AutoLikeController@cronJob');


// SCRAPPER
Route::get('/scrappy', 'IgFeedController@test');
Route::get('/cron', 'CronController@send_scheduled_posts');
Route::get('/pinterest', 'PinterestController@index');