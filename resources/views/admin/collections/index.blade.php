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

          {{-- collection Forms --}}
          <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

            {{-- collection Search --}}
            <form id="genreSearchForm" action="{{ route('collections.search') }}" method="GET">

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
          <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('collections.index') }}" class="btn btn-primary btn-sm">Tất cả</a>

            <select class="custom-select custom-select-sm" style="width: 150px;" id="collectionSort">

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

          <hr>

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

                @foreach ($collections as $collection)
                  <tr>
                    <td class="font-weight-bold" style="width: 100px;">{{ $loop->index + 1 }}</td>
                    <td class="font-weight-bold text-center">
                      <img src="{{ url('storage/' . $collection->cover_url) }}" alt="{{ $collection->name }}"
                        style="border-radius: 0; height: 70px; width: 80%;">
                    </td>
                    <td class="font-weight-bold">{{ $collection->name }}</td>
                    <td class="font-weight-bold">{{ $collection->books->count() }}</td>

                    <td class="font-weight-bold">
                      <div class="d-flex justify-content-start">
                        <a class="mr-1" href="{{ route('collections.show', ['collection' => $collection->id]) }}">
                          <button class="btn btn-sm btn-info">
                            <i class='fa-solid fa-chart-simple' style="font-size: .8rem;"></i>
                          </button>
                        </a>

                        <x-delete-confirm-button
                          :url="route('collections.destroy', ['collection' => $collection->id]) "
                          :message=" 'tuyển tập '.'<b><q>'.$collection->name.'</q></b>' "
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

          @if ($collections)
            <div class="mt-4 d-flex justify-content-center justify-content-md-end">
              {{ $collections->links() }}
            </div>
          @endif
        </div>

      </div>
    </div>

  </div>

  <div class="modal fade" id="collectionAddModal" tabindex="-1" aria-labelledby="collectionAddLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ route('collections.store') }}" enctype="multipart/form-data" method="POST">
          @csrf

          <div class="modal-header">
            <h5 class="modal-title" id="collectionAddLabel">Tạo tuyển tập sách</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            {{-- Collection name --}}
            <div class="col-sm-12">
              <div class="form-group">
                <label class="form-label font-weight-bold" for="name">Tên tuyển tập</label>
                <input 
                  class="form-control form-control-sm font-weight-bold" id="name" name="name"
                  style="{{ $errors->has('name') ? 'border: 1px solid #dc3545' : '' }}" type="text"
                  value="{{ old('name') }}">
                @error('name')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label class="form-label font-weight-bold" for="bookCover">Ảnh bìa <small><i>(png/jpeg)</i></small></label>
                <div>
                  <input type="file" name="cover" class="file-upload-default" onchange="preview_imageBook()" id="bookCoverInput">
                  <div class="input-group col-xs-12 mb-1">
                    <button class="file-upload-browse btn btn-primary btn-sm" type="button">Tải ảnh</button>
                  </div>
                  <img class="border" id="bookCoverRender" src="{{ old('cover') ? old('cover') : asset('images/book-cover-default.jpg') }}" width="100%" height="100px" />
                </div>

                @error('cover')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
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
  const collectionSortSelect = document.querySelector('#collectionSort')

  collectionSortSelect.addEventListener('change', (e) => {
    const sortBy = e.target.value

    if(sortBy) window.location.href = '{{ route('collections.sort') }}' + `?sortBy=${sortBy}`
  })
</script>
@endpush
