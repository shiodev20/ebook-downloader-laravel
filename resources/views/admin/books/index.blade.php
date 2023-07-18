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


          {{-- book Data --}}
          <div class="table-responsive">
            <table id="bookData" class="table table-hover table-bordered">

              <thead class="table-primary">
                <tr>
                  <th>Mã</th>
                  <th>Bìa sách</th>
                  <th>Tiêu đề</th>
                  <th>Tác giả</th>
                  <th>File sách hiện có</th>
                  <th>Lượt tải</th>
                  <th>Đánh giá</th>
                  <th>Ngày cập nhật</th>
                  <th>Lựa chọn</th>
                </tr>
              </thead>

              <tbody>

                @foreach ($books as $book)
                  <tr>
                    <td class="font-weight-bold" style="width: 100px;">{{ $book->id }}</td>
                    <td class="font-weight-bold text-center">
                      <img src="{{ 'storage/' . $book->cover_url }}" alt="{{ $book->title }}" style="border-radius: 0; height: 50px;">
                    </td>
                    <td class="font-weight-bold">{{ $book->title }}</td>
                    <td class="font-weight-bold">{{ $book->author ? $book->author->name : '' }}</td>
                    <td class="font-weight-bold">
                      <div class="d-flex">
                        @foreach ($book->files as $file)
                        <a href=""style="background-color: {{ $file->color }}; font-size: 10px;" class="p-2 text-white"> 
                          {{ $file->name }}
                        </a>
                        @endforeach
                      </div>
                    </td>
                    <td class="font-weight-bold">{{ $book->downloads }}</td>
                    <td class="font-weight-bold">{{ $book->rating }}</td>
                    <td class="font-weight-bold">{{ date_format(date_create($book->publish_date), 'd-m-Y') }}</td>

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
          </div>

          @if ($books)
            <div class="mt-4 d-flex justify-content-center justify-content-md-end">
              {{ $books->links() }}
            </div>
          @endif
        </div>

      </div>
    </div>

  </div>

@endsection
