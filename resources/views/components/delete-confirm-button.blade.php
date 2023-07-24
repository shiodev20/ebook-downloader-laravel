<button 
  onclick="handleDelete('{{ $url }}', '{{ $message }}')" 
  data-toggle="modal" 
  data-target="#deleteConfirmModal" 
  class="btn btn-danger btn-sm"
  type="button"
>
  {{ $slot }}
</button>
