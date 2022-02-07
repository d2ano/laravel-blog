<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Models\Comment;
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




//home, list all
Route::get('/' , [ PostController::class , 'index' ])->name('home')->middleware('auth');

//post resource
Route::get('post/{post}/delete' ,[ PostController::class , 'delete' ])->name('post.delete')->middleware('auth');
Route::get('post/{post}/user' ,[ PostController::class , 'user' ])->name('post.user')->middleware('auth');
Route::resource('post' , PostController::class)->except('index')->middleware('auth');

//tag resource
Route::resource('tag' , TagController::class)->only(['index' , 'show'])->middleware('auth');
//user resource
Route::resource('user' , UserController::class)->except(['index' , 'destroy' , 'create' , 'store'])->middleware('auth');
//comment resource
Route::resource('comment' , CommentController::class)->only(['store' , 'destroy' , 'show'])->middleware('auth');



// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');
