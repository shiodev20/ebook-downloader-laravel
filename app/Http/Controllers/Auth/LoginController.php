<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

  public function __construct() {
    $this->middleware(['guest']);
  }

  public function index(Request $request)
  {

    try {
      $validator = Validator::make(
        $request->all(),
        [
          'email' => 'required|email|max:100',
          'password' => 'required|min:6'
        ],
        [
          'email.required' => 'Email không được bỏ trống',
          'email.email' => 'Email không phù hợp',
          'email.max' => 'Email không được vượt quá :max ký tự',
          'password.required' => 'Mật khẩu không được bỏ trống',
          'password.min' => 'Mật khẩu từ :min ký tự trở lên',
        ]
      );

      if ($validator->fails()) {
        return [
          'status' => false,
          'messages' => $validator->messages(),
        ];
      }

      $formData = [
        'email' => $request->email,
        'password' => $request->password
      ];


      if (Auth::attempt($formData)) {
        $user = Auth::user();

        $currentUser = [
          'id' => $user->id,
          'username' => $user->username,
          'role' => $user->role->id
        ];

        $request->session()->regenerate();
        $request->session()->put('currentUser', $currentUser);


        return ($user->role_id === RoleEnum::MEMBER->value)
          ? 
            [
              'status' => true,
              'message' => 'Đăng nhập thành công',
              'redirectUrl' => route('client.home')
            ]
          : 
            [
              'status' => true,
              'redirectUrl' => route('admin.dashboard')
            ];

      } else {
        return [
          'status' => false,
          'messages' => [
            'auth' => 'Email hoặc mật khẩu không chính xác',
          ],
        ];
      }
    } catch (\Throwable $th) {
      return [
        'status' => false,
        'messages' => [
          'auth' => 'Lỗi hệ thống vui lòng thử lại sau',
        ]
      ];
    }
  }
}
