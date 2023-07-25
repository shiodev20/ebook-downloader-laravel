@extends('partials.layouts.admin')

@section('documentTitle')
  Banner
@endsection

@section('content')
  <div class="row">

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Quản lý Banner</div>

          {{-- banner Forms --}}
          <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

            {{-- banner Search --}}
            <form id="genreSearchForm" action="{{ route('banners.search') }}" method="GET">

              <label for="#genreSearhInput">Tìm kiếm</label>
              <div class="input-group">
                <input type="text" id="genreSearhInput" class="form-control form-control-sm font-weight-bold" placeholder="Tiêu đề" name="search" value="{{ $query['search'] }}">
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
            <button class="btn btn-primary btn-icon-text" type="button" data-toggle="modal" data-target="#bannerAddModal">
              <i class='fa-solid fa-plus btn-icon-prepend'></i>Thêm Banner
            </button>

          </div>

          <hr>
           {{-- book Options --}}
           <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
              <a href="{{ route('banners.index') }}" class="btn btn-primary btn-sm mr-2">Tất cả</a>

              <select class="custom-select custom-select-sm" style="width: 170px;" id="statusSort" name="statusSort">
                <option value="" selected>Trạng thái</option>
                <option value="active">Đang cung cấp</option>
                <option value="disabled">Ngừng cung cấp</option>
              </select>
            </div>

           
          </div>


          {{-- genre Data --}}
          <div class="table-responsive">
            <table id="genreData" class="table table-hover table-striped table-bordered">

              <thead class="table-primary">
                <tr>
                  <th>STT</th>
                  <th>Hình ảnh</th>
                  <th>Tiêu đề</th>
                  <th>Trạng thái</th>
                  <th>Lựa chọn</th>
                </tr>
              </thead>

              <tbody>

                @foreach ($banners as $banner)
                  <tr>
                    <td class="font-weight-bold" style="width: 100px;">{{ $loop->index + 1 }}</td>
                    <td class="font-weight-bold text-center">
                      <img src="{{ url('storage/' . $banner->cover_url) }}" alt="{{ $banner->name }}"
                        style="border-radius: 0; height: 70px; width: 300px;">
                    </td>
                    <td class="font-weight-bold">{{ $banner->name }}</td>
                    <td class="font-weight-bold">{{ $banner->status ? 'Đang cung cấp' : 'Ngừng cung cấp' }}</td>

                    <td class="font-weight-bold">
                      <div class="d-flex justify-content-start">

                        <x-delete-confirm-button
                          :url="route('banners.destroy', ['banner' => $banner->id]) "
                          :message=" 'thể loại '.'<b><q>'.$banner->name.'</q></b>' "
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

          @if ($banners)
            <div class="mt-4 d-flex justify-content-center justify-content-md-end">
              {{ $banners->links() }}
            </div>
          @endif
        </div>

      </div>
    </div>

  </div>

  <div class="modal fade" id="bannerAddModal" tabindex="-1" aria-labelledby="bannerAddLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ route('banners.store') }}" enctype="multipart/form-data" method="POST">
          @csrf

          <div class="modal-header">
            <h5 class="modal-title" id="bannerAddLabel">Tạo Banner</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            {{-- banner name --}}
            <div class="col-sm-12">
              <div class="form-group">
                <label class="form-label font-weight-bold" for="name">Tiêu đề</label>
                <input 
                  class="form-control form-control-sm font-weight-bold" id="name" name="name"
                  style="{{ $errors->has('name') ? 'border: 1px solid #dc3545' : '' }}" type="text"
                  value="{{ old('name') }}">
                @error('name')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
            </div>

            {{-- Banner cover --}}
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
  const statusSortSelect = document.querySelector('#statusSort')

  statusSortSelect.addEventListener('change', (e) => {
    const sortBy = e.target.value

    if(sortBy) window.location.href = '{{ route('banners.sort') }}' + `?sortBy=${sortBy}`
  })
</script>
@endpush
