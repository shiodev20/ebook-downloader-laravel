@extends('partials.layouts.client')

@section('documentTitle')
  {{ $book->title }}
@endsection

@section('content')
  <!-- book dtail -->
  <section>
    <div class="container mt-5">
      <div class="box">
        <div class="box_content">
          <div class="book-detail">
            <div class="row g-4">

              <div class="col-sm-12 col-md-4">
                <div class="book-detail_cover">
                  <img src="{{ url('storage/'.$book->cover_url) }}" alt="{{ $book->title }}">
                </div>
              </div>

              <div class="col-sm-12 col-md-8">
                <div class="book-detail_info">

                  <div class="book-detail_info_title">{{$book->title }}</div>

                  <div class="book-detail_info_rating">
                    <span><i class="bx bxs-heart"></i> {{ $book->rating == 0 ? '0' : $book->rating }}</span> 
                    (303 đánh giá) | {{ number_format($book->downloads, 0,'.', ',') }} lượt tải
                  </div>

                  <div class="book-detail_info_meta">
                    <div class="book-detail_info_meta_item">Tác giả: <span><a href="/">{{ $book->author ? $book->author->name : '' }}</a></span> </div>
                    <div class="book-detail_info_meta_item">Thể loại: 
                      <span>
                        @foreach ($book->genres as $genre)
                          <a href="/">{{ $genre->name }}</a> {{ $loop->index < $book->genres->count() - 1 ? ',' : '' }}
                        @endforeach
                      </span> 
                    </div>
                    <div class="book-detail_info_meta_item">Nhà xuất bản: <span><a href="/">{{ $book->publisher ? $book->publisher->name : '' }}</a></span></div>
                    <div class="book-detail_info_meta_item">Số trang: <span>{{ $book->num_pages }}</span></div>
                    <div class="book-detail_info_meta_item">Ngày cập nhật: <span>{{ date_format(date_create($book->publish_date), 'd-m-Y') }}</span></div>
                    <div class="book-detail_info_meta_item book-detail_info_meta_description">{{ $book->description }}</div>
                  </div>

                  <hr>

                  <div class="book-detail_info_download">
                    <div class="book-detail_info_download_text">Tải sách:</div>
                    <div class="book-detail_info_download_options d-flex flex-wrap mt-2">

                      @if ($book->bookFiles->count() > 0 && $book->status) 

                        @foreach ($book->bookFiles as $bookFile)
                          <a 
                            href="{{ route('downloads.index', ['book' => $book->id]) .'?url=' . $bookFile->file_url }}" 
                            class="book-detail_info_download_item"
                            style="background-color: {{ $bookFile->fileType->color }}"  
                          >{{ $bookFile->fileType->name }}</a>
                        @endforeach
                      
                      @endif

                      @if ($book->bookFiles->count() == 0 || !$book->status)
                        @foreach ($fileTypes as $fileType)
                          <a class="book-detail_info_download_item bg-secondary">{{ $fileType->name }}</a>
                        @endforeach
                      @endif
                        
                    </div>
                  </div>

                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection

