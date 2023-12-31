<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Genre;
use App\Repository\GenreRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GenreController extends Controller
{
  private $genreRepository;
  private $pagination = 10;

  public function __construct(GenreRepository $genreRepository) {
    $this->middleware(['auth', 'admin']);
    $this->genreRepository = $genreRepository;
  }

  public function index(Request $request) {
    try {
      $query = ['search' => '', 'sort' => ''];

      $genres = $this->genreRepository->getAll()->paginate($this->pagination);

      return view('admin.genres.index', compact([
        'genres',
        'query'
      ]));
    } catch (\Throwable $th) {

      return redirect()
        ->back()
        ->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  public function show(Genre $genre) {

    try {
      $books = $genre->books->paginate($this->pagination);

      return view('admin.genres.show', compact([
        'genre',
        'books'
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }

  }

  public function store(Request $request) {
    $request->validate(
      ['genre' => 'required|unique:App\Models\Genre,name'],
      [
        'genre.required' => 'Vui lòng nhập tên thể loại',
        'genre.unique' => 'Tên thể loại không được giống nhau',
      ]
    );

    try {
      $genre = [
        'name' => $request->genre,
        'slug' => Str::slug($request->genre)
      ];

      $createdGenre = $this->genreRepository->add($genre);

      return redirect()->back()->with('successMessage', 'Thêm thể loại ' . $createdGenre->name . ' thành công');

    } catch (\Throwable $th) {

      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  public function update(Request $request, Genre $genre) {
    $request->validate(
      ['genre-' . $genre->id => 'required|unique:App\Models\Genre,name'],
      [
        'genre-' . $genre->id . '.required' => 'Vui lòng nhập tên thể loại',
        'genre-' . $genre->id . '.unique' => 'Tên thể loại không được giống nhau',
      ]
    );

    try {
      $attributes = [
        'name' => $request['genre-' . $genre->id]
      ];

      $updatedGenre = $this->genreRepository->update($genre, $attributes);

      return redirect()->back()->with('successMessage', 'Thể loại được cập nhật thành công');

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }
  
  public function destroy(Genre $genre) {

    $result = $this->genreRepository->delete($genre);

    if($result) return redirect()->back()->with('successMessage', 'Xóa thể loại thành công');
    return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    
  }

  public function deleteBook(Genre $genre, Book $book) {
    try {

      $result = $this->genreRepository->deleteBook($genre, $book);
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

      $genres = $this->genreRepository->find([
        ['name', 'like', '%' . $query['search'] . '%'],
      ])->paginate($this->pagination);

      return view('admin.genres.index', compact([
        'genres',
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

      $genres = $this->genreRepository->sort($query['sort'])->paginate($this->pagination)->withQueryString();

      return view('admin.genres.index', compact([
        'genres',
        'query'
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }
}
