<?php

namespace App\Repository;

use App\Models\BookFile;
use App\Repository\IRepository\IRepository;

class BookFileRepository implements IRepository
{

  public function getAll($paginate = 0)
  {
    return BookFile::paginate($paginate);
  }

  public function getById($id)
  {
    return BookFile::find($id);
  }

  public function add($attributes = [])
  {
    return BookFile::create($attributes);
  }

  public function update($publisher = null, $attributes = [])
  {
    return $publisher->update($attributes);
  }


  public function delete($publisher)
  {

    return $publisher->delete();
  }
}
