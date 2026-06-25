<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Models\Post;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test', [
        'posts' => Post::all()
    ]);
})->name('test');

Route::get('/create', [PostController::class, 'create'])->name('create');
Route::post('/store', [PostController::class, 'ourstore'])->name('store');
Route::get('/edit/{id}', [PostController::class, 'editdata'])->name('edit');
Route::post('/update/{id}', [PostController::class, 'updatedata'])->name('update');
Route::get('/delete/{id}', [PostController::class, 'deletedata'])->name('delete');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
