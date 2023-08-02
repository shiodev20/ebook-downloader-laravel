@extends('partials.layouts.client')

@section('documentTitle')
  Lấy lại mật khẩu
@endsection

@section('content')
  <section id="forgotPassword">
    <div class="container mt-5 shadow-sm">
      <div class="row">
        <div class="box py-4 px-4">

          <div class="auth-form w-50 m-auto">

            <form action="{{ route('password.update') }}" method="POST" id="passwordUpdateForm">
              @csrf
  
              <div class="auth-form_logo text-center">
                <img src="{{ asset('images/logo.png') }}" class="my-4" width="200px">
              </div>

              <input type="text" name="token" value="{{ $token }}" hidden>
  
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

              <div class="auth-form_input my-4">
                <input 
                  type="password" 
                  class="form-control form-control-lg" 
                  id="passwordUpdatePassword" 
                  name="password" 
                  placeholder="Mật khẩu"
                  style="padding: 1rem; {{ $errors->has('password') ? 'border: 1px solid #dc3545' : '' }}"
                >
                @error('password')
                 <div class="invalid-feedback d-block fs-5">{{ $message }}</div>
                @enderror
              </div>

              <div class="auth-form_input my-4">
                <input 
                  type="password" 
                  class="form-control form-control-lg" 
                  id="passwordUpdateConfirm" 
                  name="password_confirmation" 
                  placeholder="Nhập lại mật khẩu"
                  style="padding: 1rem;"
                >
              </div>
  
              <button type="submit" class="auth-form_btn btn btn-lg text-white bg-main w-100 fw-bold" style="padding: 1rem;">Khôi phục mật khẩu</button>
  
            </form>
  
          </div>

        </div>
      </div>
    </div>
  </section>
@endsection

@push('js')
 <script>
    const inputs = document.querySelectorAll('#passwordUpdateForm input')

    inputs.forEach(input => {
      input.addEventListener('input', () => {
        input.style.border = '1px solid #CED4DA'
        const invalidFeedBack = document.querySelector(`input[id=${input.id}] + .invalid-feedback`)
        if(invalidFeedBack) {
          invalidFeedBack.style.visibility = 'hidden'
          invalidFeedBack.style.height = '0px'
        }
      })
    })
 </script>
@endpush