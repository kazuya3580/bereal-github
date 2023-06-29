<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/', function () {
//     return view('login');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::post('/posts', [PostController::class, 'store']);
Route::get('/posts/{post}/edit', [App\Http\Controllers\PostController::class, 'edit'])->name('posts.edit');
Route::put('/posts/{post}', [App\Http\Controllers\PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
Route::post('/post/{post}/like', [PostController::class, 'like'])->name('post.like');
Route::delete('/post/{post}/like', [PostController::class, 'unlike'])->name('post.unlike');
Route::post('/posts/{post}/favorite', [PostController::class, 'favorite'])->name('posts.favorite');
Route::delete('/posts/{post}/unfavorite', [PostController::class, 'unfavorite'])->name('posts.unfavorite');
Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
// プロフィール
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');

