<?php

namespace App\Repository;

use App\Models\Genre;

class GenreRepository implements IRepository {

  public function getAll() {
    return Genre::all();
  }

  public function getById($id) {
    return Genre::find($id);
  }

  public function find($expressions = []) {
    return Genre::where($expressions)->get();
  }

  public function add($attributes = []) {
    return Genre::create($attributes);
  }
}