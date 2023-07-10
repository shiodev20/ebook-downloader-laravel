<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" href="{{ asset('backend/images/logo-mini.svg') }}">
  <link rel="stylesheet" href="{{ asset('backend/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/vendors/font-awesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/css/app.css') }}">
  <title>{{ env('APP_NAME') }} | Trang chủ</title>
</head>
<body>
  <div class="container-scroller">

    @include('partials.admin.navbar')

    <div class="container-fluid page-body-wrapper">

      @include('partials.admin.sidebar')

      <div class="main-panel">

        <div class="content-wrapper">

          @yield('content')

          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023 <a href="/">{{ env('APP_NAME') }}</a>. All rights reserved.</span>
          
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Theme by <a href="https://www.bootstrapdash.com/product/skydash-free">Skydash</a>
                <i class="ti-heart text-danger ml-1"></i>
              </span>
            </div>
          </footer>

        </div>

      </div>

    </div>

    <x-flash-message></x-flash-message>
   
  </div>
  
  <script src="{{ asset('backend/js/ui.js') }}"></script>
  <script src="{{ asset('backend/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('backend/js/template.js') }}"></script>
  @stack('js')
</body>
</html>