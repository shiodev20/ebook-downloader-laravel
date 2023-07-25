<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Illuminate\Http\Request;

class AuthorController extends Controller
{

  private $authorRepository;
  private $bookRepository;
  private $pagination = 15;

  public function __construct(AuthorRepository $authorRepository, BookRepository $bookRepository) {
    $this->middleware(['auth', 'admin']);
    $this->authorRepository = $authorRepository;
    $this->bookRepository = $bookRepository;
  }

  
  public function index() {
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


  public function show(Author $author) {

    try {

      $books = $this->bookRepository->find([['author_id', '=', $author->id]], $this->pagination);

      return view('admin.authors.show', compact([
        'author',
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


  public function update(Request $request, Author $author) {
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

  
  public function destroy(Author $author) {

    $result = $this->authorRepository->delete($author);

    if($result) return redirect()->back()->with('successMessage', 'Xóa tác giả thành công');
    return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');

  }


  public function deleteBook(Author $author, Book $book) {
    try {

      $result = $this->authorRepository->deleteBook($author, $book);

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


  public function sort(Request $request) {
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
