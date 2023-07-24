<?php

namespace App\Repository;

use App\Models\BookCollection;
use App\Models\Collection;
use App\Repository\IRepository\ICollectionRepository;
use App\Utils\UppercaseFirstLetter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CollectionRepository implements ICollectionRepository
{

  public function getAll($label = '', $paginate = 0) {
    $collections = [];

    if($label == 'data') {
      $collections = Collection::paginate($paginate);
    }
    else {
      $collections = collect(Collection::all())->map(function ($collection) {
        $temp = $collection;
        $coverData = Storage::disk('public')->get($collection->cover_url);
        $coverExtension = array_pad(explode('.', $collection->cover_url), 2, null);
        
  
        $temp->cover = 'data:image/' . $coverExtension[1]. ';base64,' . $coverData;
  
        return $temp;
  
      });
    }

    return $collections;
  }

  public function getById($id) {
    return Collection::find($id);
  }

  public function add($attributes = []) {

    $fileStored = [];

    DB::beginTransaction();

    try {

      $collection = new Collection;

      $collection->name = UppercaseFirstLetter::make($attributes['name']);
      $collection->cover_url = 'collections/' . Str::slug($collection->name) . '-' . time() . '.' . $attributes['cover']->extension();

      Storage::disk('public')->put($collection->cover_url, file_get_contents($attributes['cover']));
      array_push($fileStored, $collection->cover_url);

      $collection->save();

      DB::commit();

      return $collection;

    } catch (\Throwable $th) {
      DB::rollBack();

      foreach ($fileStored as $filename) {
        Storage::disk('public')->delete($filename);
      }

      return false;
    }
  }

  public function update($author = null, $attributes = []) {
    return $author->update($attributes);
  }

  public function find($expressions = [], $paginate = 0) {
    return Collection::where($expressions)->paginate($paginate);
  }

  public function sort($sortBy, $paginate = 0) {
    $collections = [];

    switch ($sortBy) {
      case 'bookDescending':
        $collections = Collection::all()->sortByDesc(fn ($collection) => $collection->books->count(), SORT_NUMERIC)->paginate($paginate);
        break;

      case 'bookAscending':
        $collections = Collection::all()->sortBy(fn ($collection) => $collection->books->count(), SORT_NUMERIC)->paginate($paginate);
        break;
    }

    return $collections;
  }

  public function delete($author) {
    return $author->delete();
  }

  public function deleteBook($collection, $book) {
    $result = false;

    $bookCollection = BookCollection::where([
      ['collection_id', '=', $collection->id],
      ['book_id', '=', $book->id]
    ])->first();

    $result = $bookCollection->delete();

    return $result;
  }
}
