<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo mr-5" href="{{ route('admin.dashboard') }}"><img src="{{ asset('backend/images/logo.svg') }}" class="mr-2" alt="logo" /></a>
    <a class="navbar-brand brand-logo-mini" href="{{ route('admin.dashboard') }}"><img src="{{ asset('backend/images/logo-mini.svg') }}" alt="logo" /></a>
  </div>

  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">

    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="icon-menu"></span>
    </button>

    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item nav-profile dropdown">

        <a class="nav-link dropdown-toggle mr-2" href="#" data-toggle="dropdown" id="profileDropdown">
          {{ session('currentUser')['username'] }}
        </a>

        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item">
            <i class="ti-settings text-primary"></i>
            Thông tin tài khoản
          </a>
          <a class="dropdown-item" href="{{ route('auth.logout') }}">
            <i class="ti-power-off text-primary"></i>
            Đăng xuất
          </a>
        </div>

      </li>
    </ul>

    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
      data-toggle="offcanvas">
      <span class="icon-menu"></span>
    </button>
    
  </div>
</nav>
