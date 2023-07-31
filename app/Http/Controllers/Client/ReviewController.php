<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Repository\ReviewRepository;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
  private $reviewRepository;

  public function __construct(ReviewRepository $reviewRepository) {
    $this->reviewRepository = $reviewRepository;
  }

  public function store(Request $request, String $bookId) {
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
      'book_id' => $bookId,
      'user_id' => auth()->user()->id
    ];

    $createdReview = $this->reviewRepository->add($attributes);

    if($createdReview) return redirect()->back()->with('successMessage', 'Đánh giá thành công');
    return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
  }
}
