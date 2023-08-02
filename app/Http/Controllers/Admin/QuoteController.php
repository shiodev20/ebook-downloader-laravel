<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Repository\QuoteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuoteController extends Controller
{
  private $quoteRepository;
  private $pagination = 8;

  public function __construct(QuoteRepository $quoteRepository) {
    $this->quoteRepository = $quoteRepository;
  }

  public function index() {
    try {
      $query = ['search' => ''];

      $quotes = $this->quoteRepository->getAll()->paginate($this->pagination);

      return view('admin.quotes.index', compact([
        'query',
        'quotes'
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }

  }

  public function store(Request $request) {
    try {
      $validator = Validator::make(
        $request->all(),
        [ 'content' => 'required' ],
        [ 'content.required' => 'Nội dung không được bỏ trống' ]
      );

      if($validator->fails()) {
        return [
          'status' => false,
          'messages'=> $validator->messages(),
        ];
      }

      $createdQuote = $this->quoteRepository->add($request->except('_token'));

      if($createdQuote) {
        return [
          'status' => true,
          'messages'=> "Thêm trích dẫn thành công",
        ];
      }

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  public function update(Request $request, Quote $quote) {
    $request->validate(
      [ 'content' => 'required' ],
      [ 'content.required' => 'Nội dung không được bỏ trống' ]
    );

    $updatedQuote = $this->quoteRepository->update($quote, $request->except(['_token', '_method']));

    if($updatedQuote) return redirect()->back()->with('successMessage', 'Thêm trích dẫn thành công');

    return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');

  }

  public function destroy(Quote $quote) {
    $result = $this->quoteRepository->delete($quote);

    if($result) return redirect()->back()->with('successMessage', 'Xóa trích dẫn thành công');
    return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
  }

  public function search(Request $request) {
    try {
      $query = ['search' => ''];

      $query['search'] = $request->query('search');

      $quotes = $this->quoteRepository->find([
        ['content', 'like', '%' . $query['search'] . '%'],
      ])->paginate($this->pagination);

      return view('admin.quotes.index', compact([
        'query',
        'quotes'
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }
}
