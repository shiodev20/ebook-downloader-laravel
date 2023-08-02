@extends('partials.layouts.client')

@section('documentTitle')
  Quên mật khẩu
@endsection

@section('content')
  <section id="forgotPassword">
    <div class="container mt-5 shadow-sm">
      <div class="row">
        <div class="box py-4 px-4">

          <div class="auth-form w-50 m-auto">

            <form action="{{ route('password.email') }}" method="POST" id="forgotPasswordForm">
              @csrf
  
              <div class="auth-form_logo text-center">
                <img src="{{ asset('images/logo.png') }}" class="my-4" width="200px">
              </div>
  
              <div class="bg-danger text-white p-3 rounded fs-5 auth-error" style="display: none"></div>
  
              <div class="auth-form_input my-4">
                <input 
                  type="text" 
                  class="form-control form-control-lg" 
                  id="passwordUpdateEmail" 
                  name="email" 
                  placeholder="Email"
                  style="padding: 1rem; {{ $errors->has('email') ? 'border: 1px solid #dc3545' : '' }}"
                >
                @error('email')
                 <div class="invalid-feedback d-block fs-5">{{ $message }}</div>
                @enderror
              </div>

              <button type="submit" class="auth-form_btn btn btn-lg text-white bg-main w-100 fw-bold" style="padding: 1rem;">Lấy lại mật khẩu</button>
              
              <div class="auth-form_bottom mt-4 text-center fs-5">
                Đã có tài khoản ? <a class="color-main" type="button" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Đăng nhập</a>
              </div>
            </form>
  
          </div>

        </div>
      </div>
    </div>
  </section>
@endsection

@push('js')
  <script>
    const emailInput = document.querySelector('#forgotPasswordForm input[name=email]')
    
    emailInput.addEventListener('input', () => {
      emailInput.style.border = '1px solid #CED4DA'
      const invalidFeedBack = document.querySelector(`input[id=${emailInput.id}] + .invalid-feedback`)
      if(invalidFeedBack) {
        invalidFeedBack.style.visibility = 'hidden'
        invalidFeedBack.style.height = '0px'
      }
    })
  </script>
@endpush