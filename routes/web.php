<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::match(['get','post'], '/', 'HomeController@index')->name('home');
Route::get('about', 'AboutController@index')->name('about');
Route::get('forum', 'ForumController@index')->name('forum');
Route::get('blog/{id?}', 'BlogController@index')->name('blog');
Route::post('contact', 'ContactController@index')->name('contact');

Route::prefix('post')->group(function() {
    Route::match(['get','post'],'create', 'BlogController@createpost');
    Route::get('private/{id}', 'BlogController@privatepost');
    Route::get('delete/{id}', 'BlogController@deletepost');
    Route::post('comment', 'BlogController@createcomment');
    Route::get('deletecomment/{id}', 'BlogController@deletecomment');
});

Route::prefix('user')->group(function () {
    Route::match(['get','post'],'register', 'UserController@register');
    Route::post('login', 'UserController@login')->name('login');
    Route::match(['get', 'post'], 'recover/{token?}', 'UserController@recover')->name('password.reset');
    Route::match(['get','post'], 'profile/{tagname?}', 'UserController@profile');
    Route::get('logout', 'UserController@logout');
    Route::get('getusers', 'UserController@getusers');
});
