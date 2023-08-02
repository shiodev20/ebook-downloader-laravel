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
use Illuminate\Http\Request;

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
      $quotes = $this->quoteRepository->getAll();
  
      $randomBook = $this->bookRepository->getAll()->random(1)->first();
      $newestBooks = $this->bookRepository->getAll()->paginate(12);
      $mostDownloadBooks = $this->bookRepository->getMostDownloadBooks('all')->paginate(12);
      $recommendBooks = $this->bookRepository->getRecommendBooks()->paginate(12);
      $collections = $this->collectionRepository->getAll()->paginate(9);
  
      return view('client.home', compact([
        'quotes',
        'newestBooks',
        'mostDownloadBooks',
        'recommendBooks',
        'randomBook',
        'collections',
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'lỗi hệ thống vui lòng thử lại sau');
    }
  }

  public function detail(string $slug) {
    
    try {
      $book = $this->bookRepository->find([ ['slug', '=', $slug] ])->first();
      $fileTypes = $this->fileTypeRepository->getAll();
      
      $sameAuthorBooks = $this->bookRepository->find([
        ['author_id', '=', $book->author_id],
        ['id', '<>', $book->id]
      ])->paginate(12);
      $sameGenreBooks = $this->bookRepository->getSameGenreBooks($book)->paginate(12);
      $recommendBooks = $this->bookRepository->getRecommendBooks()->paginate(12);
  
      return view('client.detail', compact([
        'book',
        'fileTypes',
        'sameAuthorBooks',
        'sameGenreBooks',
        'recommendBooks',
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'lỗi hệ thống vui lòng thử lại sau');
    }

  }

  public function collections() {
    try {
      $collections = $this->collectionRepository->getAll()->paginate(9);
  
      return view('client.collections.index', compact([
        'collections'
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'lỗi hệ thống vui lòng thử lại sau');
    }
  }

  public function booksByGenre(string $slug) {
    try {
      $genre = $this->genreRepository->find([['slug', '=', $slug]])->first();
  
      $books = $this->bookRepository->getByGenre($genre->id)->paginate(18);
      
      $pageTitle = $genre->name;

      return view('client.collection', compact([
        'books',
        'pageTitle'
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'lỗi hệ thống vui lòng thử lại sau');
    }
  }
   
  public function booksByAuthor(string $slug) {
    try {
      $author = $this->authorRepository->find([['slug', '=', $slug]])->first();
  
      $books = $this->bookRepository->getByAuthor($author->id)->paginate(18);
      
      $pageTitle = $author->name;
  
      return view('client.collection', compact([
        'author',
        'books',
        'pageTitle'
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'lỗi hệ thống vui lòng thử lại sau');
    }
  }

  public function booksByPublisher(string $slug) {
    try {
      $publisher = $this->publisherRepository->find([['slug', '=', $slug]])->first();
  
      $books = $this->bookRepository->getByPublisher($publisher->id)->paginate(18);
      
      $pageTitle = $publisher->name;
  
      return view('client.collection', compact([
        'books',
        'pageTitle'
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'lỗi hệ thống vui lòng thử lại sau');
    }
  }

  public function booksByCollection(Request $request, string $slug) {
    try {
      $books = [];
      $pageTitle = '';

      switch ($slug) {
        case 'sach-moi-nhat':
          $pageTitle = 'Sách mới nhất';
          $books = $this->bookRepository->getAll()->paginate(18);
          break;

        case 'sach-hay-nen-doc':
          $pageTitle = 'Sách hay nên đọc';
          $books = $this->bookRepository->getRecommendBooks()->paginate(18);
          break;
        
        case 'sach-tai-nhieu-nhat':
          $genre = $request->query('genre');

          $pageTitle = $genre != 'all'
            ? 'Sách tải nhiều nhất / ' . $this->genreRepository->getById($genre)->name
            : 'Sách tải nhiều nhất / tất cả';

          $books = $this->bookRepository->getMostDownloadBooks($genre)->paginate(18);
          break;
        case 'tuyen-tap-hay':
          $collectionSlug = $request->query('collection');
          $collection = $this->collectionRepository->find([[ 'slug',  '=', $collectionSlug ]])->first();

          $books = $collection->books->paginate(18);
          $pageTitle = $collection->name;

          break;
      }

      return view('client.collection', compact([
        'books',
        'pageTitle'
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'lỗi hệ thống vui lòng thử lại sau');
    }
  }

}
