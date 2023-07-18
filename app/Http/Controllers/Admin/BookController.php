<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\FileTypeRepository;
use App\Repository\GenreRepository;
use App\Repository\PublisherRepository;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
  private $bookRepository;
  private $publisherRepository;
  private $authorRepository;
  private $genreRepository;
  private $fileTypeRepository;

  private $pagination = 15;

  public function __construct(
    BookRepository $bookRepository, 
    PublisherRepository $publisherRepository, 
    AuthorRepository $authorRepository,
    GenreRepository $genreRepository,
    FileTypeRepository $fileTypeRepository
  )
  {
    $this->middleware(['auth', 'admin']);
    $this->bookRepository = $bookRepository;
    $this->publisherRepository = $publisherRepository;
    $this->authorRepository = $authorRepository;
    $this->genreRepository = $genreRepository;
    $this->fileTypeRepository = $fileTypeRepository;
  }

  public function index() {
    $query = ['search' => '', 'sort' => ''];
    $books = $this->bookRepository->getAll($this->pagination);

    return view('admin.books.index', compact([
      'query',
      'books'
    ]));
  }

  public function create() {
    $authors = $this->authorRepository->getAll();
    $publishers = $this->publisherRepository->getAll();
    $genres = $this->genreRepository->getAll();
    $fileTypes = $this->fileTypeRepository->getAll();

    return view('admin.books.create', compact([
      'publishers',
      'authors',
      'genres',
      'fileTypes'
    ]));
  }

  public function store(BookRequest $request) {
    $result = $this->bookRepository->add($request->except('_token'));

    if($result) return redirect()->back()->with('successMessage', 'Thêm sách thành công');

    return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
  }

  public function edit(Book $book) {

    $authors = $this->authorRepository->getAll();
    $publishers = $this->publisherRepository->getAll();
    $genres = $this->genreRepository->getAll();
    $fileTypes = $this->fileTypeRepository->getAll();

    // dd(Storage::get($book->bookFiles[0]->file_url));
    // dd(basename($book->bookFiles[0]->file_url));
    
    foreach ($fileTypes as $fileType) {
      if($book->bookFiles->contains($fileType->id)) {

        $filtered = $book->bookFiles->filter(fn ($value, $key) => $value->id == $fileType->id);

        $fileType->url = $filtered->first()->file_url;
        // $fileType->content = Storage::get($filtered->first()->file_url);

      }
    }

    // dd($fileTypes);
    // dd(array_pad(explode('/', $fileTypes[0]->url), 2, null));

    return view('admin.books.edit', compact([
      'book',
      'publishers',
      'authors',
      'genres',
      'fileTypes'
    ]));

  }

  public function search() {}

  public function sort() {}
}
