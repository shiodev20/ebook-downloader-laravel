<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Book;
use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
  public function create(User $user, Book $book) {
    if(!isset($user)) return false;
    if($user->role_id == RoleEnum::ADMIN->value || $user->role_id == RoleEnum::MASTER_ADMIN->value) return false;
    
    $isExist = Review::where([['user_id', '=', $user->id], ['book_id', '=', $book->id]])->first();
    if($isExist) return false;
    
    return true;
  }

  public function update(User $user, Review $review)
  {
    return $user->id == $review->user_id;
  }

  public function delete(User $user, Review $review)
  {
    return $user->id == $review->user_id;
  }

  /**
   * Determine whether the user can restore the model.
   */
  public function restore(User $user, Review $review)
  {
    //
  }

  /**
   * Determine whether the user can permanently delete the model.
   */
  public function forceDelete(User $user, Review $review)
  {
    //
  }
}
