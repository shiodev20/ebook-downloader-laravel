<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="auth-form">
          
          <form action="{{ route('auth.login') }}" method="POST" id="loginForm">
            @csrf

            <div class="auth-form_logo text-center">
              <img src="{{ asset('images/logo.png') }}" alt="shiobook" width="150px" class="my-4">
            </div>

            <div class="bg-main text-white p-3 rounded fs-5">
              tài khoản admin: <br>
              email: nv2@gmail.com <br>
              password: 123456
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
              <a role="button" data-bs-toggle="modal" data-bs-target="#unavailableModal" data-bs-dismiss="modal" class="auth-form_forgot">Quên mật khẩu?</a>
            </div>

            <button type="submit" class="auth-form_btn btn btn-lg text-white bg-main w-100">Đăng nhập</button>

            <div class="auth-form_divider">
              <div>Đăng nhập với</div>
              <hr>
            </div>

            <a data-bs-toggle="modal" data-bs-target="#developingModal" data-bs-dismiss="modal" class="btn btn-lg w-100 mb-2 auth-form_btn auth-form_btn--google">Đăng nhập bằng Google <i class='bx bxl-google'></i></a>
            <a data-bs-toggle="modal" data-bs-target="#developingModal" data-bs-dismiss="modal" class="btn btn-lg w-100 mb-2 auth-form_btn auth-form_btn--facebook">Đăng nhập bằng Facebook <i class='bx bxl-facebook'></i></a>

            <div class="auth-form_bottom mt-4 text-center">
              Chưa có tài khoản ? <a type="button" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Đăng ký</a>
            </div>

          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- unvaliable Modal -->
<div class="modal fade" id="unavailableModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="height: 100px !important;">
        <div class="fs-3 fw-bold">
          Chức năng "Quên mật khẩu" không hiệu lực ở chế độ này.
        </div>
        <div  class="fs-5">
          Bạn có thể truy cập link demo này để xem mô tả chức năng: <a href="" class="color-main">Link Demo</a>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

<!-- developing Modal -->
<div class="modal fade" id="developingModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="height: 70px !important;">
        <div class="fs-3 fw-bold">
          Chức năng này đang được phát triển.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
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
