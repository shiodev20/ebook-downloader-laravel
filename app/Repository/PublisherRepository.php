<?php

namespace App\Repository;

use App\Models\Publisher;
use App\Repository\IRepository\IPublisherRepository;

class PublisherRepository implements IPublisherRepository
{

  public function getAll($paginate = 0) {
    return Publisher::paginate($paginate);
  }

  public function getById($id) {
    return Publisher::find($id);
  }

  public function add($attributes = []) {
    return Publisher::create($attributes);
  }

  public function update($publisher = null, $attributes = []) {
    return $publisher->update($attributes);
  }

  public function find($expressions = [], $paginate = 0) {
    return Publisher::where($expressions)->paginate($paginate);
  }

  public function sort($sortBy, $paginate = 0) {
    $publishers = [];

    switch ($sortBy) {
      case 'bookDescending':
        $publishers = Publisher::all()->sortByDesc(fn ($publisher) => $publisher->books->count(), SORT_NUMERIC)->paginate($paginate);
        break;

      case 'bookAscending':
        $publishers = Publisher::all()->sortBy(fn ($publisher) => $publisher->books->count(), SORT_NUMERIC)->paginate($paginate);
        break;
    }

    return $publishers;
  }

  public function delete($publisher) {
    return $publisher->delete();
  }
}
