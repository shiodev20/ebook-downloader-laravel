<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\CollectionRepository;
use App\Repository\FileTypeRepository;
use App\Repository\GenreRepository;
use App\Repository\PublisherRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
  private $bookRepository;
  private $publisherRepository;
  private $authorRepository;
  private $genreRepository;
  private $fileTypeRepository;
  private $collectionRepository;

  private $pagination = 15;

  public function __construct(
    BookRepository $bookRepository, 
    PublisherRepository $publisherRepository, 
    AuthorRepository $authorRepository,
    GenreRepository $genreRepository,
    FileTypeRepository $fileTypeRepository,
    CollectionRepository $collectionRepository
  )
  {
    $this->middleware(['auth', 'admin']);
    $this->bookRepository = $bookRepository;
    $this->publisherRepository = $publisherRepository;
    $this->authorRepository = $authorRepository;
    $this->genreRepository = $genreRepository;
    $this->fileTypeRepository = $fileTypeRepository;
    $this->collectionRepository = $collectionRepository;
  }

  public function index() {
    try {
      $query = ['search' => '', 'sort' => ['download' => '', 'rating' => '']];
      $books = $this->bookRepository->getAll($this->pagination);
  
      return view('admin.books.index', compact([
        'query',
        'books'
      ]));

    } catch (\Throwable $th) {
      return redirect()->route('admin.dashboard')->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  public function create() {
    $authors = $this->authorRepository->getAll();
    $publishers = $this->publisherRepository->getAll();
    $genres = $this->genreRepository->getAll();
    $fileTypes = $this->fileTypeRepository->getAll();
    $collections = $this->collectionRepository->getAll();

    // dd($collections);

    return view('admin.books.create', compact([
      'publishers',
      'authors',
      'genres',
      'fileTypes',
      'collections'
    ]));
  }

  public function store(BookRequest $request) {
    $createdBook = $this->bookRepository->add($request->except('_token'));


    if($createdBook) return redirect()->route('books.edit', ['book' => $createdBook->id])->with('successMessage', 'Thêm sách thành công');

    return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
  }

  public function edit(Book $book) {

    $authors = $this->authorRepository->getAll();
    $publishers = $this->publisherRepository->getAll();
    $genres = $this->genreRepository->getAll();
    $fileTypes = $this->fileTypeRepository->getAll();
    $collections = $this->collectionRepository->getAll();

    $book->cover_content = Storage::disk('public')->get($book->cover_url);

    foreach ($fileTypes as $fileType) {
      $filtered = $book->bookFiles->where('file_type_id', $fileType->id)->first();

      if($filtered) {
        $fileType->url = $filtered->file_url;
        $fileType->file_name = basename($filtered->file_url);
        $fileType->content = Storage::get($filtered->file_url);
      }
    }

    return view('admin.books.edit', compact([
      'book',
      'publishers',
      'authors',
      'genres',
      'fileTypes',
      'collections'
    ]));

  }

  public function update(BookRequest $request, Book $book) {
    
    $updatedBook = $this->bookRepository->update($book, $request->except(['_token', '_method']));

    if($updatedBook) return redirect()->back()->with('successMessage', 'Cập nhật sách ' . $updatedBook->id . ' thành công');

    return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
  }

  public function search(Request $request) {
    $query = [
      'search' => '',
      'sort' => [
        'rating' => $request->ratingSort,
        'download' => $request->downloadSort
      ]
    ];
    
    $query['search'] = $request->query('search');

    try {
      $books = $this->bookRepository->find([
        ['title', 'like', '%' . $query['search'] . '%'],
      ], $this->pagination);

      return view('admin.books.index', compact([
        'books',
        'query'
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }

  }

  public function sort(Request $request) {
    $query = [
      'search' => '',
      'sort' => [
        'rating' => $request->ratingSort,
        'download' => $request->downloadSort
      ]
    ];

    try {
      $books = $this->bookRepository->sort($query['sort'], $this->pagination);
      
      return view('admin.books.index', compact([
        'books',
        'query'
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  public function sortStatus(Request $request) {
    $query = [
      'search' => '',
      'sort' => [
        'rating' => '',
        'download' => ''
      ]
    ];

    try {
      $books = $this->bookRepository->sortStatus($request->sortBy, $this->pagination);
      
      return view('admin.books.index', compact([
        'books',
        'query'
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  public function updateStatus(Request $request, Book $book) {
    try {
      $result = $this->bookRepository->updateStatus($book);

      
      if($result) return redirect()->back()->with('successMessage', 'Cập nhật sách ' . $book->id . ' thành công');
      else return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }
}