@extends('partials.layouts.admin')

@section('documentTitle')
  Nhà xuất bản
@endsection

@section('content')
  <div class="row">

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Quản lý nhà xuất bản</div>

          {{-- publisher Forms --}}
          <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

            {{-- publisher Search --}}
            <form id="publisherSearchForm" action="{{ route('publishers.search') }}" method="GET">

              <label for="#publisherSearhInput">Tìm kiếm nhà xuất bản</label>
              <div class="input-group">
                <input type="text" id="publisherSearhInput" class="form-control form-control-sm font-weight-bold" placeholder="Tên nhà xuất bản" name="search" value="{{ $query['search'] }}">
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

            {{-- publisher Add --}}
            <form id="publisherAddForm" action="{{ route('publishers.store') }}" method="POST">
              @csrf

              <label for="publisherAddInput">Thêm nhà xuất bản</label>
              <div class="input-group">
                <input type="text" id="publisherAddInput" class="form-control form-control-sm font-weight-bold" placeholder="Tên nhà xuất bản" name="publisher">
                <div class="input-group-append">
                  <button class="btn btn-primary btn-sm" type="submit"><i class="fa-solid fa-plus"></i></button>
                </div>
              </div>
              <div class="input-error publisher-error text-danger p-1 position-relative" style="font-size: .8rem;">
                @error('publisher')
                  <div class="position-absolute">{{ $message }}</div>
                @enderror
              </div>

            </form>

          </div>

          <hr>

          {{-- publisher Options --}}
          <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('publishers.index') }}" class="btn btn-primary btn-sm">Tất cả</a>

            <select class="custom-select custom-select-sm" style="width: 150px;" id="publisherSort">

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

          {{-- publisher Data --}}
          <div class="table-responsive">
            <table id="publisherData" class="table table-hover table-striped table-bordered">

              <thead class="table-primary">
                <tr>
                  <th>STT</th>
                  <th>Nhà xuất bản</th>
                  <th>Sách</th>
                  <th>Lựa chọn</th>
                </tr>
              </thead>

              <tbody>

                @foreach ($publishers as $publisher)
                  <tr>
                    <td class="font-weight-bold" style="width: 100px;">{{ $loop->index + 1 }}</td>
                    <td class="font-weight-bold" style="min-width: 400px; width: 400px;">
                      <form id="publisherEditForm" action="{{ route('publishers.update', ['publisher' => $publisher->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="input-group">
                          <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $publisher->name }}" name="{{ 'publisher-'.$publisher->id }}">
                          <div class="input-group-append">
                            <button class="btn btn-success btn-sm" type="submit"><i class='fa-solid fa-pen' style="font-size: .8rem;"></i></button>
                          </div>
                        </div>

                        <div class="{{'input-error text-danger p-1 position-relative'.' publisher-'.$publisher->id.'-error' }}" style="font-size: .8rem;">
                          @error('publisher-'.$publisher->id)
                            <div class="position-absolute">{{ $message }}</div>
                          @enderror
                        </div>
                      </form>
                    </td>
                    <td class="font-weight-bold">{{ $publisher->books->count() }}</td>

                    <td class="font-weight-bold">
                      <div class="d-flex justify-content-start">
                        <a class="mr-1" href="/">
                          <button class="btn btn-sm btn-info">
                            <i class='fa-solid fa-chart-simple' style="font-size: .8rem;"></i>
                          </button>
                        </a>

                        <x-delete-confirm-button
                          :url="route('publishers.destroy', ['publisher' => $publisher->id]) "
                          :message=" 'thể loại '.'<b><q>'.$publisher->name.'</q></b>' "
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

          @if ($publishers)
            <div class="mt-4 d-flex justify-content-center justify-content-md-end">
              {{ $publishers->links() }}
            </div>
          @endif
        </div>

      </div>
    </div>

  </div>

@endsection

@push('js')
  {{-- Sort publisher --}}
  <script>
    const publisherSortSelect = document.querySelector('#publisherSort')

    publisherSortSelect.addEventListener('change', (e) => {
      const sortBy = e.target.value

      if(sortBy) window.location.href = '{{ route('publishers.sort') }}' + `?sortBy=${sortBy}`
    })
  </script>

  <script>
    const inputs = [
      ...document.querySelectorAll('#publisherSearchForm input'),
      ...document.querySelectorAll('#publisherAddForm input'),
      ...document.querySelectorAll('#publisherEditForm input'),
    ]

    inputs.forEach(input => {
      input.addEventListener('input', () => {
        document.querySelector(`.${input.name}-error`).innerHTML = ''
      })
    });
  </script>
@endpush
