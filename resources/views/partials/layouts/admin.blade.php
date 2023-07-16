<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" href="{{ asset('backend/images/logo-mini.svg') }}">
  <link rel="stylesheet" href="{{ asset('backend/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/vendors/font-awesome/css/all.min.css') }}
  ">
  <link rel="stylesheet" href="{{ asset('backend/vendors/css/vendor.bundle.base.css') }}">

  <link rel="stylesheet" href="{{ asset('backend/vendors/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">

  <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/css/app.css') }}">

  <title>{{ env('APP_NAME') }} | @yield('documentTitle')</title>
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
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023 <a
                  href="/">{{ env('APP_NAME') }}</a>. All rights reserved.</span>

              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Theme by <a
                  href="https://www.bootstrapdash.com/product/skydash-free">Skydash</a>
                <i class="ti-heart text-danger ml-1"></i>
              </span>
            </div>
          </footer>

        </div>

      </div>

    </div>

    <x-flash-message></x-flash-message>
    <x-delete-confirm-modal></x-delete-confirm-modal>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script src="{{ asset('js/ui.js') }}"></script>
  <script src="{{ asset('backend/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('backend/js/template.js') }}"></script>

  <script src="{{ asset('backend/vendors/select2/select2.min.js') }}"></script>

  <script>
    (function($) {
      'use strict';

      if ($(".js-example-basic-single").length) {
        $(".js-example-basic-single").select2();
      }
      if ($(".js-example-basic-multiple").length) {
        $(".js-example-basic-multiple").select2();
      }
    })(jQuery);
  </script>

  <script>
    (function($) {
      'use strict';
      $(function() {
        $('.file-upload-browse').on('click', function() {
          var file = $(this).parent().parent().parent().find('.file-upload-default');
          file.trigger('click');
        });
        $('.file-upload-default').on('change', function() {
          $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
        });
      });
    })(jQuery);
  </script>

  <script>
    function handleDelete(url, message) {
      const deleteConfirmModal = document.querySelector('#deleteConfirmModal');
      const deleteConfirmForm = document.querySelector('#deleteConfirmForm');
      const modalMessage = document.querySelector('#deleteConfirmModal .modal-message');
      modalMessage.innerHTML = 'Bạn có chắc muốn xóa ' + message + ' ?';
      deleteConfirmForm.action = url;
    }
  </script>

  <script>
     function preview_imageBook() {
      document.getElementById('bookCoverRender').src = URL.createObjectURL(document.getElementById("bookCoverInput").files[0])
    }
  </script>
  @stack('js')
</body>

</html>
