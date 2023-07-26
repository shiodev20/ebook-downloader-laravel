<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\DownloadController;
use Illuminate\Http\Request;
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
Route::get('/mostDownload', [HomeController::class, 'mostDownloadBook'])->name('client.mostDownloadBook');


Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
Route::get('/books/sort', [BookController::class, 'sort'])->name('books.sort');
Route::get('/books/sortStatus', [BookController::class, 'sortStatus'])->name('books.sortStatus');
Route::put('/books/{book}/sortStatus', [BookController::class, 'updateStatus'])->name('books.updateStatus');
Route::resource('books', BookController::class);

Route::get('/genres/search', [GenreController::class, 'search'])->name('genres.search');
Route::get('/genres/sort', [GenreController::class, 'sort'])->name('genres.sort');
Route::delete('/genres/{genre}/books/{book}/delete', [GenreController::class, 'deleteBook'])->name('genres.deleteBook');
Route::resource('genres', GenreController::class);

Route::get('/authors/search', [AuthorController::class, 'search'])->name('authors.search');
Route::get('/authors/sort', [AuthorController::class, 'sort'])->name('authors.sort');
Route::delete('/authors/{author}/books/{book}/delete', [AuthorController::class, 'deleteBook'])->name('authors.deleteBook');
Route::resource('authors', AuthorController::class);

Route::get('/publishers/search', [PublisherController::class, 'search'])->name('publishers.search');
Route::get('/publishers/sort', [PublisherController::class, 'sort'])->name('publishers.sort');
Route::delete('/publishers/{publisher}/books/{book}/delete', [PublisherController::class, 'deleteBook'])->name('publishers.deleteBook');
Route::resource('publishers', PublisherController::class);

Route::get('/collections/search', [CollectionController::class, 'search'])->name('collections.search');
Route::delete('/collections/{collection}/books/{book}/delete', [CollectionController::class, 'deleteBook'])->name('collections.deleteBook');
Route::get('/collections/sort', [CollectionController::class, 'sort'])->name('collections.sort');
Route::resource('collections', CollectionController::class);

Route::get('/quotes/search', [QuoteController::class, 'search'])->name('quotes.search');
Route::resource('quotes', QuoteController::class);


Route::get('/banners/search', [BannerController::class, 'search'])->name('banners.search');
Route::get('/banners/sort', [BannerController::class, 'sort'])->name('banners.sort');
Route::resource('banners', BannerController::class);


Route::get('/downloads/{book}', [DownloadController::class, 'index'])->name('downloads.index');

Route::get('/developing', function() {
  return view('admin.developing');
})->middleware(['auth', 'admin'])->name('admin.developing');

