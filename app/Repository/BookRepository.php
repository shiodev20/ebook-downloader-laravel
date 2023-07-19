<?php

namespace App\Repository;

use App\Models\Book;
use App\Models\BookFile;
use App\Models\BookGenre;
use App\Models\FileType;
use App\Repository\IRepository\IBookRepository;
use App\Utils\GenerateId;
use Exception;
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
      $book = new Book;

      $bookId = GenerateId::generateId('', 8);

      while (true) {
        if ($this->getById($bookId)) $bookId = GenerateId::generateId('', 8);
        else break;
      }

      $book->id = $bookId;
      $book->title = ucwords($attributes['title']);
      $book->num_pages = $attributes['numPages'];
      $book->author_id = $attributes['author'];
      $book->publisher_id = $attributes['publisher'];
      $book->description = $attributes['description'];

      // $data = [
      //   'id' => $bookId,
      //   'title' => ucwords($attributes['title']),
      //   'num_pages' => $attributes['numPages'],
      //   'author_id' => $attributes['author'],
      //   'publisher_id' => $attributes['publisher'],
      //   'description' => $attributes['description'],
      // ];
    
      // Add Book Cover
      $book->slug = Str::slug($book->title);

      $bookCoverUrl = $book->slug . '-' . time() . '.' . $attributes['cover']->extension();

      $book->cover_url = 'bookCovers/' . $bookCoverUrl;
      
      Storage::disk('public')->putFileAs('bookCovers', $attributes['cover'], $bookCoverUrl);
      array_push($fileStored, $book['cover_url']);

      // Storage::disk('public')->put('bookCovers/'.$bookCoverUrl, $attributes['cover']);

      // Add book genre
      if (isset($attributes['genres'])) {
        foreach ($attributes['genres'] as $genre) {
          BookGenre::create(['book_id' => $book->id, 'genre_id' => $genre]);
        }
      }
  
      // Add Book Files
      $fileTypes = FileType::all();
      foreach ($fileTypes as $fileType) {
        if (isset($attributes[$fileType->name])) {
          $bookFileUrl = $fileType->name . '/' . $book->slug . '-' . time() . '.' . $attributes[$fileType->name]->extension();
          array_push($fileStored, $bookFileUrl);

          BookFile::create([
            'book_id' => $bookId,
            'file_type_id' => $fileType->id,
            'file_url' => 'files/'.$bookFileUrl
          ]);
  
          Storage::put('files/'.$bookFileUrl, $attributes[$fileType->name]);
        }
      }
  
      $book->save();

      DB::commit();
      
      return true;

    } catch (\Throwable $th) {
      dd($th);
      DB::rollBack();

      foreach ($fileStored as $file) {
        Storage::delete($file);
      }

      return false;
    }

  }

  public function update($book = null, $attributes = null) {
    
    $data = [];

    $fileStored = [];
    $fileDeleted = [];

    $storedCoverUrl = '';
    $deletedCoverUrl = '';

    try {
      if($book->slug != Str::slug($attributes['title'])) {
        $data['title'] = ucwords($attributes['title']);
        $data['slug'] = Str::slug($attributes['title']);
      }

      if($book->num_pages != $attributes['numPages']) $data['num_pages'] = $attributes['numPages'];
      if($book->author_id != $attributes['author']) $data['author_id'] = $attributes['author'];
      if($book->publisher_id != $attributes['publisher']) $data['publisher_id'] = $attributes['publisher'];

      if(isset($attributes['cover'])) {
        $currentBookUrl = $book->cover_url;

        $data['cover_url'] = isset($data['slug'])
          ? 'bookCovers/' . $data['slug'] . '-' . time() . '.' . $attributes['cover']->extension()
          : 'bookCovers/' . $book->slug . '-' . time() . '.' . $attributes['cover']->extension();

        // $storedCover = $data['cover_url'];
        // $deletedCover = 'deletedFiles/'.basename($currentBookUrl);

        Storage::disk('public')->putFileAs('bookCovers/', $attributes['cover'], basename($data['cover_url']));

        $storedCoverUrl = $data['cover_url'];
        $deletedCoverUrl = 'deletedFiles/'.basename($currentBookUrl);

        $deleteBookCover = Storage::disk('public')->get($currentBookUrl);
        Storage::put('deletedFiles/'.basename($currentBookUrl) , $deleteBookCover);
        Storage::disk('public')->delete($currentBookUrl);
      }
      
      throw new Exception("Error Processing Request", 1);
      
      $book->update($data);

      return true;

    } catch (\Throwable $th) {
      $reliveBookCover = Storage::get('deletedFile/'.$deletedCoverUrl);
      
      Storage::disk('public')->putFileAs('bookCovers', $reliveBookCover, basename($deletedCoverUrl));
      Storage::delete($deletedCoverUrl);
      Storage::disk('public')->delete($storedCoverUrl);

      return false;
    }

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
