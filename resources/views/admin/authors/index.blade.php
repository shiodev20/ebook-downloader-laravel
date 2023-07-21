@extends('partials.layouts.admin')

@section('documentTitle')
  Tác giả
@endsection

@section('content')
  <div class="row">

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Quản lý tác giả</div>

          {{-- Author Forms --}}
          <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

            {{-- Author Search --}}
            <form id="authorSearchForm" action="{{ route('authors.search') }}" method="GET">

              <label for="#authorSearhInput">Tìm kiếm tác giả</label>
              <div class="input-group">
                <input type="text" id="authorSearhInput" class="form-control form-control-sm font-weight-bold" placeholder="Tên tác giả" name="search" value="{{ $query['search'] }}">
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

            {{-- author Add --}}
            <form id="authorAddForm" action="{{ route('authors.store') }}" method="POST">
              @csrf

              <label for="authorAddInput">Thêm tác giả</label>
              <div class="input-group">
                <input type="text" id="authorAddInput" class="form-control form-control-sm font-weight-bold" placeholder="Tên tác giả" name="author">
                <div class="input-group-append">
                  <button class="btn btn-primary btn-sm" type="submit"><i class="fa-solid fa-plus"></i></button>
                </div>
              </div>
              <div class="input-error author-error text-danger p-1 position-relative" style="font-size: .8rem;">
                @error('author')
                  <div class="position-absolute">{{ $message }}</div>
                @enderror
              </div>

            </form>

          </div>

          <hr>

          {{-- author Options --}}
          <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('authors.index') }}" class="btn btn-primary btn-sm">Tất cả</a>

            <select class="custom-select custom-select-sm" style="width: 150px;" id="authorSort">

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
          </div>

          {{-- author Data --}}
          <div class="table-responsive">
            <table id="authorData" class="table table-hover table-striped table-bordered">

              <thead class="table-primary">
                <tr>
                  <th>STT</th>
                  <th>Tác giả</th>
                  <th>Sách</th>
                  <th>Lựa chọn</th>
                </tr>
              </thead>

              <tbody>

                @foreach ($authors as $author)
                  <tr>
                    <td class="font-weight-bold" style="width: 100px;">{{ $loop->index + 1 }}</td>
                    <td class="font-weight-bold" style="min-width: 400px; width: 400px;">
                      <form id="authorEditForm" action="{{ route('authors.update', ['author' => $author->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="input-group">
                          <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $author->name }}" name="{{ 'author-'.$author->id }}">
                          <div class="input-group-append">
                            <button class="btn btn-success btn-sm" type="submit"><i class='fa-solid fa-pen' style="font-size: .8rem;"></i></button>
                          </div>
                        </div>

                        <div class="{{'input-error text-danger p-1 position-relative'.' author-'.$author->id.'-error' }}" style="font-size: .8rem;">
                          @error('author-'.$author->id)
                            <div class="position-absolute">{{ $message }}</div>
                          @enderror
                        </div>
                      </form>
                    </td>
                    <td class="font-weight-bold">{{ $author->books->count() }}</td>

                    <td class="font-weight-bold">
                      <div class="d-flex justify-content-start">
                        <a class="mr-1" href="{{ route('authors.show', ['author' => $author->id]) }}">
                          <button class="btn btn-sm btn-info">
                            <i class='fa-solid fa-chart-simple' style="font-size: .8rem;"></i>
                          </button>
                        </a>

                        <x-delete-confirm-button
                          :url="route('authors.destroy', ['author' => $author->id]) "
                          :message=" 'tác giả '.'<b><q>'.$author->name.'</q></b>' "
                        >
                          <i class="fa-solid fa-trash" style="font-size: .8rem;"></i>
                        </x-delete-confirm-button>
                      </div>
                    </td>

                  </tr>
                @endforeach

              </tbody>

            </table>
          </div>

          @if ($authors)
            <div class="mt-4 d-flex justify-content-center justify-content-md-end">
              {{ $authors->links() }}
            </div>
          @endif
        </div>

      </div>
    </div>

  </div>

@endsection

@push('js')
  {{-- Sort author --}}
  <script>
    const authorSortSelect = document.querySelector('#authorSort')

    authorSortSelect.addEventListener('change', (e) => {
      const sortBy = e.target.value

      if(sortBy) window.location.href = '{{ route('authors.sort') }}' + `?sortBy=${sortBy}`
    })
  </script>

  <script>
    const inputs = [
      ...document.querySelectorAll('#authorSearchForm input'),
      ...document.querySelectorAll('#authorAddForm input'),
      ...document.querySelectorAll('#authorEditForm input'),
    ]

    inputs.forEach(input => {
      input.addEventListener('input', () => {
        document.querySelector(`.${input.name}-error`).innerHTML = ''
      })
    });
  </script>
@endpush
