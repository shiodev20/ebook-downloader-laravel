<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Publisher;
use App\Repository\BookRepository;
use App\Repository\PublisherRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublisherController extends Controller
{
  private $publisherRepository;
  private $bookRepository;
  private $pagination = 2;

  public function __construct(PublisherRepository $publisherRepository, BookRepository $bookRepository) {
    $this->middleware(['auth', 'admin']);
    $this->publisherRepository = $publisherRepository;
    $this->bookRepository = $bookRepository;
  }

  
  public function index() {
    try {
      $query = ['search' => '', 'sort' => ''];

      $publishers = $this->publisherRepository->getAll()->paginate($this->pagination);

      return view('admin.publishers.index', compact(['publishers', 'query']));

    } catch (\Throwable $th) {
      return redirect()
        ->back()
        ->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function show(Publisher $publisher) {
    try {

      $books = $this->bookRepository->find([['publisher_id', '=', $publisher->id]])->paginate($this->pagination);

      return view('admin.publishers.show', compact([
        'publisher',
        'books',
      ]));

    } catch (\Throwable $th) {
      return redirect()
        ->back()
        ->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }
  

  public function store(Request $request) {
    $request->validate(
      ['publisher' => 'required|unique:App\Models\Publisher,name'],
      [
        'publisher.required' => 'Vui lòng nhập tên nhà xuất bản',
        'publisher.unique' => 'Tên nhà xuất bản không được giống nhau',
      ]
    );

    try {
      $publisher = [
        'name' => $request->publisher,
        'slug' => Str::slug($request->publisher)
      ];

      $createdpublisher = $this->publisherRepository->add($publisher);

      return redirect()
        ->back()
        ->with('successMessage', 'Thêm nhà xuất bản ' . $createdpublisher->name . ' thành công');

    } catch (\Throwable $th) {

      return redirect()
        ->back()
        ->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function update(Request $request, Publisher $publisher) {
    $request->validate(
      ['publisher-' . $publisher->id => 'required|unique:App\Models\Publisher,name'],
      [
        'publisher-' . $publisher->id . '.required' => 'Vui lòng nhập tên nhà xuất bản',
        'publisher-' . $publisher->id . '.unique' => 'Tên nhà xuất bản không được giống nhau',
      ]
    );

    try {
      $attributes = [
        'name' => $request['publisher-' . $publisher->id]
      ];

      $updatedPublisher = $this->publisherRepository->update($publisher, $attributes);

      return redirect()->back()->with('successMessage', 'Nhà xuất bản được cập nhật thành công');

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  
  public function destroy(Publisher $publisher) {
    $result = $this->publisherRepository->delete($publisher);

    if($result) return redirect()->back()->with('successMessage', 'Xóa nhà xuất bản thành công');
    return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
  }


  public function deleteBook(Publisher $publisher, Book $book) {
    try {

      $result = $this->publisherRepository->deleteBook($publisher, $book);

      if($result) return redirect()->back()->with('successMessage', 'Xóa thành công sách ' . $book->id);
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  
  public function search(Request $request) {
    try {
      $query = ['search' => '', 'sort' => ''];

      $query['search'] = $request->query('search');

      $publishers = $this->publisherRepository->find([
        ['name', 'like', '%' . $query['search'] . '%'],
      ])->paginate($this->pagination);

      return view('admin.publishers.index', compact([
        'publishers',
        'query'
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function sort(Request $request) {
    try {
      $query = ['search' => '', 'sort' => ''];

      $query['sort'] = $request->query('sortBy');

      $publishers = $this->publisherRepository->sort($query['sort'])->paginate($this->pagination);

      return view('admin.publishers.index', compact([
        'publishers',
        'query'
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }
}
