@extends('partials.layouts.admin')

@section('documentTitle')
  Trích dẫn
@endsection

@section('content')
  <div class="row">

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Quản lý trích dẫn</div>

          {{-- quote Forms --}}
          <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

            {{-- quote Search --}}
            <form id="quoteSearchForm" action="{{ route('quotes.search') }}" method="GET">

              <label for="#quoteSearhInput">Tìm kiếm trích dẫn</label>
              <div class="input-group">
                <input type="text" id="quoteSearhInput" class="form-control form-control-sm font-weight-bold" placeholder="Nội dung" name="search" value="{{ $query['search'] }}">
                <div class="input-group-append">
                  <button class="btn btn-primary btn-sm" type="submit"><i class="fa-solid fa-search"></i></button>
                </div>
              </div>
              <div class="input-error search-error text-danger p-1 position-relative" style="font-size: .8rem;">
                @error('search')
                  <div class="position-absolute">{{ $message }}</div>
                @enderror
              </div>

            </form>

            <div class="w-100 d-block d-md-none">
              <hr>
            </div>

            {{-- quote Add --}}
            <button class="btn btn-primary btn-icon-text" type="button" data-toggle="modal" data-target="#quoteAddModal">
              <i class='fa-solid fa-plus btn-icon-prepend'></i>Thêm trích dẫn
            </button>
          </div>

          <hr>

          {{-- quote Data --}}
          <div class="table-responsive">
            <table id="quoteData" class="table table-hover table-striped table-bordered">

              <thead class="table-primary">
                <tr>
                  <th>STT</th>
                  <th>Nôi dung</th>
                  <th>Tác giả</th>
                  <th>Lựa chọn</th>
                </tr>
              </thead>

              <tbody>

                @foreach ($quotes as $quote)
                <tr>
                  <form id="quoteEditForm" action="{{ route('quotes.update', ['quote' => $quote->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <td class="font-weight-bold" style="width: 100px;">{{ $loop->index + 1 }}</td>

                    <td class="font-weight-bold" style="min-width: 600px; width: 600px;">
                      <textarea name="content" class="form-control font-weight-bold">{{ $quote->content }}</textarea>
                      @error('content')
                        <div class="text-danger p-1">{{ $message }}</div>
                      @enderror
                    </td>

                    <td class="font-weight-bold" style="min-width: 300px; width: 300px;">
                      <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $quote->author }}" name="author">
                    </td>

                    <td class="font-weight-bold">
                      <div class="d-flex justify-content-start">
                        <a class="mr-1" href="{{ route('quotes.update', ['quote' => $quote->id]) }}">
                          <button class="btn btn-sm btn-success">
                            <i class='fa-solid fa-pen' style="font-size: .8rem;"></i>
                          </button>
                        </a>

                        <x-delete-confirm-button
                          :url="route('quotes.destroy', ['quote' => $quote->id]) "
                          :message=" 'thể loại '.'<b><q>'.$quote->name.'</q></b>' "
                        >
                          <i class="fa-solid fa-trash" style="font-size: .8rem;"></i>
                        </x-delete-confirm-button>
                      </div>
                    </td>

                  </form>
                  
                </tr>
                @endforeach

              </tbody>

            </table>
          </div>

          @if ($quotes)
            <div class="mt-4 d-flex justify-content-center justify-content-md-end">
              {{ $quotes->links() }}
            </div>
          @endif
        </div>

      </div>
    </div>

  </div>

  <div class="modal fade" id="quoteAddModal" tabindex="-1" aria-labelledby="quoteAddLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="quoteAddForm" action="{{ route('quotes.store') }}" enctype="multipart/form-data" method="POST">
          @csrf

          <div class="modal-header">
            <h5 class="modal-title" id="collectionAddLabel">Tạo trích dẫn</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            {{-- quote content --}}
            <div class="col-sm-12">
              <div class="form-group">
                <label class="form-label font-weight-bold" for="name">Nội dung</label>
                <textarea class="form-control font-weight-bold" id="content" name="content" rows="10"></textarea>
                <div class="invalid-feedback d-block content-error"></div>
              </div>
            </div>

            {{-- quote author --}}
            <div class="col-sm-12">
              <div class="form-group">
                <label class="form-label font-weight-bold" for="author">Tác giả</label>
                <input class="form-control form-control-sm font-weight-bold" id="author" name="author">
              </div>
            </div>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Đóng</button>
            <button type="submit" class="btn btn-primary btn-sm">Tạo</button>
          </div>

        </form>

      </div>
    </div>
  </div>
@endsection

@push('js')
<script>
  const inputs = document.querySelectorAll('#quoteAddForm textarea')

  inputs.forEach(input => {
    input.addEventListener('input', () => {
      input.style.border = '1px solid #CED4DA'
      const invalidFeedBack = document.querySelector(`textarea[id=${input.id}] + .invalid-feedback`)
      if(invalidFeedBack) invalidFeedBack.style.visibility = 'hidden'
    })
  })
</script>

<script>
  const quoteAddForm = document.querySelector('#quoteAddForm');

  quoteAddForm.addEventListener('submit', (e) => {
    e.preventDefault()

    const data = {
      '_token': '{{ csrf_token() }}',
      'content': document.querySelector('#quoteAddForm textarea[name=content]').value,
      'author': document.querySelector('#quoteAddForm input[name=author]').value,
    }

    fetch('{{ route('quotes.store') }}', {
      method: 'POST',
      body: JSON.stringify(data),
      headers: {
        'Accept': 'application/json',
        'Content-type': 'application/json',
      },
    })
    .then(response => response.json())
    .then(data => {
      if(!data.status) {
        for (const message in data.messages) {
          document.querySelector(`#quoteAddForm textarea[name=${message}]`).style.border =  '1px solid #dc3545';
          document.querySelector(`#quoteAddForm .${message}-error`).style.display = 'block';
          document.querySelector(`#quoteAddForm .${message}-error`).innerHTML = data.messages[message];
        }
      } else {
        window.location.href = '{{ route('quotes.index') }}'
      }
    })

  })
</script>
@endpush
