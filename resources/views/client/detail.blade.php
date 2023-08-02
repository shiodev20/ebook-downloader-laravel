@extends('partials.layouts.client')

@section('documentTitle')
  {{ $book->title }}
@endsection

@section('content')
  <!-- book detail -->
  <section id="bookDetail">
    <div class="container mt-5">
      <div class="row">

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

                      <div class="book-detail_info_meta_item">Tác giả: 
                        @if ($book->author_id)
                          <span><a href="{{ route('client.booksByAuthor', ['slug' => $book->author->slug]) }}">{{ $book->author->name }}</a></span> 
                        @endif 
                      </div>

                      <div class="book-detail_info_meta_item">Thể loại: 
                        <span>
                          @foreach ($book->genres as $genre)
                            <a href="{{ route('client.booksByGenre', ['slug' => $genre->slug]) }}">{{ $genre->name }}</a> {{ $loop->index < $book->genres->count() - 1 ? ',' : '' }}
                          @endforeach
                        </span> 
                      </div>

                      <div class="book-detail_info_meta_item">Nhà xuất bản: 
                        @if ($book->publisher_id)
                          <span><a href="{{ route('client.booksByPublisher', ['slug' => $book->publisher->slug]) }}">{{ $book->publisher->name }}</a></span>
                        @endif
                      </div>

                      <div class="book-detail_info_meta_item">Số trang: <span>{{ $book->num_pages }}</span></div>
                      <div class="book-detail_info_meta_item">Ngày cập nhật: <span>{{ date_format(date_create($book->publish_date), 'd-m-Y') }}</span></div>
                      <div class="book-detail_info_meta_item book-detail_info_meta_description">{{ $book->description }}</div>

                    </div>
  
                    <hr>
  
                    <div class="book-detail_info_download">
                      <div class="book-detail_info_download_text">Tải sách:</div>
                      <div class="book-detail_info_download_options d-flex flex-wrap mt-2">
                        @if ($book->status)
                        
                          {{-- is Auth --}}
                          @can('download')
                            @foreach ($book->bookFiles as $bookFile)
                              <a 
                                href="{{ route('downloads.index', ['book' => $book->id]) .'?url=' . $bookFile->file_url }}" 
                                class="book-detail_info_download_item download-btn"
                                style="background-color: {{ $bookFile->fileType->color }}"  
                              >{{ $bookFile->fileType->name }}</a>
                            @endforeach
                          @endcan

                          {{--  is Guest --}}
                          @cannot('download')
                            <div class="d-flex flex-column">
                              <h3 class="color-main fw-bold fst-italic mb-3">Vui lòng đăng nhập để tải sách</h3>

                              <div>
                                @foreach ($book->bookFiles as $bookFile)
                                  <a 
                                    class="book-detail_info_download_item"
                                    style="background-color: {{ $bookFile->fileType->color }}; cursor: pointer;"  
                                    onclick=""
                                  >{{ $bookFile->fileType->name }}</a>
                                @endforeach
                              </div>
                            </div>
                          @endcan

                        @else
                          <div class="d-flex flex-column">
                            <h3 class="color-main fw-bold fst-italic mb-3">Sách đã ngừng cung cấp</h3>

                            <div>
                              @foreach ($book->bookFiles as $bookFile)
                                <a class="book-detail_info_download_item bg-secondary">{{  $bookFile->fileType->name }}</a>
                              @endforeach
                            </div>

                          </div>
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
    </div>


  </section>


  {{-- same author books --}}
  <section id="sameAuthorBooks">
    <div class="container mt-5 shadow-sm">
      <div class="row">
        <div class="box py-4 px-4">

          <div class="box_header d-flex justify-content-between align-items-center">
            <h2 class="box_title">sách cùng tác giả</h2>
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
                          <div class="most-download-book_card_meta">{{ number_format($book->downloads, 0, '.', ',') }} luợt tải</div>
                          <div class="most-download-book_card_meta most-download-book_card_review">
                            <span>{{ $book->rating == 0 ? 0 : number_format($book->rating, 1, '.', ',') }} <i class='bx bxs-heart'></i></span>
                          </div>
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
                      <form id="reviewForm" action="{{ route('reviews.store', ['book' => $book->id]) }}" method="POST">
                        @csrf

                        <div class="mb-3 book-review_form_review">
                          <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="content" placeholder="Đánh giá"></textarea>
                          @error('content')
                            <div class="invalid-feedback d-block fs-5">{{ $message }}</div>
                          @enderror
                        </div>

                        <div class="mb-3 book-review_form_rating d-flex">
                          <div class="book-review_form_rating_item">
                            <input id="reviewAddStar1" name="rate" value="1" type="radio">
                            <label for="reviewAddStar1"><i class="bx bxs-heart"></i></label>
                          </div>

                          <div class="book-review_form_rating_item">
                            <input id="reviewAddStar2" name="rate" value="2" type="radio">
                            <label for="reviewAddStar2"><i class="bx bxs-heart"></i></label>
                          </div>

                          <div class="book-review_form_rating_item">
                            <input id="reviewAddStar3" name="rate" value="3" type="radio">
                            <label for="reviewAddStar3"><i class="bx bxs-heart"></i></label>
                          </div>

                          <div class="book-review_form_rating_item">
                            <input id="reviewAddStar4" name="rate" value="4" type="radio">
                            <label for="reviewAddStar4"><i class="bx bxs-heart"></i></label>
                          </div>

                          <div class="book-review_form_rating_item">
                            <input id="reviewAddStar5" name="rate" value="5" type="radio">
                            <label for="reviewAddStar5"><i class="bx bxs-heart"></i></label>
                          </div>

                        </div>
                        @error('rate')
                          <div class="invalid-feedback d-block fs-5">{{ $message }}</div>
                        @enderror

                        <button type="submit" class="btn btn-lg bg-main text-white">Đánh giá</button>
                      </form>
                    </div>
                  </div>

                </div>
              </div>

              <hr>

              <div id="reviewContent" class="book-review_bottom py-3">

                <div id="reviews">

                </div>

                <div id="reviewPagination" class="mt-4 d-flex justify-content-center justify-content-md-end">
                  <nav>
                    <ul class="pagination">
                      
                    </ul>
                  </nav>
                 
                </div>

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
                          <div class="most-download-book_card_meta">{{ number_format($book->downloads, 0, '.', ',') }} luợt tải</div>
                          <div class="most-download-book_card_meta most-download-book_card_review">
                            <span>{{ $book->rating == 0 ? 0 : number_format($book->rating, 1, '.', ',') }} <i class='bx bxs-heart'></i></span>
                          </div>
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
                          <div class="most-download-book_card_meta">{{ number_format($book->downloads, 0, '.', ',') }} luợt tải</div>
                          <div class="most-download-book_card_meta most-download-book_card_review">
                            <span>{{ $book->rating == 0 ? 0 : number_format($book->rating, 1, '.', ',') }} <i class='bx bxs-heart'></i></span>
                          </div>
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


  <!-- Review Update Modal -->
  <div class="modal fade" id="reviewUpdateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        

      </div>
    </div>
  </div>


  {{-- Toast --}}
  <x-toast>
    <div class="toast-message_title">- Bạn đã tải sách <span>"{{ $book->title }}"</span></div>
    <div class="toast-message_desc">Nếu bạn có điều kiện, hãy mua sách giấy để ủng hộ tác giả và nhà xuất bản nhé!</div>
  </x-toast>
