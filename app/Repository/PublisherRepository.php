<?php

namespace App\Repository;

use App\Models\Book;
use App\Models\Publisher;
use App\Repository\IRepository\IPublisherRepository;
use Illuminate\Support\Facades\DB;

class PublisherRepository implements IPublisherRepository
{

  public function getAll() {
    return Publisher::all();
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

  public function find($expressions = []) {
    return Publisher::where($expressions)->get();
  }

  public function sort($sortBy) {
    $publishers = [];

    switch ($sortBy) {
      case 'bookDescending':
        $publishers = Publisher::all()->sortByDesc(fn ($publisher) => $publisher->books->count(), SORT_NUMERIC)->values();
        break;

      case 'bookAscending':
        $publishers = Publisher::all()->sortBy(fn ($publisher) => $publisher->books->count(), SORT_NUMERIC)->values();
        break;
    }

    return $publishers;
  }

  public function delete($publisher) {

    DB::beginTransaction();

    try {
      Book::where('publisher_id', '=', $publisher->id)->update([ 'publisher_id' => null ]);
      $publisher->delete();
      
      DB::commit();

      return true;

    } catch (\Throwable $th) {
      DB::rollBack();

      return false;
    }
  }

  public function deleteBook($publisher, $book) {

    $result = false;

    if($publisher->id == $book->publisher_id) {
      $result = $book->update(['publisher_id' => null]);
    }

    return $result;

  }
}
