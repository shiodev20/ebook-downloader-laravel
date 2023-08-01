<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ asset('frontend/css/app.css') }}">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
  @stack('css')
  <title>{{ env('APP_NAME') }} | @yield('documentTitle')</title>
</head>
<body>
  
  @include('partials.client.navbar')
  
  @include('partials.modals.login')
  @include('partials.modals.register')
  @include('partials.modals.search')

  @yield('content')
  

  @include('partials.client.footer')

  <x-flash-message></x-flash-message>

  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
  <script src="{{ asset('frontend/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/js/app.js') }}"></script>
  <script src="{{ asset('js/ui.js') }}"></script>
  @stack('js')
</body>
</html>