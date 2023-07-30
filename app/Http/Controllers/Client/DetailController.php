<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Repository\BookRepository;
use App\Repository\FileTypeRepository;
use App\Repository\GenreRepository;
use Illuminate\Http\Request;

class DetailController extends Controller
{
  private $bookRepository;
  private $genreRepository;
  private $fileTypeRepository;

  public function __construct(
    BookRepository $bookRepository, 
    GenreRepository $genreRepository, 
    FileTypeRepository $fileTypeRepository
  ) {
    $this->bookRepository = $bookRepository;
    $this->genreRepository = $genreRepository;
    $this->fileTypeRepository = $fileTypeRepository;
  }

  public function index(Request $request, string $slug) {
    $book = $this->bookRepository->find([ ['slug', '=', $slug] ])->first();

    $genres = $this->genreRepository->getAll();
    $fileTypes = $this->fileTypeRepository->getAll();

    $sameAuthorBooks = $this->bookRepository->find([
      ['author_id', '=', $book->author_id],
      ['id', '<>', $book->id]
    ])->paginate(12);

    $sameGenreBooks = $this->bookRepository->getSameGenreBooks($book)->paginate(12);
    $recommendBooks = $this->bookRepository->getAll()->random(2);

    $reviews = $book->reviews->paginate(15);

    return view('client.detail', compact([
      'book',
      'genres',
      'fileTypes',
      'sameAuthorBooks',
      'sameGenreBooks',
      'recommendBooks',
      'reviews'
    ]));
  }
}
