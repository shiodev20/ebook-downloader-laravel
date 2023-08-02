<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
  public function __construct() {
    $this->middleware(['guest']);
  }

  public function passwordResetRequest() {
    try {

      $genres = Genre::all();

      return view('auth.forgot-password', compact(['genres']));

    } catch (\Throwable $th) {

    }
  }

  
  public function passwordResetSendEmail(Request $request) {
    $request->validate(
      [ 'email' => 'required|email'],
      [
        'email.required' => 'Vui lòng nhập email',
        'email.email' => 'Email không phù hợp'
      ]
    );

    
    try {
      $status = Password::sendResetLink($request->only('email'));

      return $status === Password::RESET_LINK_SENT
        ? redirect()->back()->with('successMessage', 'Vui lòng xác nhận mail')
        : redirect()->back()->withErrors('email', __($status));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function passwordReset(string $token) {
    try {
      $genres = Genre::all();
      return view('auth.reset-password',  compact(['genres', 'token']));

    } catch (\Throwable $th) {
      //throw $th;
    }
  }


  public function passwordUpdate(Request $request) {
    $request->validate(
      [
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed'
      ],
      [
        'email.required' => 'Vui lòng nhập email',
        'email.email' => 'Email không phù hợp',
        'password.required' => 'Vui lòng nhập mật khẩu',
        'password.min' => 'Mật khẩu từ :min ký tự trở trên',
        'password.confirmed' => 'Vui lòng nhập lại mật khẩu'
      ]
    );

    try {
      $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function(User $user, string $password) {
          $user->forceFill([
            'password' => Hash::make($password)
          ]);
  
          $user->save();
  
          event(new PasswordReset($user));
        }
      );
  
      return $status === Password::PASSWORD_RESET
        ? redirect()->route('client.home')->with('successMessage', "Mật khẩu được khôi phục thành công")
        : back()->withErrors(['email' => [__($status)]]);

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }

  }
}