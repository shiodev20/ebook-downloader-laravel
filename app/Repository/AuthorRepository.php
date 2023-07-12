<?php

namespace App\Repository;

use App\Models\Author;

class AuthorRepository implements IRepository {

  public function getAll($paginate = 0) {
    return Author::paginate($paginate);
  }

  public function getById($id) {
    return Author::find($id);
  }

  public function find($expressions = [], $paginate = 0) {
    return Author::where($expressions)->paginate($paginate);
  }

  public function add($attributes = []) {
    return Author::create($attributes);
  }

  public function update($genre = null, $attributes = []) {
    return $genre->update($attributes);
  }

  public function sort($sortBy, $paginate = 0) {

    $genres = [];

    switch ($sortBy) {
      case 'bookDescending':
        $genres = Author::orderBy('book_count', 'desc')->paginate($paginate);
        break;

      case 'bookAscending':
        $genres = Author::orderBy('book_count', 'asc')->paginate($paginate);
        break;
    }

    return $genres;
  }

  public function delete($genre) {

    return $genre->delete();

  }
}