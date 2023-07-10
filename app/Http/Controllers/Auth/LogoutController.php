<?php

namespace App\Http\Controllers\Auth;

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
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('client.home');

        } catch (\Throwable $th) {
            return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
        }
    }
}
