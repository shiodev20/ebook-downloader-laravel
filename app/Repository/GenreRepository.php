<?php

namespace App\Repository;

use App\Models\BookGenre;
use App\Models\Genre;
use App\Repository\IRepository\IGenreRepository;
use Illuminate\Support\Facades\DB;

class GenreRepository implements IGenreRepository
{

  public function getAll() {
    return Genre::all();
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

    DB::beginTransaction();
    try {

      BookGenre::where('genre_id', '=', $genre->id)->delete();
      $genre->delete();

      DB::commit();
      
      return true;

    } catch (\Throwable $th) {
      DB::rollBack();

      return false;
    }
  }


  public function deleteBook($genre, $book) {

    $result = false;

    $bookGenre = BookGenre::where([
      ['genre_id', '=', $genre->id],
      ['book_id', '=', $book->id]
    ])->first();

    $result = $bookGenre->delete();

    return $result;

  }


  public function sort($sortBy) {

    $genres = [];

    switch ($sortBy) {
      case 'bookDescending':
        $genres = Genre::all()->sortByDesc(fn ($genre) => $genre->books->count(), SORT_NUMERIC)->values();
        break;
      case 'bookAscending':
        $genres = Genre::all()->sortBy(fn ($genre) => $genre->books->count(), SORT_NUMERIC)->values();
        break;
    }

    return $genres;
  }


  public function find($expressions = []) {
    return Genre::where($expressions)->get();
  }
  
}
