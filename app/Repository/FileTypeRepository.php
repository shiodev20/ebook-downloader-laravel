<?php

namespace App\Repository;

use App\Models\FileType;
use App\Repository\IRepository\IRepository;

class FileTypeRepository implements IRepository
{

  public function getAll($paginate = 0) {
    return FileType::paginate($paginate);
  }

  public function getById($id) {
    return FileType::find($id);
  }

  public function add($attributes = []) {
    return FileType::create($attributes);
  }

  public function update($publisher = null, $attributes = []) {
    return $publisher->update($attributes);
  }

  public function delete($publisher) {
    return $publisher->delete();
  }
  
}
