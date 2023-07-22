<?php

namespace App\Repository;

use App\Models\Collection;
use App\Repository\IRepository\ICollectionRepository;

class CollectionRepository implements ICollectionRepository
{

  public function getAll($paginate = 0) {
    return Collection::paginate($paginate);
  }

  public function getById($id) {
    return Collection::find($id);
  }

  public function add($attributes = []) {
    return Collection::create($attributes);
  }

  public function update($author = null, $attributes = []) {
    return $author->update($attributes);
  }

  public function find($expressions = [], $paginate = 0) {
    return Collection::where($expressions)->paginate($paginate);
  }

  public function sort($sortBy, $paginate = 0) {
    $authors = [];

    switch ($sortBy) {
      case 'bookDescending':
        $authors = Collection::all()->sortByDesc(fn ($author) => $author->books->count(), SORT_NUMERIC)->paginate($paginate);
        break;

      case 'bookAscending':
        $authors = Collection::all()->sortBy(fn ($author) => $author->books->count(), SORT_NUMERIC)->paginate($paginate);
        break;
    }

    return $authors;
  }

  public function delete($author) {
    return $author->delete();
  }

  public function deleteBook($collection, $book) {

  }
}
