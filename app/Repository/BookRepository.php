<?php

namespace App\Repository;

use App\Models\Book;
use App\Repository\IRepository\IBookRepository;

class BookRepository implements IBookRepository {
  public function getAll($paginate = 0)
  {
    return Book::paginate($paginate);
  }

  public function getById($id)
  {
    return Book::find($id);
  }

  public function add($attributes = [])
  {
    return Book::create($attributes);
  }

  public function update($author = null, $attributes = [])
  {
    return $author->update($attributes);
  }

  public function find($expressions = [], $paginate = 0)
  {
    return Book::where($expressions)->paginate($paginate);
  }

  public function sort($sortBy, $paginate = 0)
  {
    $authors = [];

    switch ($sortBy) {
      case 'bookDescending':
        $authors = Book::all()->sortByDesc(fn ($author) => $author->books->count(), SORT_NUMERIC)->paginate($paginate);
        break;

      case 'bookAscending':
        $authors = Book::all()->sortBy(fn ($author) => $author->books->count(), SORT_NUMERIC)->paginate($paginate);
        break;
    }

    return $authors;
  }

  public function delete($author)
  {
    return $author->delete();
  }
}