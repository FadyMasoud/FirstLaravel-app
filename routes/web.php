<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userr;


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

Route::get('ID/{id}', function ($id) {
    echo  $id;
});
Route::get('user/{name?}', function ($name = 'test name') {
    echo  $name;
});
Route::get('user/{name?}/{age?}', function ($name = 'test name', $age
= 0) {
    echo  $name . '-' . $age;
});
Route::get('AgeRoute', function () {
    echo '<br> Called page <br>';
})->middleware('age:13');

Route::resource('age', userr::class);
Route::resource('posts', PostController::class);
Route::resource('posts.comments', CommentController::class)->shallow();
Route::patch('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
Route::resource('comments', CommentController::class)->shallow();
// Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');






Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
