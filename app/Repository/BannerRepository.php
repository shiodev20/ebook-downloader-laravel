<?php

namespace App\Repository;

use App\Models\Banner;
use App\Repository\IRepository\IRepository;
use App\Utils\UppercaseFirstLetter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerRepository implements IRepository
{

  public function getAll($paginate = 0) {
    $banners = [];

    $banners = collect(Banner::all())->map(function ($banner) {
      $temp = $banner;
      $coverData = Storage::disk('public')->get($banner->cover_url);
      $coverExtension = array_pad(explode('.', $banner->cover_url), 2, null);

      $temp->cover = 'data:image/' . $coverExtension[1]. ';base64,' . $coverData;

      return $temp;

    })->paginate($paginate);
    
    return $banners;

  }

  public function getById($id) {
    return Banner::find($id);
  }

  public function add($attributes = []) {

    $fileStored = [];

    DB::beginTransaction();

    try {

      $banner = new Banner;

      $banner->name = UppercaseFirstLetter::make($attributes['name']);
      $banner->cover_url = 'banners/' . Str::slug($banner->name) . '-' . time() . '.' . $attributes['cover']->extension();

      Storage::disk('public')->put($banner->cover_url, file_get_contents($attributes['cover']));
      array_push($fileStored, $banner->cover_url);

      $banner->save();

      DB::commit();

      return $banner;

    } catch (\Throwable $th) {
      DB::rollBack();

      foreach ($fileStored as $filename) {
        Storage::disk('public')->delete($filename);
      }

      return false;
    }
  }

  public function update($Banner = null, $attributes = []) {

    $storedCoverUrl = '';
    $deletedCoverUrl = '';

    try {

      if($Banner->slug != Str::slug($attributes['name'])) {
        $Banner->name = UppercaseFirstLetter::make($attributes['name']);
        $Banner->slug = Str::slug($Banner->name);
      }

      if(isset($attributes['cover'])) {
        $currentCoverUrl = $Banner->cover_url;

        $Banner->cover_url = 'Banners/' . $Banner->slug . '-' . time() . '.' . $attributes['cover']->extension();

        Storage::disk('public')->put($Banner->cover_url, file_get_contents($attributes['cover']));
        $storedCoverUrl = $Banner->cover_url;

        Storage::put('deletedFiles/'.basename($currentCoverUrl), Storage::disk('public')->get($currentCoverUrl));
        $deletedCoverUrl = 'deletedFiles/'. basename($currentCoverUrl);
      }
      $Banner->save();

      return $Banner;

    } catch (\Throwable $th) {
      
      if($storedCoverUrl && $deletedCoverUrl) {
        Storage::disk('public')->put('Banners/'.basename($deletedCoverUrl), Storage::get($deletedCoverUrl));
        Storage::delete($deletedCoverUrl);
        Storage::disk('public')->delete($storedCoverUrl);
      }

      return false;
    }
  }

  public function find($expressions = [], $paginate = 0) {
    return Banner::where($expressions)->paginate($paginate);
  }

  public function sort($sortBy, $paginate = 0) {
    $Banners = [];

    switch ($sortBy) {
      case 'bookDescending':
        $Banners = Banner::all()->sortByDesc(fn ($Banner) => $Banner->books->count(), SORT_NUMERIC)->paginate($paginate);
        break;

      case 'bookAscending':
        $Banners = Banner::all()->sortBy(fn ($Banner) => $Banner->books->count(), SORT_NUMERIC)->paginate($paginate);
        break;
    }

    return $Banners;
  }

  public function delete($author) {
    return $author->delete();
  }

}
