<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Client\HomeController;
use Illuminate\Support\Facades\Route;
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

Route::post('/login', [LoginController::class, 'index'])->name('auth.login');
Route::get('/logout', [LogoutController::class, 'index'])->name('auth.logout');

Route::get('/', [HomeController::class, 'index'])->name('client.home');
Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');


Route::get('/genres/search', [GenreController::class, 'search'])->name('genres.search');
Route::get('/genres/sort', [GenreController::class, 'sort'])->name('genres.sort');
Route::resource('genres', GenreController::class);

// Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');
// Route::post('/genres', [GenreController::class, 'store'])->name('genres.store');
// Route::put('/genres/{id}', [GenreController::class, 'update'])->name('genres.update');
// Route::delete('/genres/{id}', [GenreController::class, 'destroy'])->name('genres.destroy');