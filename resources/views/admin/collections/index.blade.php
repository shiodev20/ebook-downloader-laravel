@extends('partials.layouts.admin')

@section('documentTitle')
  Tuyển tập sách
@endsection

@section('content')
  <div class="row">

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Quản lý tuyển tập sách</div>

          {{-- genre Forms --}}
          <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

            {{-- genre Search --}}
            <form id="genreSearchForm" action="{{ route('genres.search') }}" method="GET">

              <label for="#genreSearhInput">Tìm kiếm</label>
              <div class="input-group">
                <input type="text" id="genreSearhInput" class="form-control form-control-sm font-weight-bold" placeholder="Tên tuyển tập" name="search" value="{{ $query['search'] }}">
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

            {{-- genre Add --}}
            <button class="btn btn-primary btn-icon-text" type="button" data-toggle="modal" data-target="#collectionAddModal">
              <i class='fa-solid fa-plus btn-icon-prepend'></i>Thêm tuyển tập
            </button>

          </div>

          <hr>

          {{-- genre Options --}}
          {{-- <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('genres.index') }}" class="btn btn-primary btn-sm">Tất cả</a>

            <select class="custom-select custom-select-sm" style="width: 150px;" id="genreSort">

              @if ($query['sort'] == 'bookAscending')

                <option value="">Sắp xếp theo: </option>
                <option value="bookDescending">Số sách giảm dần</option>
                <option value="bookAscending" selected>Số sách tăng dần</option>

              @elseif ($query['sort'] == 'bookDescending')

                <option value="">Sắp xếp theo: </option>
                <option value="bookDescending" selected>Số sách giảm dần</option>
                <option value="bookAscending">Số sách tăng dần</option>

              @else

                <option value="" selected>Sắp xếp theo: </option>
                <option value="bookDescending">Số sách giảm dần</option>
                <option value="bookAscending">Số sách tăng dần</option>
                
              @endif

            </select>
          </div> --}}

          {{-- genre Data --}}
          <div class="table-responsive">
            <table id="genreData" class="table table-hover table-striped table-bordered">

              <thead class="table-primary">
                <tr>
                  <th>STT</th>
                  <th>Hình ảnh</th>
                  <th>Tên</th>
                  <th>Số lượng sách</th>
                  <th>Lựa chọn</th>
                </tr>
              </thead>

              <tbody>

                {{-- @foreach ($genres as $genre)
                  <tr>
                    <td class="font-weight-bold" style="width: 100px;">{{ $loop->index + 1 }}</td>
                    <td class="font-weight-bold" style="min-width: 400px; width: 400px;">
                      <form id="genreEditForm" action="{{ route('genres.update', ['genre' => $genre->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="input-group">
                          <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $genre->name }}" name="{{ 'genre-'.$genre->id }}">
                          <div class="input-group-append">
                            <button class="btn btn-success btn-sm" type="submit"><i class='fa-solid fa-pen' style="font-size: .8rem;"></i></button>
                          </div>
                        </div>

                        <div class="{{'input-error text-danger p-1 position-relative'.' genre-'.$genre->id.'-error' }}" style="font-size: .8rem;">
                          @error('genre-'.$genre->id)
                            <div class="position-absolute">{{ $message }}</div>
                          @enderror
                        </div>
                      </form>
                    </td>
                    <td class="font-weight-bold">{{ $genre->books->count() }}</td>

                    <td class="font-weight-bold">
                      <div class="d-flex justify-content-start">
                        <a class="mr-1" href="{{ route('genres.show', ['genre' => $genre->id]) }}">
                          <button class="btn btn-sm btn-info">
                            <i class='fa-solid fa-chart-simple' style="font-size: .8rem;"></i>
                          </button>
                        </a>

                        <x-delete-confirm-button
                          :url="route('genres.destroy', ['genre' => $genre->id]) "
                          :message=" 'thể loại '.'<b><q>'.$genre->name.'</q></b>' "
                        >
                          <i class="fa-solid fa-trash" style="font-size: .8rem;"></i>
                        </x-delete-confirm-button>
                      </div>
                    </td>

                  </tr>
                @endforeach --}}

              </tbody>

            </table>
          </div>

          {{-- @if ($genres)
            <div class="mt-4 d-flex justify-content-center justify-content-md-end">
              {{ $genres->links() }}
            </div>
          @endif --}}
        </div>

      </div>
    </div>

  </div>

  <div class="modal fade" id="collectionAddModal" tabindex="-1" aria-labelledby="collectionAddLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="collectionAddLabel">Tạo tuyển tập sách</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <form action="" enctype="multipart/form-data" method="POST">

          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Đóng</button>
          <button type="button" class="btn btn-primary btn-sm">Tạo</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  {{-- Sort genre --}}
  <script>
    const genreSortSelect = document.querySelector('#genreSort')

    genreSortSelect.addEventListener('change', (e) => {
      const sortBy = e.target.value

      if(sortBy) window.location.href = '{{ route('genres.sort') }}' + `?sortBy=${sortBy}`
    })
  </script>

  <script>
    const inputs = [
      ...document.querySelectorAll('#genreSearchForm input'),
      ...document.querySelectorAll('#genreAddForm input'),
      ...document.querySelectorAll('#genreEditForm input'),
    ]

    inputs.forEach(input => {
      input.addEventListener('input', () => {
        document.querySelector(`.${input.name}-error`).innerHTML = ''
      })
    });
  </script>
@endpush