@endsection

@push('js')
  <script src="{{ asset('frontend/js/sliders/bookSlider.js') }}"></script>

  {{-- Fetching Review --}}
  <script>
    function getPagination(url) {

      displayLoading('#reviewContent')

      fetch(url)
      .then(response => response.json())
      .then(result => {
        hideLoading('#reviewContent')

        const container = document.querySelector('#reviewContent')
        container.innerHTML = 
        `
          <div id="reviews">
          </div>

          <div id="reviewPagination" class="mt-4 d-flex justify-content-center justify-content-md-end">
            <nav>
              <ul class="pagination">
                
              </ul>
            </nav>
          </div>
        `

        if(result.data.length > 0) {

          const reviews = document.querySelector('#reviewContent #reviews')
          reviews.innerHTML = ''
      
          result.data.forEach((item, idx) => {
            let reviewRating = ``;
            for (let i = 1; i <= 5; i++) {
              if(i <= Number(item.rate))  reviewRating += '<i class="bx bxs-heart"></i>';
              else reviewRating+= '<i class="bx bxs-heart" style="color: #6C757D"></i>';    
            }
            
            let options = ''
            const deleteUrl = '{{ url('/reviews') }}' + `/${item.id}`

            options = item.user_id == `{{ session()->has('currentUser') ? session('currentUser')['id'] : 0 }}`
            ? 
            `
              <button class="btn p-0" onclick="handleUpdateReviewModal(${item.id})" role="button" data-bs-toggle="modal" data-bs-target="#reviewUpdateModal"><i class='bx bxs-edit'></i></button>
              <form action="${deleteUrl}" method="POST" class="d-inline">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn p-0 ms-1"><i class='bx bxs-trash'></i></button>
              </form>
            `
            : ''

            const review = 
            `
              <div class="book-review_review pb-5">
                <div class="row g-4">
      
                  <div class="col-sm-12 col-md-3">
                    <div class="book-review_review_author d-flex flex-row flex-md-column justify-content-between align-items-center align-items-md-start">
                      <div
                        class="book-review_review_author_item d-flex flex-row flex-md-column align-items-center  align-items-md-start">
                        <span class="p-1 fs-4 fw-bold">${ item.username }</span>
                      </div>
                      <span class="book-review_review_author_item p-1">${item.createdAt}</span>
                    </div>
                  </div>
      
                  <div class="col-sm-12 col-md-9">
                    <div class="book-review_review_rating">
                      ${reviewRating}
                    </div>

                    <div class="book-review_review_content">
                      <p>${item.content}</p>
                    </div>

                    <div class="book-review_review_options">
                      ${options}
                    </div>
                  
                  </div>
                </div>
              </div>
            `
      
            reviews.innerHTML += review
          })
      
          const pagination = document.querySelector('#reviewPagination .pagination')
          pagination.innerHTML = ''
    
          result.links.forEach((link, idx) => {
            let linkElement = ``;
      
            if(idx == 0) {
              linkElement = 
              `
                <li class="page-item ${link.url ? '' : 'disabled'}" style="cursor: pointer;">
                  <a class="page-link" onclick="getPagination('${link.url ? link.url : ''}')"><i class='bx bx-chevron-left'></i></a>
                </li>
              `
            }
            else if(idx == result.links.length - 1) {
              linkElement = 
              `
                <li class="page-item ${link.url ? '' : 'disabled'}" style="cursor: pointer;">
                  <a class="page-link" onclick="getPagination('${link.url ? link.url : ''}')"><i class='bx bx-chevron-right'></i></a>
                </li>
              `
            }
            else {
              linkElement = 
              `
                <li class="page-item ${link.active ? 'active' : ''}" style="cursor: pointer;">
                  <a class="page-link" onclick="getPagination('${link.url ? link.url : ''}')">${link.label}</a>
                </li>
              `
            }
            
            pagination.innerHTML += linkElement
          })

        }

      })
    }

    document.addEventListener('DOMContentLoaded', () => {
      const url = '{{ route('ajax.bookReviews', ['book' => $book->id]) }}' + '?page=1'
      getPagination(url);
    })
  </script>

  {{-- Clear create review validation --}}
  <script>
    const reviewTextarea = document.querySelector('#reviewForm textarea[name=content]')
    const rateRadios = document.querySelectorAll('#reviewForm input[name=rate]')

    reviewTextarea.addEventListener('input', () => {
      const invalidFeedback = document.querySelector('textarea[name=content] + .invalid-feedback')
      if(invalidFeedback) {
        invalidFeedback.style.visibility = 'hidden'
        invalidFeedback.style.height = '0px'
      }
    })

    rateRadios.forEach(radio => {
      radio.addEventListener('change', () => {
        const invalidFeedback = document.querySelector('.book-review_form_rating + .invalid-feedback')
        if(invalidFeedback) {
          invalidFeedback.style.visibility = 'hidden'
          invalidFeedback.style.height = '0px'
        }
      })
    })
  </script>

  {{-- Update review --}}
  <script>
    function handleUpdateReviewModal(reviewId) {
      const url = `{{ url('/reviews') }}` + `/${reviewId}`

      fetch(url)
      .then(response => response.json())
      .then(data => {
        const reviewUpdateModal = document.querySelector('#reviewUpdateModal .modal-content')

        const url = '{{ url('/reviews') }}' + `/${data.id}`;

        reviewUpdateModal.innerHTML =
        `
          <form id="reviewUpdateForm" action="${url}" method="POST">
            @method('PUT')
            @csrf

            <div class="modal-header">
              <h5 class="modal-title" id="reviewUpdateModalLabel">Cập nhật đánh giá</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3 book-review_form_review">
                  <textarea class="form-control" rows="3" name="content" placeholder="Đánh giá">${ data.content }</textarea>
                </div>

                <div class="mb-3 book-review_form_rating d-flex">
                  <div class="book-review_form_rating_item">
                    <input id="reviewUpdateStar1" name="rate" value="1" type="radio">
                    <label for="reviewUpdateStar1"><i class="bx bxs-heart"></i></label>
                  </div>

                  <div class="book-review_form_rating_item">
                    <input id="reviewUpdateStar2" name="rate" value="2" type="radio">
                    <label for="reviewUpdateStar2"><i class="bx bxs-heart"></i></label>
                  </div>

                  <div class="book-review_form_rating_item">
                    <input id="reviewUpdateStar3" name="rate" value="3" type="radio">
                    <label for="reviewUpdateStar3"><i class="bx bxs-heart"></i></label>
                  </div>

                  <div class="book-review_form_rating_item">
                    <input id="reviewUpdateStar4" name="rate" value="4" type="radio">
                    <label for="reviewUpdateStar4"><i class="bx bxs-heart"></i></label>
                  </div>

                  <div class="book-review_form_rating_item">
                    <input id="reviewUpdateStar5" name="rate" value="5" type="radio">
                    <label for="reviewUpdateStar5"><i class="bx bxs-heart"></i></label>
                  </div>

                </div>
                @error('rate')
                  <div class="invalid-feedback d-block fs-5">{{ $message }}</div>
                @enderror
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary fs-5" data-bs-dismiss="modal">Đóng</button>
              <button type="submit" class="btn bg-main text-white fs-5">Cập nhật</button>
            </div>

          </form>
        `

        const updateRatingInputs = document.querySelectorAll('#reviewUpdateForm .book-review_form_rating input[type=radio]')
        updateRatingInputs.forEach(input => {
          input.addEventListener('change', () => {
            const value = input.value
            
            for (let i = 1; i <= updateRatingInputs.length; i++) {
              const inputIcon = updateRatingInputs[i - 1].nextElementSibling.firstChild;
              inputIcon.style.color = '#6c757d';
            }

            for (let i = 1; i <= value; i++) {
              const inputIcon = updateRatingInputs[i - 1].nextElementSibling.firstChild;
              inputIcon.style.color = '#fe7e73';
            }
          })
        })
      })
    }
  </script>

  {{-- Toast --}}
  <script>
    const downloadBtns = document.querySelectorAll('.download-btn')
    downloadBtns.forEach(button => {
      button.addEventListener('click', () => {
        const toastMessage = document.querySelector('.toast-message')
        toastMessage.style.left = '2rem';

        setTimeout(() => {
          toastMessage.style.left = '-90rem';
        }, 5000);
        
      })
    })
  </script>
@endpush
