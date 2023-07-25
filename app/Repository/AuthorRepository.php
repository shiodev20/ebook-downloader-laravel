<?php

namespace App\Repository;

use App\Models\Author;
use App\Models\Book;
use App\Repository\IRepository\IAuthorRepository;
use Illuminate\Support\Facades\DB;

class AuthorRepository implements IAuthorRepository
{

  public function getAll($paginate = 0) {
    return Author::paginate($paginate);
  }

  public function getById($id) {
    return Author::find($id);
  }

  public function add($attributes = []) {
    return Author::create($attributes);
  }

  public function update($author = null, $attributes = []) {
    return $author->update($attributes);
  }

  public function find($expressions = [], $paginate = 0) {
    return Author::where($expressions)->paginate($paginate);
  }

  public function sort($sortBy, $paginate = 0) {
    $authors = [];

    switch ($sortBy) {
      case 'bookDescending':
        $authors = Author::all()->sortByDesc(fn ($author) => $author->books->count(), SORT_NUMERIC)->paginate($paginate);
        break;

      case 'bookAscending':
        $authors = Author::all()->sortBy(fn ($author) => $author->books->count(), SORT_NUMERIC)->paginate($paginate);
        break;
    }

    return $authors;
  }

  public function delete($author) {

    DB::beginTransaction();
    try {

      Book::where('author_id', '=', $author->id)->update([ 'author_id' => null ]);
      $author->delete();

      DB::commit();
      
      return true;

    } catch (\Throwable $th) {
      DB::rollBack();

      return false;
    }

  }

  public function deleteBook($author, $book) {

    $result = false;

    if($author->id == $book->author_id) {
      $result = $book->update(['author_id' => null]);
    }

    return $result;

  }
}
