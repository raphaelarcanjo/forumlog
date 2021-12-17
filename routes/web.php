<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;

Route::match(['get','post'], '/', [HomeController::class,'index'])->name('home');
Route::get('about', [AboutController::class,'index'])->name('about');
Route::get('forum', [ForumController::class,'index'])->name('forum');
Route::post('contact', [ContactController::class,'index'])->name('contact');

Route::prefix('blog')->group(function() {
    Route::match(['get','post'],'create', [BlogController::class,'create']);
    Route::get('private/{id}', [BlogController::class,'private']);
    Route::get('delete/{id}', [BlogController::class,'delete']);
    Route::post('comment', [BlogController::class,'createComment']);
    Route::get('deletecomment/{id}', [BlogController::class,'deleteComment']);
    Route::get('{username?}', [BlogController::class,'index'])->name('blog');
});

Route::prefix('user')->group(function () {
    Route::match(['get','post'],'register', [UserController::class,'register']);
    Route::post('login', [UserController::class,'login'])->name('login');
    Route::match(['get', 'post'], 'recover/{token?}', [UserController::class,'recover'])->name('password.reset');
    Route::match(['get','post'], 'profile', [UserController::class,'profile']);
    Route::get('logout', [UserController::class,'logout']);
    Route::get('getusers', [UserController::class,'getusers']);
});

Route::prefix('forum')->group(function () {
    Route::match(['get', 'post'],'create', [ForumController::class,'create']);
});
