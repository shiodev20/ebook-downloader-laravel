<?php

namespace App\Repository;

use App\Models\BookGenre;
use App\Repository\IRepository\IRepository;

class BookGenreRepository implements IRepository
{

  public function getAll($paginate = 0)
  {
    return BookGenre::paginate($paginate);
  }

  public function getById($id)
  {
    return BookGenre::find($id);
  }

  public function add($attributes = [])
  {
    return BookGenre::create($attributes);
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
