<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
  public function __construct() {
    $this->middleware(['auth']);
  }

  public function index(Request $request, Book $book) {

    $filename = env('APP_NAME') . '-' . $book->slug . '.' .  pathinfo($request->url, PATHINFO_EXTENSION);

    if(Gate::allows('is-member')) {
      $book->update([
        'downloads' => $book->downloads + 1
      ]);
    }

    $url = Storage::path($request->url);

    return response()->download($url, $filename);
  }
}
