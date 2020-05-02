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

Route::prefix('forumlog')->group(function () {
    Route::get('', 'Home@index');
    Route::get('about', 'Home@about');
    Route::get('forum', 'Home@forum');
    Route::get('blog', 'Home@blog');
    Route::post('contact', 'Home@contact');
});

Route::prefix('forumlog/user')->group(function () {
    Route::match(['get','post'],'register', 'User@register');
    Route::post('login', 'User@login');
    Route::match(['get', 'post'], 'recover/{token?}', 'User@recover');
    Route::get('blog/{tagname?}', 'User@blog');
    Route::get('logout', 'User@logout');
});