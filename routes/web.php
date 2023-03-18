<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [App\Http\Controllers\CalenderController::class, 'index'])->name('home');
Route::post('/', [App\Http\Controllers\CalenderController::class, 'post'])->name('post');
Route::delete('/', [App\Http\Controllers\CalenderController::class, 'destroy'])->name('delete');
Route::get('/dashboard', [App\Http\Controllers\CalenderController::class, 'show'])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/dashboard', [App\Http\Controllers\CalenderController::class, 'store'])->name('dashboard.store');
Route::get('/timeline', [App\Http\Controllers\CalenderController::class, 'timeline'])->name('timeline');
Route::post('/timeline', [App\Http\Controllers\LikeController::class, 'like'])->name('like');
Route::delete('/timeline', [App\Http\Controllers\LikeController::class, 'unlike'])->name('like.destroy');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/login/google', [App\Http\Controllers\LoginController::class, 'redirectToGoogle']);
Route::get('/login/google/callback', [App\Http\Controllers\LoginController::class, 'handleGoogleCallback']);
Route::get('login/facebook', [App\Http\Controllers\LoginController::class, 'redirectToProvider']);
Route::get('login/facebook/callback', [App\Http\Controllers\LoginController::class, 'handleProviderCallback']);

require __DIR__.'/auth.php';
