<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Repository\BookRepository;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
  private $bookRepository;

  public function __construct(BookRepository $bookRepository) {
    $this->bookRepository = $bookRepository;
  }

  public function mostDownloadBook(Request $request) {
    try {
      $books = [];

      if($request->query('genre')) {
        $books = $this->bookRepository->getMostDownloadBooks($request->query('genre'))->paginate(12);
      }
      else {
        $books = $this->bookRepository->getMostDownloadBooks('all')->paginate(12);
      }

      $books = $books->map(function($book, $key) {
        $temp = $book;

        $temp->author_name = $book->author ? $book->author->name : '';
        $temp->files = $book->files;

        return $temp;
      });

      return [
        'status' => true,
        'result' => [
          'books' => $books,
        ],
      ];

    } catch (\Throwable $th) {
      return [
        'status' => false,
      ];
    }
  }

  public function comments(Book $book) {
    $reviews = $book->reviews;

    $reviews = $reviews->map(function($review, $key) {
      $temp = $review;

      $temp->username = $review->user->username;
      $temp->createdAt = date_format(date_create($review->created_at), 'd-m-Y');

      return $temp;
    });

    return $reviews->paginate(2);
  }
}
