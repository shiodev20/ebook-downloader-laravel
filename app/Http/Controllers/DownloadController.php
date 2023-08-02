<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{

  public function index(Request $request, Book $book) {
    try {
      $filename = env('APP_NAME') . '-' . $book->slug . '.' .  pathinfo($request->url, PATHINFO_EXTENSION);
  
      if(Gate::allows('is-member')) {
        $book->update([
          'downloads' => $book->downloads + 1
        ]);
      }
  
      return Storage::download($request->url, $filename);

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'lỗi hệ thống vui lòng thử lại sau');
    }

  }
  
}
