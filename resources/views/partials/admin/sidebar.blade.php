<nav class="sidebar sidebar-offcanvas" id="sidebar">

  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="menu-icon fa-solid fa-house"></i>
        <span class="menu-title">Trang chủ</span>
      </a>
    </li>

    @can('is-masterAdmin')
      {{-- Account --}}
      <li class="nav-item">
        <a class="nav-link" href="/">
          <i class="menu-icon fa-solid fa-circle-user"></i>
          <span class="menu-title">Tài khoản</span>
        </a>
      </li>
    @endcan

    {{-- Book --}}
    <li class="nav-item">
      <a class="nav-link" href="{{ route('books.index') }}">
        <i class="menu-icon fa-solid fa-book"></i>
        <span class="menu-title">Sách</span>
      </a>
    </li>

    {{-- Genre --}}
    <li class="nav-item">
      <a class="nav-link" href="{{ route('genres.index') }}">
        <i class="menu-icon fa-solid fa-cube"></i>
        <span class="menu-title">Thể loại</span>
      </a>
    </li>

    {{-- Author --}}
    <li class="nav-item">
      <a class="nav-link" href="{{ route('authors.index') }}">
        <i class="menu-icon fa-solid fa-user-pen"></i>
        <span class="menu-title">Tác giả</span>
      </a>
    </li>

    {{-- Publisher --}}
    <li class="nav-item">
      <a class="nav-link" href="{{ route('publishers.index') }}">
        <i class="menu-icon fa-solid fa-building"></i>
        <span class="menu-title">Nhà xuất bản</span>
      </a>
    </li>

    {{-- Collection --}}
    <li class="nav-item">
      <a class="nav-link" href="{{ route('collections.index') }}">
        <i class="menu-icon fa-solid fa-box"></i>
        <span class="menu-title">Tuyển tập sách</span>
      </a>
    </li>

    {{-- Quote --}}
    <li class="nav-item">
      <a class="nav-link" href="{{ route('quotes.index') }}">
        <i class="menu-icon fa-solid fa-quote-left"></i>
        <span class="menu-title">Trích dẫn</span>
      </a>
    </li>

    {{-- Banner --}}
    <li class="nav-item">
      <a class="nav-link" href="{{ route('banners.index') }}">
        <i class="menu-icon fa-solid fa-images"></i>
        <span class="menu-title">Banner</span>
      </a>
    </li>

  </ul>
  
</nav>
