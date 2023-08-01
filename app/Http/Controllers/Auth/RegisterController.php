<?php

namespace App\Http\Controllers\Auth;

use App\Utils\GenerateId;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

  public function __construct() {
    $this->middleware(['guest']);
  }

  public function index(Request $request) {

    try {
      $validator = Validator::make(
        $request->all(),
        [ 
          'username' =>  ['required', 'unique:App\Models\User,username'],
          'email' => ['required', 'email', 'max:100', 'unique:App\Models\User,email'],
          'password' => ['required', 'confirmed', 'min:6'],
        ],
        [
          'username.required' => 'Vui lòng nhập tên người dùng',
          'username.unique' => 'Tên người dùng đã dược sử dụng',
  
          'email.required' => 'Vui lòng nhập Email',
          'email.unique' => 'Email đã được sử dụng',
          'email.email' => 'Email không phù hợp',
          'email.max' => 'Email không được vượt quá :max ký tự',
  
          'password.required' => 'Vui lòng nhập mật khẩu',
          'password.confirmed' => 'Mật khẩu nhập lại không chính xác',
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
  
      $userId = GenerateId::make('', 8);
  
      while (true) {
        if (User::find($userId)) $userId = GenerateId::make('', 8);
        else break;
      }
  
      $user = new User;
      $user->id = $userId;
      $user->username = $request->username;
      $user->email = $request->email;
      $user->password = Hash::make($request->password);
      $user->role_id = 3;
  
      $user->save();
  
      if (Auth::attempt($formData)) {
        $user = Auth::user();
  
        $currentUser = [
          'id' => $user->id,
          'username' => $user->username,
          'role' => $user->role->id
        ];
  
        $request->session()->regenerate();
        $request->session()->put('currentUser', $currentUser);
  
        return [
          'status' => true,
          'message' => 'Đăng nhập thành công',
          'redirectUrl' => route('client.home'),
        ];
  
      } 
      else {
        return [
          'status' => false,
          'messages' => [
            'auth' => 'Lỗi hệ thống hãy thử lại',
          ],
        ];
      }

    } catch (\Throwable $th) {
      return [
        'status' => false,
        'messages' => [
          'auth' => 'Lỗi hệ thống hãy thử lại',
        ],
      ];
    }
  }
}
