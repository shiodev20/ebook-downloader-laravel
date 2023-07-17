<?php

namespace App\Repository;

use App\Models\Book;
use App\Models\BookFile;
use App\Models\BookGenre;
use App\Models\FileType;
use App\Repository\IRepository\IBookRepository;
use App\Utils\GenerateId;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookRepository implements IBookRepository
{

  public function getAll($paginate = 0) {
    $books = Book::all()->map(function ($book) {
      $temp = $book;
      $coverData = Storage::get($book->cover_url);
      $coverExtension = array_pad(explode('.', $book->cover_url), 2, null);
      

      $temp->cover = 'data:image/' . $coverExtension[1]. ';base64,' . $coverData;

      return $temp;

    })->paginate($paginate);

    return $books;
  }

  public function getById($id) {
    return Book::find($id);
  }

  public function add($attributes = null) {

    $fileStored = [];

    DB::beginTransaction();

    try {
      $bookId = GenerateId::generateId('', 8);

      while (true) {
        if ($this->getById($bookId)) $bookId = GenerateId::generateId('', 8);
        else break;
      }
  
      $book = [
        'id' => $bookId,
        'title' => ucwords($attributes['title']),
        'num_pages' => $attributes['numPages'],
        'author_id' => $attributes['author'],
        'publisher_id' => $attributes['publisher'],
        'description' => $attributes['description'],
      ];
    
      // Add Book Cover
      $bookSlug = Str::slug($book['title']);
      $bookCoverUrl = $bookSlug . '-' . time() . '.' . $attributes['cover']->extension();
      $book['cover_url'] = 'bookCovers/' . $bookCoverUrl;
      Book::create($book);
  
      array_push($fileStored, $book['cover_url']);

      // Storage::disk('public')->put( 'bookCovers',  $attributes['cover']);
      // Storage::disk('public')->put( $book['cover_url'],  $attributes['cover']);
      Storage::disk('public')->putFileAs('bookCovers', $attributes['cover'], $bookCoverUrl);


      // Add book genre
      if (isset($attributes['genres'])) {
        foreach ($attributes['genres'] as $genre) {
          BookGenre::create(['book_id' => $bookId, 'genre_id' => $genre]);
        }
      }
  
  
      // Add Book Files
      $fileTypes = FileType::all();
      foreach ($fileTypes as $fileType) {
        if (isset($attributes[$fileType->name])) {
          $bookFileUrl = $fileType->name . '/' . $bookSlug . '-' . time() . '.' . $attributes[$fileType->name]->extension();
          array_push($fileStored, $bookFileUrl);

          BookFile::create([
            'book_id' => $bookId,
            'file_type_id' => $fileType->id,
            'file_url' => 'files/'.$bookFileUrl
          ]);
  
          Storage::putFileAs('files', $attributes[$fileType->name], $bookFileUrl);
        }
      }
  
      DB::commit();
      
      return true;

    } catch (\Throwable $th) {
      DB::rollBack();

      foreach ($fileStored as $file) {
        Storage::delete($file);
      }

      return false;
    }

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
