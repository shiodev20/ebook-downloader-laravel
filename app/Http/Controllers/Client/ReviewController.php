<?php

namespace App\Http\Controllers\Client;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Review;
use App\Repository\ReviewRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
  private $reviewRepository;

  public function __construct(ReviewRepository $reviewRepository) {
    $this->reviewRepository = $reviewRepository;
  }

  public function store(Request $request, Book $book) {
    if(!Gate::allows('create-review', $book)) {
      if(!auth()->user()) return redirect()->back()->with('errorMessage', 'Vui lòng đăng nhập');

      if(
        auth()->user()->role_id == RoleEnum::ADMIN->value ||
        auth()->user()->role_id == RoleEnum::MASTER_ADMIN->value
      ) return redirect()->back()->with('errorMessage', 'Không có quyền đánh giá');
        
      return redirect()->back()->with('errorMessage', 'Bạn đã đánh giá cho sách');
    }

    $request->validate(
      [
        'content' => 'required',
        'rate' => 'required'
      ],
      [
        'content.required' => 'Vui lòng nhập nội dung đánh giá',
        'rate.required' => 'Vui lòng chọn đánh giá',
      ]
    );

    $attributes = [
      'content' => $request->content,
      'rate' => $request->rate,
      'book_id' => $book->id,
      'user_id' => auth()->user()->id
    ];

    $createdReview = $this->reviewRepository->add($attributes);

    if($createdReview) return redirect()->back()->with('successMessage', 'Đánh giá thành công');
    return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
  }

  public function update(Request $request, Review $review) {
    try {
      if(!Gate::allows('update-review', $review)) {
        return redirect()->back()->with('errorMessage', 'Bạn không có quyền cập nhật');
      }
  
      $request->validate(
        [
          'content' => 'required',
          'rate' => 'required'
        ],
      );

      $updatedReview = $this->reviewRepository->update($review, $request->except(['_method', '_token']));

      if($updatedReview) return redirect()->back()->with('successMessage', 'Cập nhật đánh giá thành công');
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  public function destroy(Review $review) {
    if(!Gate::allows('delete-review', $review)) {
      return redirect()->back()->with('errorMessage', 'Bạn không có quyền xóa');
    }

    $deletedReview = $this->reviewRepository->delete($review);

    if($deletedReview) return redirect()->back()->with('successMessage', 'Cập nhật đánh giá thành công');
    return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');

    try {
      
    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }
} 
