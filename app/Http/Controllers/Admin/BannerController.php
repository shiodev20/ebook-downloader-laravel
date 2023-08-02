<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repository\BannerRepository;
use Illuminate\Http\Request;

class BannerController extends Controller
{
  private $bannerRepository;
  private $pagination = 8;

  public function __construct(BannerRepository $bannerRepository) {
    $this->middleware(['auth', 'admin']);
    $this->bannerRepository = $bannerRepository;
  }

  public function index() {
    try {
      $query = ['search' => ''];

      $banners = $this->bannerRepository->getAll($this->pagination);

      return view('admin.banners.index', compact([
        'query',
        'banners'
      ]));

    } catch (\Throwable $th) {
      redirect()->route('banners.index')->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
    
  }


  public function store(Request $request) {
    $createdBanner = $this->bannerRepository->add($request->except('_token'));

    if($createdBanner) return redirect()->route('banners.index')->with('successMessage', 'Thêm Banner thành công');
    return redirect()->route('banners.index')->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
  }


  public function search(Request $request) {
    try {
      $query = ['search' => ''];

      $query['search'] = $request->query('search');
      
      $banners = $this->bannerRepository->find([
        ['name', 'like', '%' . $query['search'] . '%'],
      ], $this->pagination);

      return view('admin.banners.index', compact([
        'query',
        'banners',
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  public function sort() {

  }
  
  public function destroy() {

  }
}
