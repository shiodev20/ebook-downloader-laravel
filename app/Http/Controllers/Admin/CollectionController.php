<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
  public function index() {

    try {
      $query = ['search' => '', 'sort' => ''];

      return view('admin.collections.index', compact([
        'query',
      ]));

    } catch (\Throwable $th) {
      return redirect()
        ->back()
        ->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }

  }

  public function store(Request $request) {

  }


}
