@extends('partials.layouts.admin')

@section('documentTitle')
  Thể loại
@endsection

@section('content')
  <div class="row">

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Quản lý thể loại sách</div>

          <div class="d-flex justify-content-between align-items-center flex-wrap mb-5">

            <form id="genreSearchForm" action="{{ route('genres.search') }}" method="GET">

              <div class="input-group">
                <input type="text" class="form-control form-control-sm" placeholder="Thể loại" name="genre">
                <div class="input-group-append">
                  <button class="btn btn-primary btn-sm" type="submit">Tìm kiếm</button>
                </div>
              </div>

            </form>

            <div class="w-100 d-block d-md-none">
              <hr>
            </div>


            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#genreAddModal">Thêm thể
              loại</button>

          </div>

          <div class="table-responsive">
            <table id="genreData" class="table table-hover table-striped">

              <thead class="table-primary">
                <tr>
                  <th>STT</th>
                  <th>Thể loại</th>
                  <th>Sách</th>
                  <th>Lựa chọn</th>
                </tr>
              </thead>

              <tbody>

                @foreach ($genres as $genre)
                  <tr>
                    <td class="font-weight-bold">{{ $loop->index + 1 }}</td>
                    <td class="font-weight-bold">{{ $genre->name }}</td>
                    <td class="font-weight-bold">{{ $genre->books->count() }}</td>
                    <td class="font-weight-bold">
                      <div class="d-flex justify-content-start">
                        <a class="mr-1" href="/">
                          <button class="btn btn-sm btn-info">
                            <i class='fa-solid fa-chart-simple' style="font-size: .8rem;"></i>
                          </button>
                        </a>

                        <a class="mr-1" href="/">
                          <button class="btn btn-sm btn-success">
                            <i class='fa-solid fa-pen' style="font-size: .8rem;"></i>
                          </button>
                        </a>

                        <a class="mr-1" href="/">
                          <button class="btn btn-sm btn-danger">
                            <i class='fa-solid fa-trash' style="font-size: .8rem;"></i>
                          </button>
                        </a>
                      </div>
                    </td>
                  </tr>
                @endforeach

              </tbody>

            </table>
          </div>

        </div>

      </div>
    </div>

  </div>

  <div class="modal fade" id="genreAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ route('genres.store') }}" id="genreAddForm" method="POST">

          @csrf

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Thêm thể loại</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <label for="genre">Thể loại</label>
            <input type="text" id="genre" class="form-control" name="genre">
            <div class="input-error genre-error p-2 text-danger"></div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Hủy</button>
            <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
          </div>

        </form>
      </div>
    </div>
  </div>
@endsection

@push('js')
  {{-- Search Genre --}}
  <script>
    const genreSearchForm = document.querySelector('#genreSearchForm')
    genreSearchForm.addEventListener('submit', (e) => {
      e.preventDefault()

      const name = document.querySelector('#genreSearchForm input[name=genre]').value

      const url = '{{ route('genres.search') }}' + `?genre=${name}`

      fetch(url, {
          headers: {
            'Accept': 'application/json',
            'Content-type': 'application/json',
          },
        })
        .then(res => res.json())
        .then(data => {

          if (data.status) {
            let tbody = document.querySelector('#genreData tbody');
            let genreInput = document.querySelector('#genreSearchForm input[name=genre]')

            tbody.innerHTML = ''

            data.result.genres.forEach((genre, idx) => {
              let row =
                `
                <tr>
                  <td class="font-weight-bold">${idx + 1}</td>
                  <td class="font-weight-bold">${ genre.name }</td>
                  <td class="font-weight-bold">${ genre.book_count }</td>
                  <td class="font-weight-bold">
                    <div class="d-flex justify-content-start">
                      <a class="mr-1" href="/">
                        <button class="btn btn-sm btn-info">
                          <i class='fa-solid fa-chart-simple' style="font-size: .8rem;"></i>
                        </button>
                      </a>
  
                      <a class="mr-1" href="/">
                        <button class="btn btn-sm btn-success">
                          <i class='fa-solid fa-pen' style="font-size: .8rem;"></i>
                        </button>
                      </a>
  
                      <a class="mr-1" href="/">
                        <button class="btn btn-sm btn-danger">
                          <i class='fa-solid fa-trash' style="font-size: .8rem;"></i>
                        </button>
                      </a>
                    </div>
                  </td>
                </tr>
              `
              tbody.innerHTML += row;
            })

            genreInput.value = ''

          } else {

          }
        })

    })
  </script>

  {{-- Add Genre --}}
  <script>
    const genreAddForm = document.querySelector('#genreAddForm')

    genreAddForm.addEventListener('submit', (e) => {
      e.preventDefault()

      const data = {
        '_token': '{{ csrf_token() }}',
        'genre': document.querySelector('#genreAddForm input[name=genre]').value
      }

      fetch('{{ route('genres.store') }}', {
          method: 'POST',
          body: JSON.stringify(data),
          headers: {
            'Accept': 'application/json',
            'Content-type': 'application/json',
          },
        })
        .then(res => res.json())
        .then(data => {

          if (!data.status) {
            for (const message in data.messages) {
              document.querySelector(`#genreAddForm .${message}-error`).style.display = 'block';
              document.querySelector(`#genreAddForm .${message}-error`).innerHTML = data.messages[message];
            }
          }
        })
    })

    const inputs = document.querySelectorAll('#genreAddForm input')
    inputs.forEach(input => {
      input.addEventListener('input', () => {
        const inputErrorMessage = document.querySelector(`input[id=${input.id}] + .input-error`)
        if (inputErrorMessage) inputErrorMessage.style.display = 'none'
      })
    })
  </script>
@endpush
