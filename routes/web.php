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

Route::get('/', 'HomeController@index');
Route::get('about', 'AboutController@index');
Route::get('forum', 'ForumController@index');
Route::get('blog/{tagname?}', 'BlogController@index');
Route::post('contact', 'ContactController@index');

Route::prefix('user')->group(function () {
    Route::match(['get','post'],'register', 'UserController@register');
    Route::post('login', 'UserController@login');
    Route::match(['get', 'post'], 'recover/{token?}', 'UserController@recover');
    Route::get('blog/{tagname?}', 'BlogController@blog');
    Route::get('logout', 'UserController@logout');
});