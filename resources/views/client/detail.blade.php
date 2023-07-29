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
                    ({{ $book->reviews->count() }} đánh giá) | {{ number_format($book->downloads, 0,'.', ',') }} lượt tải
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


  {{-- same author books --}}
  <section id="sameAuthorBooks">
    <div class="container mt-5 shadow-sm">
      <div class="row">
        <div class="box py-4 px-4">

          <div class="box_header d-flex justify-content-between align-items-center">
            <h2 class="box_title">sách cùng tác giả</h2>
            <a href="./list.html" class="box_getAll">xem thêm</a>
          </div>

          <div>
            <hr class="divider">
          </div>

          <div class="box_content">
            <div class="slider swiper py-3" id="bookSlider">
              <div class="swiper-wrapper slider_wrapper">

                @foreach ($sameAuthorBooks as $sameAuthorBook)
                  <div class="swiper-slide slider_item">
                    <div class="book-card">
                      <a href="{{ route('client.detail', ['slug' => $sameAuthorBook->slug]) }}">

                        <div class="book-card_image">
                          <img src="{{ url('storage/' . $sameAuthorBook->cover_url) }}" loading="lazy" />
                          <div class="swiper-lazy-preloader"></div>
                        </div>

                        <div class="book-card_labels">
                          @foreach ($sameAuthorBook->files as $file)
                            <div class="book-card_label" style="background-color: {{ $file->color }}">{{ $file->name }}</div>
                          @endforeach
                        </div>

                        <div class="book-card_info">
                          <div class="book-card_info_title">{{ $sameAuthorBook->title }}</div>
                          <div class="book-card_info_meta">{{ $sameAuthorBook->author ? $book->author->name : '' }}</div>
                        </div>

                      </a>
                    </div>
                  </div>
                @endforeach

              </div>

              <div class="slider_navigation slider_navigation--prev">
                <i class="bx bx-chevron-left"></i>
              </div>
              <div class="slider_navigation slider_navigation--next">
                <i class="bx bx-chevron-right"></i>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
  </section>


  {{-- Reviews --}}
  <section id="reviews">
    <div class="container mt-5">
      <div class="row">
        <div class="box py-4 px-4">

          <div class="box_header d-flex justify-content-between align-items-center">
            <h2 class="box_title">đánh giá sách</h2>
          </div>

          <div>
            <hr class="divider">
          </div>

          <div class="box_content">
            <div class="book-review">

              <div class="book-review_top py-3">
                <div class="row g-4">

                  <div class="col-sm-12 col-md-3">
                    <div class="book-review_rating d-flex flex-column justify-content-center align-items-center h-100">
                      <span class="book-review_rating_item book-review_rating_avg"><i class="bx bxs-heart"></i> {{ $book->rating }}</span>
                      <span class="book-review_rating_item book-review_rating_review-count">({{ $book->reviews->count() }} đánh giá)</span>
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-9">
                    <div class="book-review_form">
                      <form action="/">
                        <div class="mb-3 book-review_form_review">
                          <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="review"
                            placeholder="Đánh giá"></textarea>
                        </div>

                        <div class="mb-3 book-review_form_rating d-flex">
                          <div class="book-review_form_rating_item">
                            <input id="star1" name="rating" value="1" type="radio">
                            <label for="star1"><i class="bx bxs-heart"></i></label>
                          </div>

                          <div class="book-review_form_rating_item">
                            <input id="star2" name="rating" value="2" type="radio">
                            <label for="star2"><i class="bx bxs-heart"></i></label>
                          </div>

                          <div class="book-review_form_rating_item">
                            <input id="star3" name="rating" value="3" type="radio">
                            <label for="star3"><i class="bx bxs-heart"></i></label>
                          </div>

                          <div class="book-review_form_rating_item">
                            <input id="star4" name="rating" value="4" type="radio">
                            <label for="star4"><i class="bx bxs-heart"></i></label>
                          </div>

                          <div class="book-review_form_rating_item">
                            <input id="star5" name="rating" value="5" type="radio">
                            <label for="star5"><i class="bx bxs-heart"></i></label>
                          </div>

                        </div>

                        <button type="submit" class="btn btn-lg bg-main text-white">Đánh giá</button>
                      </form>
                    </div>
                  </div>

                </div>
              </div>

              <hr>

              <div class="book-review_bottom py-3">

                @foreach ($reviews as $review)
                <div class="book-review_review pb-5">
                  <div class="row g-4">

                    <div class="col-sm-12 col-md-3">
                      <div class="book-review_review_author d-flex flex-row flex-md-column justify-content-between">
                        <div
                          class="book-review_review_author_item d-flex flex-row flex-md-column align-items-center  align-items-md-start">
                          <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32"
                            class="rounded-circle p-1">
                          <span class="p-1">{{ $review->user->username}}</span>
                        </div>
                        <span class="book-review_review_author_item p-1">{{ date_format(date_create($review->created_at), 'd-m-Y') }}</span>
                      </div>
                    </div>

                    <div class="col-sm-12 col-md-9">
                      <div class="book-review_review_rating">
                        @php
                          for ($i=1; $i <= 5; $i++) {
                            if($i <= $book->rating)  echo('<i class="bx bxs-heart"></i>');
                            else echo('<i class="bx bxs-heart" style="color: #6C757D"></i>');
                          }
                        @endphp
                      </div>
                      <div class="book-review_review_content">
                        <p>{{ $review->content }}</p>
                      </div>
                    </div>
                  </div>
                </div>   
                @endforeach

                @if ($reviews)
                  <div class="mt-4 d-flex justify-content-center justify-content-md-end">
                    {{ $reviews->links() }}
                  </div>
                @endif

              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
  </section>


  {{-- same genre books --}}
  <section id="sameGenreBooks">
    <div class="container mt-5 shadow-sm">
      <div class="row">
        <div class="box py-4 px-4">

          <div class="box_header d-flex justify-content-between align-items-center">
            <h2 class="box_title">sách cùng thể loại</h2>
            <a href="./list.html" class="box_getAll">xem thêm</a>
          </div>

          <div>
            <hr class="divider">
          </div>

          <div class="box_content">
            <div class="slider swiper py-3" id="bookSlider">
              <div class="swiper-wrapper slider_wrapper">

                @foreach ($sameGenreBooks as $sameGenreBook)
                  <div class="swiper-slide slider_item">
                    <div class="book-card">
                      <a href="{{ route('client.detail', ['slug' => $sameGenreBook->slug]) }}">

                        <div class="book-card_image">
                          <img src="{{ url('storage/' . $sameGenreBook->cover_url) }}" loading="lazy" />
                          <div class="swiper-lazy-preloader"></div>
                        </div>

                        <div class="book-card_labels">
                          @foreach ($sameGenreBook->files as $file)
                            <div class="book-card_label" style="background-color: {{ $file->color }}">{{ $file->name }}</div>
                          @endforeach
                        </div>

                        <div class="book-card_info">
                          <div class="book-card_info_title">{{ $sameGenreBook->title }}</div>
                          <div class="book-card_info_meta">{{ $sameGenreBook->author ? $sameGenreBook->author->name : '' }}</div>
                        </div>

                      </a>
                    </div>
                  </div>
                @endforeach

              </div>

              <div class="slider_navigation slider_navigation--prev">
                <i class="bx bx-chevron-left"></i>
              </div>
              <div class="slider_navigation slider_navigation--next">
                <i class="bx bx-chevron-right"></i>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
  </section>


  {{-- recommend books --}}
  <section id="recommendBooks">
    <div class="container mt-5 shadow-sm">
      <div class="row">
        <div class="box py-4 px-4">

          <div class="box_header d-flex justify-content-between align-items-center">
            <h2 class="box_title">Có thể bạn sẽ thích</h2>
            <a href="./list.html" class="box_getAll">xem thêm</a>
          </div>

          <div>
            <hr class="divider">
          </div>

          <div class="box_content">
            <div class="slider swiper py-3" id="bookSlider">
              <div class="swiper-wrapper slider_wrapper">

                @foreach ($recommendBooks as $recommendBook)
                  <div class="swiper-slide slider_item">
                    <div class="book-card">
                      <a href="{{ route('client.detail', ['slug' => $recommendBook->slug]) }}">

                        <div class="book-card_image">
                          <img src="{{ url('storage/' . $recommendBook->cover_url) }}" loading="lazy" />
                          <div class="swiper-lazy-preloader"></div>
                        </div>

                        <div class="book-card_labels">
                          @foreach ($recommendBook->files as $file)
                            <div class="book-card_label" style="background-color: {{ $file->color }}">{{ $file->name }}</div>
                          @endforeach
                        </div>

                        <div class="book-card_info">
                          <div class="book-card_info_title">{{ $recommendBook->title }}</div>
                          <div class="book-card_info_meta">{{ $recommendBook->author ? $recommendBook->author->name : '' }}</div>
                        </div>

                      </a>
                    </div>
                  </div>
                @endforeach

              </div>

              <div class="slider_navigation slider_navigation--prev">
                <i class="bx bx-chevron-left"></i>
              </div>
              <div class="slider_navigation slider_navigation--next">
                <i class="bx bx-chevron-right"></i>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
@endsection

@push('js')
<script src="{{ asset('frontend/js/sliders/bookSlider.js') }}"></script>
@endpush