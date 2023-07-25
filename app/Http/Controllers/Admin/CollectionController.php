<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Collection;
use App\Repository\BookRepository;
use App\Repository\CollectionRepository;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
  private $collectionRepository;
  private $bookRepository;
  private $pagination = 5;

  public function __construct(CollectionRepository $collectionRepository, BookRepository $bookRepository) {
    $this->middleware(['auth', 'admin']);
    $this->collectionRepository = $collectionRepository;
    $this->bookRepository = $bookRepository;
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
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }

  }


  public function show(Collection $collection) {
    try {
      $books = $collection->books->paginate($this->pagination);

      return view('admin.collections.show', compact([
        'collection',
        'books',
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function store(Request $request) {

    $createdCollection = $this->collectionRepository->add($request->except('_token'));

    if($createdCollection) return redirect()->route('collections.index')->with('successMessage', 'Thêm tuyển tập sách thành công');
    return redirect()->route('collections.index')->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');

  }


  public function update(Request $request, Collection $collection) {

    $request->validate(
      [
        'name' => 'required',
        'cover' => 'image'
      ],
      [
        'name.required' => 'Vui lòng nhập tên tuyển tập',
        'cover.image' => 'Vui lòng chọn file có định dạng png/jpg'
      ]
    );

    $updatedCollection = $this->collectionRepository->update($collection, $request->except(['_token, _method']));

    if($updatedCollection) return redirect()->back()->with('successMessage', 'Cập nhật thành công');
    return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
  }


  public function search(Request $request) {

    try {
      $query = ['search' => '', 'sort' => ''];

      $query['search'] = $request->query('search');
      
      $collections = $this->collectionRepository->find([
        ['name', 'like', '%' . $query['search'] . '%'],
      ], $this->pagination);

      return view('admin.collections.index', compact([
        'query',
        'collections',
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }

  }


  public function sort(Request $request) {
    try {
      $query = ['search' => '', 'sort' => ''];

      $query['sort'] = $request->query('sortBy');
      
      $collections = $this->collectionRepository->sort($query['sort'], $this->pagination);

      return view('admin.collections.index', compact([
        'query',
        'collections',
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function deleteBook(Collection $collection, Book $book) {
    try {
      $result = $this->collectionRepository->deleteBook($collection, $book);
      if($result) return redirect()->back()->with('successMessage', 'Xóa thành công sách ' . $book->id);
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function destroy() {}
}
