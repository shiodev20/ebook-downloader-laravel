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

      // Add Book Cover
      $book->slug = Str::slug($book->title);
      $book->cover_url = 'bookCovers/' . $book->slug . '-' . time() . '.' . $attributes['cover']->extension();
      
      Storage::disk('public')->put($book->cover_url, file_get_contents($attributes['cover']));
      array_push($fileStored, $book->cover_url);

      $book->save();

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
          $bookFileUrl = 'files/' . $fileType->name . '/' . $book->slug . '-' . time() . '.' . $attributes[$fileType->name]->extension();

          BookFile::create([
            'book_id' => $bookId,
            'file_type_id' => $fileType->id,
            'file_url' => $bookFileUrl
          ]);
  
          Storage::put($bookFileUrl, file_get_contents($attributes[$fileType->name]));

          array_push($fileStored, $bookFileUrl);

        }
      }
  
      DB::commit();
      
      return $book;

    } catch (\Throwable $th) {
      DB::rollBack();

      foreach ($fileStored as $filename) {

        if(in_array(pathinfo($filename, PATHINFO_EXTENSION), ['png', 'jpg'])) Storage::disk('public')->delete($filename);
        else Storage::delete($filename);

      }

      return false;
    }

  }

  public function update($book = null, $attributes = null) {
    $data = [];

    $storedFiles = [];
    $deletedFiles = [];

    $storedCoverUrl = '';
    $deletedCoverUrl = '';

    DB::beginTransaction();
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

        // Store new book cover to public disk
        Storage::disk('public')->put('bookCovers/'.basename($data['cover_url']), file_get_contents($attributes['cover']));
        $storedCoverUrl = $data['cover_url'];

        // Move current book cover to deletedFiles folder of local disk
        Storage::put('deletedFiles/'.basename($currentBookUrl), Storage::disk('public')->get($currentBookUrl));
        $deletedCoverUrl = 'deletedFiles/'.basename($currentBookUrl);

        // Delete current book cover in public disk
        Storage::disk('public')->delete($currentBookUrl);
      }
      
      $fileTypes = FileType::all();
      foreach($fileTypes as $fileType) {
        if(isset($attributes[$fileType->name])) {
          $bookFile = BookFile::where([ ['book_id', '=', $book->id], ['file_type_id', '=', $fileType->id] ])->first();

          if($bookFile) {
            $newFileUrl = 'files/' . $fileType->name . '/' . $book->slug . '-' . time() . '.' . $attributes[$fileType->name]->extension();

            Storage::put($newFileUrl, file_get_contents($attributes[$fileType->name]));
            array_push($storedFiles, $newFileUrl);

            Storage::put('deletedFiles/'. $bookFile->file_url, Storage::get($bookFile->file_url));
            array_push($deletedFiles, 'deletedFiles/'. $bookFile->file_url);

            Storage::delete($bookFile->file_url);

            $bookFile->update(['file_url' => $newFileUrl]);
          }
          else {
            $newFileUrl = 'files/' . $fileType->name . '/' . $book->slug . '-' . time() . '.' . $attributes[$fileType->name]->extension();

            BookFile::create([
              'book_id' => $book->id,
              'file_type_id' => $fileType->id,
              'file_url' => $newFileUrl
            ]);
    
            Storage::put($newFileUrl, file_get_contents($attributes[$fileType->name]));

            array_push($storedFiles, $newFileUrl);
          }
        }
      }

      if(isset($attributes['genres'])) {
        BookGenre::where('book_id', '=', $book->id)->delete();

        foreach ($attributes['genres'] as $genre) {
          BookGenre::create(['book_id' => $book->id, 'genre_id' => $genre]);
        }
      }

      if($data) $book->update($data);

      DB::commit();

      return $book;

    } catch (\Throwable $th) {
      DB::rollBack();

      if($storedCoverUrl && $deletedCoverUrl) {
        Storage::disk('public')->put('bookCovers/'.basename($deletedCoverUrl), Storage::get($deletedCoverUrl));
        Storage::delete($deletedCoverUrl);
        Storage::disk('public')->delete($storedCoverUrl);
      }

      foreach($deletedFiles as $filename) {
        Storage::put('files/'. explode('/', $filename)[2] . '/' .basename($filename), Storage::get($filename));
        Storage::delete($filename);
      }

      foreach ($storedFiles as $filename) {
        Storage::delete($filename);
      }

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
