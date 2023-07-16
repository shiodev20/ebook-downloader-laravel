@extends('partials.layouts.admin')

@section('documentTitle')
  Quản lý sách
@endsection

@section('content')
  <div class="row">

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Quản lý sách</div>

          <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

            {{-- book Search --}}
            <form id="bookSearchForm" action="{{ route('books.search') }}" method="GET">

              <label for="#bookSearhInput">Tìm kiếm sách</label>
              <div class="input-group">
                <input type="text" id="bookSearhInput" class="form-control form-control-sm font-weight-bold"
                  placeholder="Tên sách" name="search" value="{{ $query['search'] }}">
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

            {{-- book Add --}}
            <a class="btn btn-primary btn-icon-text" href="{{ route('books.create') }}">
              <i class='fa-solid fa-plus btn-icon-prepend'></i>Thêm sách
            </a>
          </div>

          <hr>

          {{-- book Options --}}
          {{-- <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('books.index') }}" class="btn btn-primary btn-sm">Tất cả</a>

            <select class="custom-select custom-select-sm" style="width: 150px;" id="bookSort">

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

          {{-- book Data --}}
          {{-- <div class="table-responsive">
            <table id="bookData" class="table table-hover table-striped table-bordered">

              <thead class="table-primary">
                <tr>
                  <th>STT</th>
                  <th>Thể loại</th>
                  <th>Sách</th>
                  <th>Lựa chọn</th>
                </tr>
              </thead>

              <tbody>

                @foreach ($books as $book)
                  <tr>
                    <td class="font-weight-bold" style="width: 100px;">{{ $loop->index + 1 }}</td>
                    <td class="font-weight-bold" style="min-width: 400px; width: 400px;">
                      <form id="bookEditForm" action="{{ route('books.update', ['book' => $book->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="input-group">
                          <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $book->name }}" name="{{ 'book-'.$book->id }}">
                          <div class="input-group-append">
                            <button class="btn btn-success btn-sm" type="submit"><i class='fa-solid fa-pen' style="font-size: .8rem;"></i></button>
                          </div>
                        </div>

                        <div class="{{'input-error text-danger p-1 position-relative'.' book-'.$book->id.'-error' }}" style="font-size: .8rem;">
                          @error('book-' . $book->id)
                            <div class="position-absolute">{{ $message }}</div>
                          @enderror
                        </div>
                      </form>
                    </td>
                    <td class="font-weight-bold">{{ $book->books->count() }}</td>

                    <td class="font-weight-bold">
                      <div class="d-flex justify-content-start">
                        <a class="mr-1" href="/">
                          <button class="btn btn-sm btn-info">
                            <i class='fa-solid fa-chart-simple' style="font-size: .8rem;"></i>
                          </button>
                        </a>

                        <x-delete-confirm-button
                          :url="route('books.destroy', ['book' => $book->id]) "
                          :message=" 'thể loại '.'<b><q>'.$book->name.'</q></b>' "
                        >
                          <i class="fa-solid fa-trash" style="font-size: .8rem;"></i>
                        </x-delete-confirm-button>
                      </div>
                    </td>

                  </tr>
                @endforeach

              </tbody>

            </table>
          </div> --}}

          {{-- @if ($books)
            <div class="mt-4 d-flex justify-content-center justify-content-md-end">
              {{ $books->links() }}
            </div>
          @endif --}}
        </div>

      </div>
    </div>

  </div>

@endsection

@push('js')
  <script>
    function preview_images() {}
  </script>
@endpush
