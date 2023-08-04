<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Client\PageController;
use App\Http\Controllers\Client\ReviewController;
use App\Http\Controllers\DownloadController;
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
Route::post('/register', [RegisterController::class, 'index'])->name('auth.register');
Route::get('/logout', [LogoutController::class, 'index'])->name('auth.logout');


Route::get('/forgot-password', [ResetPasswordController::class, 'passwordResetRequest'])->name('password.request');
Route::post('/forgot-password', [ResetPasswordController::class, 'passwordResetSendEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'passwordReset'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'passwordUpdate'])->name('password.update');


Route::get('/', [PageController::class, 'home'])->name('client.home');
Route::get('/book/{slug}', [PageController::class, 'detail'])->name('client.detail');


Route::get('/mostDownload', [AjaxController::class, 'mostDownloadBook'])->name('ajax.mostDownloadBook');
Route::get('/mostDownloadGenre', [AjaxController::class, 'mostDownloadGenre'])->name('ajax.mostDownloadGenre');
Route::get('/mostLoved', [AjaxController::class, 'mostLovedBook'])->name('ajax.mostLovedBook');
Route::get('/mostLovedGenre', [AjaxController::class, 'mostLovedGenre'])->name('ajax.mostLovedGenre');
Route::get('bookSearch', [AjaxController::class, 'bookSearch'])->name('ajax.bookSearch');
Route::get('{book}/reviews', [AjaxController::class, 'bookReviews'])->name('ajax.bookReviews');
Route::get('reviews/{review}', [AjaxController::class, 'reviewById'])->name('ajax.reviewById');


Route::post('/reviews/{book}', [ReviewController::class, 'store'])->name('reviews.store');
Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');


Route::prefix('page')->group(function() {
  Route::get('/tuyen-tap-hay', [PageController::class, 'collections'])->name('client.collections');

  Route::get('/genres/{slug}', [PageController::class, 'booksByGenre'])->name('client.booksByGenre');
  Route::get('/authors/{slug}', [PageController::class, 'booksByAuthor'])->name('client.booksByAuthor');
  Route::get('/publishers/{slug}', [PageController::class, 'booksByPublisher'])->name('client.booksByPublisher');

  Route::prefix('collections')->group(function() {
    Route::get('{slug}', [PageController::class, 'booksByCollection'])->name('client.booksByCollection');
  });
});


Route::prefix('admin')->group(function() {

  Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
  
  Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
  Route::get('/books/sort', [BookController::class, 'sort'])->name('books.sort');
  Route::get('/books/sortStatus', [BookController::class, 'sortStatus'])->name('books.sortStatus');
  Route::put('/books/{book}/sortStatus', [BookController::class, 'updateStatus'])->name('books.updateStatus');
  Route::get('/books/{book}/deleteFile/{fileType}', [BookController::class, 'deleteFile'])->name('books.deleteFile');
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

  Route::get('/developing', function() {
    return view('admin.developing');
  })->middleware(['auth', 'admin'])->name('admin.developing');

});


Route::get('/downloads/{book}', [DownloadController::class, 'index'])->name('downloads.index');


