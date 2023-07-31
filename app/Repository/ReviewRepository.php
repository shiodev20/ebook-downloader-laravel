<?php

namespace App\Repository;

use App\Models\Book;
use App\Models\Review;
use App\Repository\IRepository\IRepository;
use Illuminate\Support\Facades\DB;

class ReviewRepository implements IRepository
{

  public function getAll() {
    return Review::all();
  }


  public function getById($id) {
    return Review::find($id);
  }


  public function add($attributes = []) {

    DB::beginTransaction();
    try {
      $createdReview = Review::create($attributes);

      $book = Book::find($attributes['book_id']);

      $sumOfRates = $book->reviews->reduce(function($carry, $review) {
        return $carry + $review->rate;
      }, 0);

      $rating = $sumOfRates / $book->reviews->count();

      $book->update([
        'rating' => $rating
      ]);

      DB::commit();

      return true;

    } catch (\Throwable $th) {
      DB::rollBack();

      return false;
    }
  }


  public function update($review = null, $attributes = []) {
    return $review->update($attributes);
  }


  public function delete($review) {
    try {
      $review->delete();
      return true;

    } catch (\Throwable $th) {
      return false;
    }
  }


  public function find($expressions = [], ) {
    return Review::where($expressions)->get();
  }
  
}
