<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="auth-form">

          <form action="{{ route('auth.register') }}" method="POST" id="registerForm">
            @csrf

            <div class="auth-form_logo text-center">
              <img src="{{ asset('images/logo-waka.png') }}" class="my-4">
            </div>

            <div class="bg-danger text-white p-3 rounded fs-5 auth-error" style="display: none"></div>

            <div class="auth-form_input my-4">
              <input type="text" class="form-control form-control-lg" id="registerUsername" name="username" placeholder="Tên người dùng">
              <div class="input-error username-error p-2" style="display: none;"></div>
            </div>

            <div class="auth-form_input my-4">
              <input type="text" class="form-control form-control-lg" id="registerEmail" name="email" placeholder="Email">
              <div class="input-error email-error p-2" style="display: none;"></div>
            </div>

            <div class="auth-form_input my-4">
              <input type="password" class="form-control form-control-lg" id="registerPassword" name="password" placeholder="Mật khẩu">
              <div class="input-error password-error p-2" style="display: none;"></div>
            </div>

            <div class="auth-form_input my-4">
              <input type="password" class="form-control form-control-lg" id="registerPasswordConfirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu">
            </div>


            <button type="submit" class="auth-form_btn btn btn-lg text-white bg-main w-100">Đăng ký</button>

            <div class="auth-form_bottom mt-4 text-center">
              Đã có tài khoản ? <a type="button" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Đăng nhập</a>
            </div>

          </form>

        </div>
      </div>
    </div>
  </div>
</div>

@push('js')
  <script>
    const registerForm = document.querySelector('#registerForm')

    registerForm.addEventListener('submit', (e) => {
      e.preventDefault()
      
      const data = {
        '_token': '{{ csrf_token() }}',
        'username': document.querySelector('#registerForm input[name=username]').value,
        'email': document.querySelector('#registerForm input[name=email]').value,
        'password': document.querySelector('#registerForm input[name=password]').value,
        'password_confirmation': document.querySelector('#registerForm input[name=password_confirmation]').value,
      }

      fetch('{{ route('auth.register') }}', {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
          'Accept': 'application/json',
          'Content-type': 'application/json',
        },
      })
      .then(res => res.json())
      .then(data => {
        if(!data.status) {
          for (const message in data.messages) {
            document.querySelector(`#registerForm .${message}-error`).style.display = 'block';
            document.querySelector(`#registerForm .${message}-error`).style.visibility = '';
            document.querySelector(`#registerForm .${message}-error`).innerHTML = data.messages[message];
          }
        }
        else {
          window.location.href = data.redirectUrl
        }
      })
    })

    const registerInputs = document.querySelectorAll('#registerForm input')
    registerInputs.forEach(input => {
      input.addEventListener('input', () => {
        const authErrorMessage = document.querySelector('.auth-error')
        if(authErrorMessage) authErrorMessage.style.display = 'none'

        const inputErrorMessage = document.querySelector(`input[id=${input.id}] + .input-error`)
        if(inputErrorMessage) {
          inputErrorMessage.style.visibility = 'hidden'
          inputErrorMessage.style.display = 'none'
        }
      })
    })
  </script>
@endpush