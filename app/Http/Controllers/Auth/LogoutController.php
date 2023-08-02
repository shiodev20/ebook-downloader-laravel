<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
  public function __construct() {
    $this->middleware(['auth']);
  }

  public function index(Request $request) {
    try {
      $role = auth()->user()->role_id;

      Auth::logout();

      $request->session()->invalidate();
      $request->session()->regenerateToken();

      if($role === RoleEnum::MASTER_ADMIN->value || $role === RoleEnum::ADMIN->value) return redirect()->route('client.home');

      if($role === RoleEnum::MEMBER->value) return redirect()->back();

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }
}
