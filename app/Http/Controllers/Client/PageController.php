<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\CollectionRepository;
use App\Repository\FileTypeRepository;
use App\Repository\GenreRepository;
use App\Repository\PublisherRepository;
use App\Repository\QuoteRepository;

class PageController extends Controller
{
  private $bookRepository;
  private $genreRepository;
  private $authorRepository;
  private $publisherRepository;
  private $quoteRepository;
  private $collectionRepository;
  private $fileTypeRepository;

  public function __construct(
    BookRepository $bookRepository,
    GenreRepository $genreRepository,
    AuthorRepository $authorRepository,
    PublisherRepository $publisherRepository,
    QuoteRepository $quoteRepository,
    CollectionRepository $collectionRepository,
    FileTypeRepository $fileTypeRepository
  ) {
    $this->bookRepository = $bookRepository;
    $this->genreRepository = $genreRepository;
    $this->publisherRepository = $publisherRepository;
    $this->authorRepository = $authorRepository;
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

  public function booksByGenre(string $slug) {
    try {
      $genres = $this->genreRepository->getAll();
  
      $genre = $this->genreRepository->find([['slug', '=', $slug]])->first();
  
      $books = $this->bookRepository->getByGenre($genre->id)->paginate(2);
      
      $pageTitle = $genre->name;

      return view('client.collection', compact([
        'genres',
        'books',
        'pageTitle'
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'lỗi hệ thống vui lòng thử lại sau');
    }
  }
   
  public function booksByAuthor(string $slug) {
    try {
      $genres = $this->genreRepository->getAll();
  
      $author = $this->authorRepository->find([['slug', '=', $slug]])->first();
  
      $books = $this->bookRepository->getByAuthor($author->id)->paginate(2);
      
      $pageTitle = $author->name;
  
      return view('client.collection', compact([
        'genres',
        'author',
        'books',
        'pageTitle'
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'lỗi hệ thống vui lòng thử lại sau');
    }
  }

  public function booksByPublisher(string $slug) {
    $genres = $this->genreRepository->getAll();

    $publisher = $this->publisherRepository->find([['slug', '=', $slug]])->first();

    $books = $this->bookRepository->getByPublisher($publisher->id)->paginate(2);
    
    $pageTitle = $publisher->name;

    return view('client.collection', compact([
      'genres',
      'books',
      'pageTitle'
    ]));
    try {

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'lỗi hệ thống vui lòng thử lại sau');
    }
  }
}
