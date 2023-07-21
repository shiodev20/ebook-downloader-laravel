<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{

  public function __construct() {
    $this->middleware(['auth']);
  }

  public function index(Request $request, Book $book) {
    
    $filename = env('APP_NAME') . '-' . $book->slug . '.' .  pathinfo($request->url, PATHINFO_EXTENSION);

    return Storage::download($request->url, $filename);
  }
}
