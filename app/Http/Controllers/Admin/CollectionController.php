<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repository\CollectionRepository;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
  private $collectionRepository;

  private $pagination = 15;

  public function __construct(CollectionRepository $collectionRepository) {
    $this->collectionRepository = $collectionRepository;
  }

  public function index() {

    try {
      $query = ['search' => '', 'sort' => ''];

      $collections = $this->collectionRepository->getAll('data', $this->pagination);

      return view('admin.collections.index', compact([
        'query',
        'collections'
      ]));

    } catch (\Throwable $th) {
      return redirect()
        ->back()
        ->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }

  }

  public function store(Request $request) {

    $createdCollection = $this->collectionRepository->add($request->except('_token'));

    if($createdCollection) return redirect()->route('collections.index')->with('successMessage', 'Thêm tuyển tập sách thành công');
    return redirect()->route('collections.index')->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');

  }


}
