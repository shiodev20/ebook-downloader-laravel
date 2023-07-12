<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Repository\AuthorRepository;
use Illuminate\Http\Request;

class AuthorController extends Controller
{

  private $authorRepository;
  private $pagination = 15;

  public function __construct(AuthorRepository $authorRepository) {
    $this->middleware(['auth', 'admin']);
    $this->authorRepository = $authorRepository;
  }

  
  public function index()
  {
    try {
      $query = ['search' => '', 'sort' => ''];

      $authors = $this->authorRepository->getAll($this->pagination);

      return view('admin.authors.index', compact(['authors', 'query']));

    } catch (\Throwable $th) {
      return redirect()
        ->back()
        ->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  
  public function store(Request $request)
  {
    $request->validate(
      ['author' => 'required|unique:App\Models\Author,name'],
      [
        'author.required' => 'Vui lòng nhập tên tác giả',
        'author.unique' => 'Tên tác giả không được giống nhau',
      ]
    );

    try {
      $author = [
        'name' => $request->author
      ];

      $createdAuthor = $this->authorRepository->add($author);

      return redirect()
        ->back()
        ->with('successMessage', 'Thêm tác giả ' . $createdAuthor->name . ' thành công');

    } catch (\Throwable $th) {

      return redirect()
        ->back()
        ->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function update(Request $request, Author $author)
  {
    $request->validate(
      ['author-' . $author->id => 'required|unique:App\Models\Author,name'],
      [
        'author-' . $author->id . '.required' => 'Vui lòng nhập tên tác giả',
        'author-' . $author->id . '.unique' => 'Tên tác giả không được giống nhau',
      ]
    );

    try {
      $attributes = [
        'name' => $request['author-' . $author->id]
      ];

      $updatedAuthor = $this->authorRepository->update($author, $attributes);

      return redirect()
        ->back()
        ->with('successMessage', 'Tác giả được cập nhật thành công');

    } catch (\Throwable $th) {
      return redirect()
        ->back()
        ->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  
  public function destroy(Author $author)
  {
    try {

      $deletedAuthor = $this->authorRepository->delete($author);

      return redirect()
        ->back()
        ->with('successMessage', 'Xóa tác giả thành công');

    } catch (\Throwable $th) {
      return redirect()
        ->back()
        ->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function search(Request $request)
  {
    try {
      $query = ['search' => '', 'sort' => ''];

      $query['search'] = $request->query('search');

      $authors = $this->authorRepository->find([
        ['name', 'like', '%' . $query['search'] . '%'],
      ], $this->pagination);

      return view('admin.authors.index', compact([
        'authors',
        'query'
      ]));
    } catch (\Throwable $th) {
      return redirect()
        ->back()
        ->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function sort(Request $request)
  {
    try {
      $query = ['search' => '', 'sort' => ''];

      $query['sort'] = $request->query('sortBy');

      $authors = $this->authorRepository->sort($query['sort'], $this->pagination);

      return view('admin.authors.index', compact([
        'authors',
        'query'
      ]));

    } catch (\Throwable $th) {
      return redirect()
        ->back()
        ->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }
}
