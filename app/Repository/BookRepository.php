<?php

namespace App\Repository;

use App\Models\Book;
use App\Models\BookCollection;
use App\Models\BookFile;
use App\Models\BookGenre;
use App\Models\FileType;
use App\Models\Genre;
use App\Models\Publisher;
use App\Repository\IRepository\IBookRepository;
use App\Utils\GenerateId;
use App\Utils\UppercaseFirstLetter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookRepository implements IBookRepository
{

  public function getAll() {
    return Book::orderBy('publish_date', 'desc')->get();
  }

  public function getById($id) {
    return Book::find($id);
  }

  public function add($attributes = null) {

    $fileStored = [];

    DB::beginTransaction();

    try {
      $book = new Book;

      $bookId = GenerateId::make('', 8);

      while (true) {
        if ($this->getById($bookId)) $bookId = GenerateId::make('', 8);
        else break;
      }

      $book->id = $bookId;
      $book->title = UppercaseFirstLetter::make($attributes['title']);
      $book->num_pages = $attributes['numPages'];
      $book->author_id = $attributes['author'];
      $book->publisher_id = $attributes['publisher'];
      $book->description = $attributes['description'];
      $book->slug = Str::slug($book->title);

      // Add Book Cover
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

      // Add book collection
      if (isset($attributes['collections'])) {
        foreach ($attributes['collections'] as $collection) {
          BookCollection::create(['book_id' => $book->id, 'collection_id' => $collection]);
        }
      }
      
      // Add Book Files
      $fileTypes = FileType::all();
      foreach ($fileTypes as $fileType) {
        if (isset($attributes[$fileType->name])) {

          $bookFileUrl = 'files/' . $fileType->name . '/' . $book->slug . '-' . time() . '.' . $attributes[$fileType->name]->getClientOriginalExtension();

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

      if($book->title != $attributes['title']) {
        $data['title'] = UppercaseFirstLetter::make($attributes['title']);
        $data['slug'] = Str::slug($attributes['title']);
      }

      $data['num_pages'] = $attributes['numPages'];
      $data['author_id'] = $attributes['author'];
      $data['publisher_id'] = $attributes['publisher'];
      $data['description'] = $attributes['description'];

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
            $newFileUrl = 'files/' . $fileType->name . '/' . $book->slug . '-' . time() . '.' . $attributes[$fileType->name]->getClientOriginalExtension();

            Storage::put($newFileUrl, file_get_contents($attributes[$fileType->name]));
            array_push($storedFiles, $newFileUrl);

            Storage::put('deletedFiles/'. $bookFile->file_url, Storage::get($bookFile->file_url));
            array_push($deletedFiles, 'deletedFiles/'. $bookFile->file_url);

            Storage::delete($bookFile->file_url);

            $bookFile->update(['file_url' => $newFileUrl]);
          }
          else {
            $newFileUrl = 'files/' . $fileType->name . '/' . $book->slug . '-' . time() . '.' . $attributes[$fileType->name]->getClientOriginalExtension();

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

      BookGenre::where('book_id', '=', $book->id)->delete();
      if(isset($attributes['genres'])) {
        foreach ($attributes['genres'] as $genre) {
          BookGenre::create(['book_id' => $book->id, 'genre_id' => $genre]);
        }
      }

      BookCollection::where('book_id', '=', $book->id)->delete();
      if(isset($attributes['collections'])) {
        foreach ($attributes['collections'] as $collection) {
          BookCollection::create(['book_id' => $book->id, 'collection_id' => $collection]);
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

  public function find($expressions = []) {
    return Book::where($expressions)->orderBy('publish_date', 'desc')->get();
  }

  public function sort($sortBy = []) {
    $books = [];

    if($sortBy['rating'] == null) {
      $books = Book::orderBy('downloads', $sortBy['download'] == 'downloadDescending' ? 'desc' : 'asc')->orderBy('publish_date', 'desc')->get();
    }
    else if($sortBy['download'] == null) {
      $books = Book::orderBy('rating', $sortBy['rating'] == 'ratingDescending' ? 'desc' : 'asc')->orderBy('publish_date', 'desc')->get();
    }
    else {
      $books = Book::orderBy('downloads', $sortBy['download'] == 'downloadDescending' ? 'desc' : 'asc')
      ->orderBy('rating', $sortBy['rating'] == 'ratingDescending' ? 'desc' : 'asc')
      ->orderBy('publish_date', 'desc')
      ->get();
    }

    return $books;
  }

  public function sortStatus($sortBy) {
    
    $books = [];

    switch ($sortBy) {
      case 'active':
        $books = Book::where('status', '=', 1)->orderBy('publish_date', 'desc')->get();
        break;
      case 'disabled':
        $books = Book::where('status', '=', 0)->orderBy('publish_date', 'desc')->get();
        break;
    }

    return $books;

  }

  public function updateStatus($book = null) {
    return $book->update(['status' =>  !$book->status]);
  }

  public function deleteFile($book, $fileType) {

    $deletedFileUrl = '';

    DB::beginTransaction();
    try {
      $bookFile = BookFile::where([
        ['book_id', '=', $book->id],
        ['file_type_id', '=', $fileType->id]
      ])->first();

      // Move current book cover to deletedFiles folder of local disk
      Storage::put('deletedFiles/'. $bookFile->file_url, Storage::get($bookFile->file_url));
      $deletedFileUrl = 'deletedFiles/'. $bookFile->file_url;
      Storage::delete($bookFile->file_url);

      $bookFile->delete();

      DB::commit();

      return true;

    } catch (\Throwable $th) {
      DB::rollBack();

      Storage::put('files/'. explode('/', $deletedFileUrl)[2] . '/' .basename( $deletedFileUrl), Storage::get( $deletedFileUrl));
      Storage::delete($deletedFileUrl);

      return false;
    }

  }

  public function delete($book) {
    return $book->delete();
  }

  public function getMostDownloadBooks($genre) {

    $books = [];

    if($genre != 'all') {
      $books = Book::whereRelation('genres', 'genre_id', '=', $genre)->orderBy('downloads', 'desc')->get();
    }
    else {
      $books = Book::orderBy('downloads', 'desc')->orderBy('downloads', 'desc')->get();
    }

    return $books;
  }

  public function getRecommendBooks() {
    return Book::orderBy('rating', 'desc')->get();
  }

  public function getSameGenreBooks($book) {
    $books = collect([]);

    for ($i=0; $i < $book->genres->count(); $i++) { 
      $booksByGenre = $this->getByGenre($book->genres[$i]->id);

      $temp = collect([]);
      for ($j=0; $j < $booksByGenre->count(); $j++) {
        $isContain = $books->contains(fn ($book) => $book->id == $booksByGenre[$j]->id);

        if(!$isContain) {
          $temp->push($booksByGenre[$j]);
        }
      }

      $books = $books->merge($temp);
    }

    return $books->filter(fn($item) => $item->id != $book->id);
  }
  
  public function getByAuthor($author) {
    return Book::where('author_id', '=', $author)->get();
  }

  public function getByGenre($genre) {
   return Genre::where('id', '=', $genre)->first()->books;
  }

  public function getByPublisher($publisher) {
    return Publisher::where('id', '=', $publisher)->first()->books;
  }
}
