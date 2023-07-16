<?php

namespace App\Repository;

use App\Models\Book;
use App\Repository\IRepository\IBookRepository;

class BookRepository implements IBookRepository {

  public function getAll($paginate = 0) {
    return Book::paginate($paginate);
  }

  public function getById($id) {
    return Book::find($id);
  }

  public function add($attributes = []) {
    return Book::create($attributes);
  }

  public function update($book = null, $attributes = []) {
    return $book->update($attributes);
  }

  public function find($expressions = [], $paginate = 0) {
    return Book::where($expressions)->paginate($paginate);
  }

  public function sort($sortBy, $paginate = 0) {
    $books = [];

    switch ($sortBy) {
      case 'bookDescending':
        $books = Book::all()->sortByDesc(fn ($book) => $book->books->count(), SORT_NUMERIC)->paginate($paginate);
        break;

      case 'bookAscending':
        $books = Book::all()->sortBy(fn ($book) => $book->books->count(), SORT_NUMERIC)->paginate($paginate);
        break;
    }

    return $books;
  }

  public function delete($book) {
    return $book->delete();
  }
}