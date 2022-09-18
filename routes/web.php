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
    return view('welcome');
});

Route::group([ 'middleware' => 'auth'], function () {
Route::resource('posts', 'App\Http\Controllers\PostsController');

Route::post('save-comment','App\Http\Controllers\PostsController@save_comment');

// Like Or Dislike
Route::post('save-likedislike','App\Http\Controllers\PostsController@save_likedislike');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
