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

  public function getAll($paginate = 0) {
    return Collection::paginate($paginate);
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
      $collection->slug = Str::slug($collection->name);
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

  public function update($collection = null, $attributes = []) {

    $storedCoverUrl = '';
    $deletedCoverUrl = '';

    try {

      if($collection->slug != Str::slug($attributes['name'])) {
        $collection->name = UppercaseFirstLetter::make($attributes['name']);
        $collection->slug = Str::slug($collection->name);
      }

      if(isset($attributes['cover'])) {
        $currentCoverUrl = $collection->cover_url;

        $collection->cover_url = 'collections/' . $collection->slug . '-' . time() . '.' . $attributes['cover']->extension();

        Storage::disk('public')->put($collection->cover_url, file_get_contents($attributes['cover']));
        $storedCoverUrl = $collection->cover_url;

        Storage::put('deletedFiles/'.basename($currentCoverUrl), Storage::disk('public')->get($currentCoverUrl));
        $deletedCoverUrl = 'deletedFiles/'. basename($currentCoverUrl);
      }
      $collection->save();

      return $collection;

    } catch (\Throwable $th) {
      
      if($storedCoverUrl && $deletedCoverUrl) {
        Storage::disk('public')->put('collections/'.basename($deletedCoverUrl), Storage::get($deletedCoverUrl));
        Storage::delete($deletedCoverUrl);
        Storage::disk('public')->delete($storedCoverUrl);
      }

      return false;
    }
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

  public function delete($collection) {

    $deletedCoverUrl = '';

    DB::beginTransaction();

    try {

      BookCollection::where('collection_id', '=', $collection->id)->delete();

      Storage::put('deletedFiles/'.basename($collection->cover_url), Storage::disk('public')->get($collection->cover_url));
      $deletedCoverUrl = 'deletedFiles/'.basename($collection->cover_url);

      Storage::disk('public')->delete($collection->cover_url);

      $collection->delete();

      DB::commit();

      return true;
    } catch (\Throwable $th) {
      DB::rollBack();

      if($deletedCoverUrl) {
        Storage::disk('public')->put('collections/'.$deletedCoverUrl, Storage::get($deletedCoverUrl));
        Storage::delete($deletedCoverUrl);
      }

      return false;
    }
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
