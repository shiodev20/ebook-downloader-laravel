@extends('partials.layouts.admin')

@section('documentTitle')
 {{ $collection->name }}   
@endsection

@section('content')
<div class="row">

  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="card-title">Tuyển tập "{{ $collection->name }}"</div>

        <form action="{{ route('collections.update', ['collection' => $collection->id]) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="row">

            <div class="col-sm-12 mb-3">
              <div class="form-group mb-1">
                <label class="form-label font-weight-bold" for="name">Tên tuyển tập</label>
                <input class="form-control form-control-sm font-weight-bold" name="name" value="{{ $collection->name }}">
              </div>
              @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
  
            <div class="col-sm-12 mb-3">
              <div class="form-group mb-0">
                <label class="form-label font-weight-bold" for="bookCover">Ảnh bìa <small><i>(png/jpeg)</i></small></label>
                <div>
                  <input type="file" name="cover" class="file-upload-default" onchange="preview_imageBook()" id="bookCoverInput" value="{{ url('/storage/' . $collection->cover_url) }}">
                  <div class="input-group col-xs-12 mb-1">
                    <button class="file-upload-browse btn btn-primary btn-sm" type="button">Tải ảnh</button>
                  </div>
                  <img 
                    id="bookCoverRender" 
                    class="rounded border" 
                    src="{{ url('/storage/' . $collection->cover_url) }}"
                    width="500px"
                    height="150px" />
                </div>
  
                @error('cover')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <button type="submit" class="btn btn-success btn-block">Cập nhật</button>
            
          </div>
        </form>

        <hr>
        <div class="row">
          <div class="col-sm-2 mb-3">
            <div class="form-group mb-1">
              <label class="form-label font-weight-bold" for="title">Số lượng sách</label>
              <input class="form-control form-control-sm font-weight-bold" value="{{ $books->count() }}" readonly>
            </div>
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
                  <td class="font-weight-bold">
                    <div class="d-flex">
                      @foreach ($book->bookFiles as $bookFile)
                      <a href="{{ route('downloads.index', ['book' => $book->id]) .'?url=' . $bookFile->file_url }}" style="background-color: {{ $bookFile->fileType->color }}; font-size: 10px;"
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

                      
                      <x-delete-confirm-button
                          :url="route('collections.deleteBook', ['collection' => $collection->id, 'book' => $book->id]) "
                          :message=" 'sách '.'<b><q>'.$book->title.'</q></b> ' . 'Khỏi thể loại ' . '<b><q>'.$collection->name.'</q></b>' "
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
