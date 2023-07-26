<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Repository\BookRepository;
use App\Repository\FileTypeRepository;
use App\Repository\GenreRepository;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

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

    return view('client.detail', compact([
      'book',
      'genres',
      'fileTypes'
    ]));
  }
}
