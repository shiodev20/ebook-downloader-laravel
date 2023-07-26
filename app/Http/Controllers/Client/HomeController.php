<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repository\BookRepository;
use App\Repository\CollectionRepository;
use App\Repository\GenreRepository;
use App\Repository\QuoteRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  private $bookRepository;
  private $genreRepository;
  private $quoteRepository;
  private $collectionRepository;

  public function __construct(
    BookRepository $bookRepository,
    GenreRepository $genreRepository,
    QuoteRepository $quoteRepository,
    CollectionRepository $collectionRepository
  ) {
    $this->bookRepository = $bookRepository;
    $this->genreRepository = $genreRepository;
    $this->quoteRepository = $quoteRepository;
    $this->collectionRepository = $collectionRepository;
  }

  public function index() {
    try {
      $genres = $this->genreRepository->getAll();
      $quotes = $this->quoteRepository->getAll();

      $newestBooks = $this->bookRepository->getAll(12);
      $mostDownloadBooks = $this->bookRepository->getMostDownloadBooks(12);
      $recommendBooks = $this->bookRepository->getrecommendBooks(12);
      $collections = $this->collectionRepository->getAll(9);

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
  
  public function mostDownloadBook(Request $request) {
    try {
      $books = [];

      if($request->query('genre')) {
        $books = $this->bookRepository->getMostDownloadBooks(12, $request->query('genre'));
      }
      else {
        $books = $this->bookRepository->getMostDownloadBooks(12);
      }

      $books = $books->map(function($book, $key) {
        $temp = $book;

        $temp->author_name = $book->author->name;
        $temp->files = $book->files;

        return $temp;
      });

      return [
        'status' => true,
        'result' => [
          'books' => $books,
        ],
      ];

    } catch (\Throwable $th) {
      return [
        'status' => false,
      ];
    }
  }
}
