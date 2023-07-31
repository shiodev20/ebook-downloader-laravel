<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Repository\BookRepository;
use App\Repository\CollectionRepository;
use App\Repository\FileTypeRepository;
use App\Repository\GenreRepository;
use App\Repository\QuoteRepository;

class PageController extends Controller
{
  private $bookRepository;
  private $genreRepository;
  private $quoteRepository;
  private $collectionRepository;
  private $fileTypeRepository;

  public function __construct(
    BookRepository $bookRepository,
    GenreRepository $genreRepository,
    QuoteRepository $quoteRepository,
    CollectionRepository $collectionRepository,
    FileTypeRepository $fileTypeRepository
  ) {
    $this->bookRepository = $bookRepository;
    $this->genreRepository = $genreRepository;
    $this->quoteRepository = $quoteRepository;
    $this->collectionRepository = $collectionRepository;
    $this->fileTypeRepository = $fileTypeRepository;
  }

  public function home() {
    try {
      $genres = $this->genreRepository->getAll();
      $quotes = $this->quoteRepository->getAll();

      $newestBooks = $this->bookRepository->getAll()->paginate(12);
      $mostDownloadBooks = $this->bookRepository->getMostDownloadBooks('all')->paginate(12);
      $recommendBooks = $this->bookRepository->getRecommendBooks()->paginate(12);
      $collections = $this->collectionRepository->getAll()->paginate(9);

      return view('client.home', compact([
        'genres',
        'quotes',
        'newestBooks',
        'mostDownloadBooks',
        'recommendBooks',
        'collections',
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'lỗi hệ thống vui lòng thử lại sau');
    }
  }

  public function detail(string $slug) {
    
    try {
      $book = $this->bookRepository->find([ ['slug', '=', $slug] ])->first();
  
      $genres = $this->genreRepository->getAll();
      $fileTypes = $this->fileTypeRepository->getAll();
  
      $sameAuthorBooks = $this->bookRepository->find([
        ['author_id', '=', $book->author_id],
        ['id', '<>', $book->id]
      ])->paginate(12);
  
      $sameGenreBooks = $this->bookRepository->getSameGenreBooks($book)->paginate(12);
      $recommendBooks = $this->bookRepository->getAll()->random(2);
  
      // $reviews = $book->reviews->paginate(1);
        
      return view('client.detail', compact([
        'book',
        'genres',
        'fileTypes',
        'sameAuthorBooks',
        'sameGenreBooks',
        'recommendBooks',
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'lỗi hệ thống vui lòng thử lại sau');
    }

  }
}
