<?php

namespace App\Repository;

use App\Models\Quote;
use App\Repository\IRepository\IRepository;

class QuoteRepository implements IRepository
{

  public function getAll() {
    return Quote::all();
  }


  public function getById($id) {
    return Quote::find($id);
  }


  public function add($attributes = []) {
    return Quote::create($attributes);
  }


  public function update($quote = null, $attributes = []) {
    return $quote->update($attributes);
  }


  public function delete($quote) {
    try {
      $quote->delete();
      return true;

    } catch (\Throwable $th) {
      return false;
    }
  }


  public function find($expressions = [], ) {
    return Quote::where($expressions)->get();
  }
  
}
