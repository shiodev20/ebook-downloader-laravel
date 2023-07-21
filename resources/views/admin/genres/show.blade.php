@extends('partials.layouts.admin')

@section('documentTitle')
 {{ $genre->name }}   
@endsection

@section('content')
<div class="row">

  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="card-title">Thể loại sách "{{ $genre->name }}"</div>


        {{-- genre Data --}}
        {{-- <div class="table-responsive">
          <table id="genreData" class="table table-hover table-striped table-bordered">

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
                      <a class="mr-1" href="/">
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
              @endforeach

            </tbody>

          </table>
        </div> --}}

        {{-- @if ($genres)
          <div class="mt-4 d-flex justify-content-center justify-content-md-end">
            {{ $genres->links() }}
          </div>
        @endif --}}
      </div>

    </div>
  </div>

</div>    
@endsection
