<header class="header header_desktop header p-4 border-bottom d-none d-lg-block">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">

      <div class="header_left d-flex align-items-center">

        <div class="header_logo me-3">
          <a href="{{ route('client.home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="shiobook" width="150px">
          </a>
        </div>

        <div class="header_menu">
          <div class="dropdown">
            <a class=dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class='bx bx-category'></i>
            </a>

            <ul class="dropdown-menu">
              @foreach ($genres as $genre)
                <li><a class="dropdown-item pb-2 fs-4" href="{{ route('client.booksByGenre', ['slug' => $genre->slug]) }}">{{ $genre->name }}</a></li>
              @endforeach
            </ul>
          </div>
        </div>

      </div>

      <div class="header_right d-flex align-items-center">

        <div class="header_search me-4">
          <button type="button" data-bs-toggle="modal" data-bs-target="#searchModal">
            <i class="bx bx-search"></i>
            <span>Tìm kiếm</span>
          </button>
        </div>

        @if (session('currentUser'))

          <div class="header_dropdown me-2">
            <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="ms-1 fs-5">{{ session('currentUser')['username'] }}</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end text-small" aria-labelledby="dropdownUser1">
              <li><a class="dropdown-item fs-4" href="#">Tài Khoản</a></li>
              
              @can('is-admin')
                <li><a class="dropdown-item fs-4" href="{{ route('admin.dashboard') }}">Trang quản trị</a></li>
              @endcan

              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item fs-4" href="{{ route('auth.logout') }}">Đăng Xuất</a></li>
            </ul>

           
          </div>

        @else
          <div class="header_option header_account">
            <a type="button" data-bs-toggle="modal" data-bs-target="#loginModal">
              <i class="bx bx-user"></i>
              <span>Tài khoản</span>
            </a>
          </div>
        @endif

      </div>

    </div>

  </div>
</header>

<header class="header header_mobile header py-3 px-1 mb-3 border-bottom d-block d-lg-none">

  <div class="container">

    <div class="header_top">
      <div class="header_logo">
        <a href="{{ route('client.home') }}">
          <img src="{{ asset('images/logo.png') }}" alt="shiobook" width="150px">
        </a>
      </div>
    </div>

    <div class="header_bottom d-flex justify-content-between align-items-center">

      <div class="header_left">

        <div class="header_option header_menu">
          <a role="button" class="ico_menu">
            <i class='bx bx-category'></i>
          </a>

          <aside class="header_catalogue">
            <div class="header_catalogue_containter">

              <div class="header_catalogue_header border-bottom">

                <div class="header_catalogue_title">
                  <i class="bx bx-category"></i><span>Danh Mục</span>
                </div>

                <div class="header_catalogue_close">
                  <a role="button" class="ico_close">
                    <i class="bx bx-x"></i>
                  </a>
                </div>

              </div>

              <div class="header_catalogue_body">
                <ul>
                  @foreach ($genres as $genre)
                    <li class="header_catalogue_item"><a href="{{ route('client.booksByGenre', ['slug' => $genre->slug]) }}" class="header_catalogue_link">{{ $genre->name }}</a></li>
                  @endforeach
                </ul>
              </div>

            </div>
          </aside>

        </div>

      </div>

      <div class="header_center mx-4">
        <div class="header_search">
          <button type="button" data-bs-toggle="modal" data-bs-target="#searchModal">
            <i class="bx bx-search"></i>
            <span>Tìm kiếm</span>
          </button>
        </div>
      </div>

      <div class="header_right d-flex align-items-center">

        <div class="header_option header_account">

          @if (session('currentUser'))

            <div class="header_dropdown">
              <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bx bx-user"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end text-small" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="#">Tài Khoản</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="{{ route('auth.logout') }}">Đăng Xuất</a></li>
              </ul>
            </div> 

          @else

            <a type="button" data-bs-toggle="modal" data-bs-target="#loginModal">
              <i class="bx bx-user"></i>
            </a>

          @endif

          

        </div>

      </div>

    </div>

  </div>

</header>
