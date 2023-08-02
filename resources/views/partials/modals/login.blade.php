<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="auth-form">
          
          <form action="{{ route('auth.login') }}" method="POST" id="loginForm">
            @csrf

            <div class="auth-form_logo text-center">
              <img src="{{ asset('images/logo-waka.png') }}" class="my-4">
            </div>

            <div class="bg-danger text-white p-3 rounded fs-5 auth-error" style="display: none"></div>

            <div class="auth-form_input my-4">
              <input type="text" class="form-control form-control-lg" id="loginEmail" name="email" placeholder="Email">
              <div class="input-error email-error p-2"></div>
            </div>

            <div class="auth-form_input">
              <input type="password" class="form-control form-control-lg" id="loginPassword" name="password" placeholder="Mật khẩu">
              <div class="input-error password-error p-2"></div>
            </div>

            <div class="text-end py-2">
              <a href="/" class="auth-form_forgot">Quên mật khẩu?</a>
            </div>

            <button type="submit" class="auth-form_btn btn btn-lg text-white bg-main w-100">Đăng nhập</button>

            <div class="auth-form_divider">
              <div>Đăng nhập với</div>
              <hr>
            </div>

            <button class="btn btn-lg w-100 mb-2 auth-form_btn auth-form_btn--google">Đăng nhập bằng Google <i class='bx bxl-google'></i></button>
            <button class="btn btn-lg w-100 mb-2 auth-form_btn auth-form_btn--facebook">Đăng nhập bằng Facebook <i class='bx bxl-facebook'></i></button>

            <div class="auth-form_bottom mt-4 text-center">
              Chưa có tài khoản ? <a type="button" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Đăng ký</a>
            </div>

          </form>

        </div>
      </div>
    </div>
  </div>
</div>


<script>
  const loginForm = document.querySelector('#loginForm')

  loginForm.addEventListener('submit', (e) => {
    e.preventDefault()

    const data = {
      '_token': '{{ csrf_token() }}',
      'email': document.querySelector('#loginModal input[name=email]').value,
      'password': document.querySelector('#loginModal input[name=password]').value,
    }

    fetch('{{ route('auth.login') }}', {
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
          document.querySelector(`#loginForm .${message}-error`).style.display = 'block';
          document.querySelector(`#loginForm .${message}-error`).innerHTML = data.messages[message];
        }
      }
      else {
        window.location.href = data.redirectUrl
      }
    })
  })

  const loginInputs = document.querySelectorAll('#loginForm input')
  loginInputs.forEach(input => {
    input.addEventListener('input', () => {
      const authErrorMessage = document.querySelector('.auth-error')
      if(authErrorMessage) authErrorMessage.style.display = 'none'

      const inputErrorMessage = document.querySelector(`input[id=${input.id}] + .input-error`)
      if(inputErrorMessage) inputErrorMessage.style.visibility = 'hidden'
    })
  })
</script>
