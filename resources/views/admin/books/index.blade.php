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
          <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
              <a href="{{ route('books.index') }}" class="btn btn-primary btn-sm mr-2">Tất cả</a>

              <select class="custom-select custom-select-sm" style="width: 170px;" id="statusSort" name="statusSort">
                <option value="" selected>Trạng thái</option>
                <option value="active">Đang cung cấp</option>
                <option value="disabled">Ngừng cung cấp</option>
              </select>
            </div>

            <div>
              <form action="{{ route('books.sort') }}" method="GET">
                <select class="custom-select custom-select-sm mr-2" style="width: 170px;" id="downloadSort" name="downloadSort">
                  @if ($query['sort']['download'] == 'downloadDescending')

                    <option value="">Lượt tải</option>
                    <option value="downloadDescending" selected>Lượt tải giảm dần</option>
                    <option value="downloadAscending">Lượt tải tăng dần</option>

                  @elseif($query['sort']['download'] == 'downloadAscending')

                    <option value="">Lượt tải</option>
                    <option value="downloadDescending">Lượt tải giảm dần</option>
                    <option value="downloadAscending" selected>Lượt tải tăng dần</option>

                  @else

                    <option value="" selected>Lượt tải</option>
                    <option value="downloadDescending">Lượt tải giảm dần</option>
                    <option value="downloadAscending">Lượt tải tăng dần</option>

                  @endif

                </select>
    
                <select class="custom-select custom-select-sm mr-2" style="width: 170px;" id="ratingSort" name="ratingSort">
                  @if ($query['sort']['rating'] == 'ratingDescending')

                    <option value="">Đánh giá</option>
                    <option value="ratingDescending" selected>Đánh giá giảm dần</option>
                    <option value="ratingAscending">Đánh giá tăng dần</option>

                  @elseif($query['sort']['rating'] == 'ratingAscending')

                    <option value="">Đánh giá</option>
                    <option value="ratingDescending">Đánh giá giảm dần</option>
                    <option value="ratingAscending" selected>Đánh giá tăng dần</option>

                  @else

                    <option value="" selected>Đánh giá</option>
                    <option value="ratingDescending">Đánh giá giảm dần</option>
                    <option value="ratingAscending">Đánh giá tăng dần</option>

                  @endif
                </select>

                <button class="btn btn-primary btn-sm">Sắp xếp</button>
              </form>
            </div>
          </div>

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
                  <th>Trang thái</th>
                  <th>Lựa chọn</th>
                </tr>
              </thead>

              <tbody>

                @foreach ($books as $book)
                  <tr>
                    <td class="font-weight-bold" style="width: 100px;">{{ $book->id }}</td>
                    <td class="font-weight-bold text-center">
                      <img src="{{ url('storage/' . $book->cover_url) }}" alt="{{ $book->title }}"
                        style="border-radius: 0; height: 50px;">
                    </td>
                    <td class="font-weight-bold">{{ $book->title }}</td>
                    <td class="font-weight-bold">{{ $book->author ? $book->author->name : '' }}</td>
                    <td class="font-weight-bold">
                      <div class="d-flex">
                        @foreach ($book->bookFiles as $bookFile)
                        <a href="" style="background-color: {{ $bookFile->fileType->color }}; font-size: 10px;"
                            class="p-2 text-white">
                            {{ $bookFile->fileType->name }}
                          </a>
                        @endforeach
                      </div>
                    </td>
                    <td class="font-weight-bold">{{ $book->downloads }}</td>
                    <td class="font-weight-bold">{{ $book->rating }}</td>
                    <td class="font-weight-bold">{{ date_format(date_create($book->publish_date), 'd-m-Y') }}</td>
                    <td class="font-weight-bold">{{ $book->status ? 'Đang cung cấp' : 'Ngừng cung cấp' }}</td>

                    <td class="font-weight-bold">
                      <div class="d-flex justify-content-start">

                        <a href="{{ route('books.edit', ['book' => $book->id]) }}">
                          <button class="btn btn-sm btn-info mr-1">
                            <i class='fa-solid fa-chart-simple' style="font-size: .8rem;"></i>
                          </button>
                        </a>

                        @if ($book->status)
                          <x-delete-confirm-button :url="route('books.destroy', ['book' => $book->id])" :message="'thể loại ' . '<b><q>' . $book->name . '</q></b>'">
                            <i class="fa-solid fa-trash" style="font-size: .8rem;"></i>
                          </x-delete-confirm-button>
                        @else
                          <a href="" class="btn btn-success btn-sm">
                            <i class="fa-solid fa-trash-arrow-up" style="font-size: .8rem;"></i>
                          </a>
                        @endif

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

@push('js')
<script>
  const statusSortSelect = document.querySelector('#statusSort')

  statusSortSelect.addEventListener('change', (e) => {
    const sortBy = e.target.value

    if(sortBy) window.location.href = '{{ route('books.status') }}' + `?sortBy=${sortBy}`
  })
</script>
@endpush