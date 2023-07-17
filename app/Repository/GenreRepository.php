<?php

namespace App\Repository;

use App\Models\Genre;
use App\Repository\IRepository\IGenreRepository;

class GenreRepository implements IGenreRepository
{

  public function getAll($paginate = 0) {
    return Genre::paginate($paginate);
  }

  public function getById($id) {
    return Genre::find($id);
  }

  public function add($attributes = []) {
    return Genre::create($attributes);
  }

  public function update($genre = null, $attributes = []) {
    return $genre->update($attributes);
  }

  public function delete($genre) {
    return $genre->delete();
  }

  public function sort($sortBy, $paginate = 0) {

    $genres = [];

    switch ($sortBy) {
      case 'bookDescending':
        $genres = Genre::all()->sortByDesc(fn ($genre) => $genre->books->count(), SORT_NUMERIC)->paginate($paginate);

        break;

      case 'bookAscending':
        $genres = Genre::all()->sortBy(fn ($genre) => $genre->books->count(), SORT_NUMERIC)->paginate($paginate);
        break;
    }

    return $genres;
  }

  public function find($expressions = [], $paginate = 0) {
    return Genre::where($expressions)->paginate($paginate);
  }
  
}
