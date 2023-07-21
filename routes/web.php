<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\DownloadController;
use App\Utils\UppercaseFirstLetter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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


// $bookCovers = Storage::disk('public')->files('bookCovers');
// $deletedFiles = Storage::files('deletedFiles');
// $epubs = Storage::files('files/EPUB');
// $pdfs = Storage::files('files/PDF');
// $mobis = Storage::files('files/MOBI');
// $awz3s = Storage::files('files/AWZ3');

// Storage::disk('public')->delete($bookCovers);
// Storage::delete($deletedFiles);
// Storage::delete($epubs);
// Storage::delete($pdfs);
// Storage::delete($mobis); 
// Storage::delete($awz3s);


Route::post('/login', [LoginController::class, 'index'])->name('auth.login');
Route::get('/logout', [LogoutController::class, 'index'])->name('auth.logout');

Route::get('/', [HomeController::class, 'index'])->name('client.home');
Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');


Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
Route::get('/books/sort', [BookController::class, 'sort'])->name('books.sort');
Route::get('/books/sortStatus', [BookController::class, 'sortStatus'])->name('books.sortStatus');
Route::put('/books/{book}/sortStatus', [BookController::class, 'updateStatus'])->name('books.updateStatus');
Route::resource('books', BookController::class);

Route::get('/genres/search', [GenreController::class, 'search'])->name('genres.search');
Route::get('/genres/sort', [GenreController::class, 'sort'])->name('genres.sort');
Route::resource('genres', GenreController::class);

Route::get('/authors/search', [AuthorController::class, 'search'])->name('authors.search');
Route::get('/authors/sort', [AuthorController::class, 'sort'])->name('authors.sort');
Route::delete('/authors/{author}/books/{book}/delete', [AuthorController::class, 'deleteBook'])->name('authors.deleteBook');
Route::resource('authors', AuthorController::class);

Route::get('/publishers/search', [PublisherController::class, 'search'])->name('publishers.search');
Route::get('/publishers/sort', [PublisherController::class, 'sort'])->name('publishers.sort');
Route::resource('publishers', PublisherController::class);

Route::get('/downloads/{book}', [DownloadController::class, 'index'])->name('downloads.index');
