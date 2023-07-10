
@if (session()->has('successMessage') || session()->has('errorMessage'))
  <div class="notification {{ session()->has('successMessage') ? 'bg-main' : 'bg-danger' }}">
    <button type="button" class="close" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    {{ session()->has('successMessage') ? session('successMessage') : session('errorMessage') }}
  </div>
@endif