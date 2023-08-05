@extends('partials.layouts.client')

@section('documentTitle')
  Trang chủ    
@endsection

@section('content')
  {{-- banner --}}
  <section id="banner">
    <div class="container p-0">
      <div class="slider swiper" id="bannerSlider">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <img src="{{ asset('images/banner-1.jpg') }}" alt="" style="width: 100%;">
          </div>
          <div class="swiper-slide">
            <img src="{{ asset('images/banner-2.jpg') }}" alt="" style="width: 100%;">
          </div>
          <div class="swiper-slide">
            <img src="{{ asset('images/banner-3.png') }}" alt="" style="width: 100%;">
          </div>
        </div>

        <div class="slider_navigation slider_navigation--prev">
          <i class="bx bx-chevron-left"></i>
        </div>
        <div class="slider_navigation slider_navigation--next">
          <i class="bx bx-chevron-right"></i>
        </div>

      </div>
    </div>
  </section>

  {{-- newest books --}}
  <section id="newestBooks">
    <div class="container mt-5 shadow-sm">
      <div class="row">
        <div class="box py-4 px-4">

          <div class="box_header d-flex justify-content-between align-items-center">
            <h2 class="box_title">sách mới nhất</h2>
            <a href="{{ route('client.booksByCollection', ['slug' => 'sach-moi-nhat']) }}" class="box_getAll">xem thêm</a>
          </div>

          <div>
            <hr class="divider">
          </div>

          <div class="box_content">
            <div class="slider swiper py-3" id="bookSlider">
              <div class="swiper-wrapper slider_wrapper">

                @foreach ($newestBooks as $book)
                  <div class="swiper-slide slider_item">
                    <div class="book-card">
                      <a href="{{ route('client.detail', ['slug' => $book->slug]) }}">

                        <div class="book-card_image">
                          <img src="{{ url('storage/' . $book->cover_url) }}" loading="lazy" />
                          <div class="swiper-lazy-preloader"></div>
                        </div>

                        <div class="book-card_labels">
                          @foreach ($book->files as $file)
                            <div class="book-card_label" style="background-color: {{ $file->color }}">{{ $file->name }}</div>
                          @endforeach
                        </div>

                        <div class="book-card_info">
                          <div class="book-card_info_title">{{ $book->title }}</div>
                          <div class="book-card_info_meta">{{ $book->author ? $book->author->name : '' }}</div>
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

  {{-- most download books --}}
  <section id="mostDownloadBooks">
    <div class="container mt-5 p-0">
      <div class="row">
        <div class="col">
          <div class="box py-4 px-4"  style="min-width: 300px !important;">

            <div class="box-header d-flex justify-content-between align-items-center flex-column flex-md-row">
              <h2 class="box_title my-3" class="flex-basis: 300px !important;">sách tải nhiều nhất</h2>

              <ul class="read-most_nav nav nav-pills flex-md-nowrap" style="overflow-x: scroll; max-width: 900px;">
                <li class="read-most_nav_item nav-item text-nowrap" onclick="getMostDownloadBooks()">
                  <a class="read-most_nav_link nav-link active genre-{{'all'}}"  aria-current="page" style="cursor: pointer">Tất Cả</a>
                </li>
                @foreach ($genres as $genre)
                  <li class="read-most_nav_item nav-item text-nowrap" onclick="getMostDownloadBooks('{{ $genre->id }}')">
                    <a class="read-most_nav_link nav-link genre-{{$genre->id}}" style="cursor: pointer">{{ $genre->name }}</a>
                  </li>
                @endforeach
              </ul>

            </div>

            <div>
              <hr class="divider">
            </div>

            <div class="box-content">
              <div class="row g-4">

                @foreach ($mostDownloadBooks as $book)
                  <div class="col-12 col-md-6 col-lg-4">
                    <div class="most-download-book_card">
                      <a href="{{ route('client.detail', ['slug' => $book->slug]) }}" class="d-flex">
                        <img src="{{ url('storage/' . $book->cover_url) }}" alt="" class="most-download-book_card_cover">

                        <div class="most-download-book_card_info ms-4 flex-grow-1">
                          <div class="most-download-book_card_title">{{ $book->title }}</div>
                          <div class="most-download-book_card_meta">{{ $book->author ? $book->author->name : '' }}</div>

                          <div class="most-download-book_card_meta most-download-book_card_review">
                            <span>{{ $book->rating == 0 ? 0 : number_format($book->rating, 1, '.', ',') }} <i class='bx bxs-heart'></i></span>
                          </div>

                          <div class="most-download-book_card_meta">{{ number_format($book->downloads, 0, '.', ',') }} luợt tải</div>

                          <div
                            class="most-download-book_card_meta most-download-book_card_labels d-flex align-items-center flex-wrap">
                            @foreach ($book->files as $file)
                              <div class="most-download-book_card_label" style="background-color: {{ $file->color }}">{{ $file->name }}</div>
                            @endforeach
                          </div>

                        </div>
                      </a>
                    </div>
                  </div> 
                @endforeach

                <div class="text-center">
                  <a href="{{ route('client.booksByCollection', ['slug' => 'sach-tai-nhieu-nhat']).'?genre=all' }}" class="box_getAll">xem thêm</a>
                </div>
              </div>
            </div>


          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Quote -->
  <section id="quote">
    <div class="container-fluid bg-main mt-5">
      <div class="container p-0">

        <div class="slider swiper quote" id="quoteSlider">
          <div class="quote_ico quote_ico--left"><i class='bx bxs-quote-left'></i></div>
          <div class="quote_ico quote_ico--right"><i class='bx bxs-quote-right'></i></div>

          <div class="swiper-wrapper quote_wrapper">
            @foreach ($quotes as $quote)
              <div class="swiper-slide quote_item">
                <p class="quote_text text-white">{{ $quote->content }}</p>
                <p class="quote_author">{{ $quote->author }}</p>
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
  </section>

  {{-- recommend books --}}
  <section id="recommendBooks">
    <div class="container mt-5 shadow-sm">
      <div class="row">
        <div class="box py-4 px-4">

          <div class="box_header d-flex justify-content-between align-items-center">
            <h2 class="box_title">sách hay nên đọc</h2>
            <a href="{{ route('client.booksByCollection', ['slug' => 'sach-hay-nen-doc'])}}" class="box_getAll">xem thêm</a>
          </div>

          <div>
            <hr class="divider">
          </div>

          <div class="box_content">
            <div class="slider swiper py-3" id="bookSlider">
              <div class="swiper-wrapper slider_wrapper">

                @foreach ($recommendBooks as $book)
                  <div class="swiper-slide slider_item">
                    <div class="book-card">
                      <a href="{{ route('client.detail', ['slug' => $book->slug]) }}">

                        <div class="book-card_image">
                          <img src="{{ url('storage/' . $book->cover_url) }}" loading="lazy" />
                          <div class="swiper-lazy-preloader"></div>
                        </div>

                        <div class="book-card_labels">
                          @foreach ($book->files as $file)
                            <div class="book-card_label" style="background-color: {{ $file->color }}">{{ $file->name }}</div>
                          @endforeach
                        </div>

                        <div class="book-card_info">
                          <div class="book-card_info_title">{{ $book->title }}</div>
                          <div class="book-card_info_meta">{{ $book->author ? $book->author->name : '' }}</div>
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

  <!-- collection book -->
  <section id="collection">
    <div class="container mt-5 shadow-sm">
      <div class="row">
        <div class="box py-4 px-4">

          <div class="box_header d-flex justify-content-between align-items-center">
            <h2 class="box_title">tuyển tập hay</h2>
            <a href="{{ route('client.collections') }}" class="box_getAll">xem thêm</a>
          </div>

          <div>
            <hr class="divider">
          </div>

          <div class="box_content">
            <div class="slider swiper py-3" id="collectionSlider">
              <div class="swiper-wrapper slider_wrapper">


                @foreach ($collections as $collection)
                  <div class="swiper-slide slider_item">
                    <div class="collection-card">
                      <a href="{{ route('client.booksByCollection', ['slug' => 'tuyen-tap-hay']).'?collection='.$collection->slug }}">
                        <img class="collection-card_cover" src="{{ url('storage/' . $collection->cover_url) }}" />
                        <div class="collection-card_label"><span>{{ $collection->books->count() }}</span></div>
                        <div class="collection-card_text"><p>{{ $collection->name }}</p></div>
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

 {{-- Random book --}}
 @if ($randomBook)
  <x-toast>
    <a href="{{ route('client.detail', ['slug' => $randomBook->slug]) }}">
      <div class="book-card_horizontal">
        <h1 class="book-card_horizontal_title">Sách cho ngày mới</h1>
        <div class="book-card_horizontal_info">
          <img class="book-card_horizontal_info_image" src="{{ url('storage/'.$randomBook->cover_url) }}" alt="{{ $randomBook->title }}">

          <div class="book-card_horizontal_info_meta">
            <div class="book-card_horizontal_info_meta_item">Tên sách: <span>{{ $randomBook->title }}</span></div>
            <div class="book-card_horizontal_info_meta_item">Tác giả: <span>{{ $randomBook->author ? $randomBook->author->name : '' }}</span></div>
            <div class="book-card_horizontal_info_meta_item">Thể loại: 
              <span>
                @foreach ($randomBook->genres as $genre)
                  {{ $genre->name }} {{ $loop->index < $randomBook->genres->count() - 1 ? ',' : '' }}
                @endforeach
              </span>             
            </div>

          </div>
        </div>
      </div>
    </a>
  </x-toast>
 @endif

@endsection

@push('js')
  <script src="{{ asset('frontend/js/sliders/bannerSlider.js') }}"></script>
  <script src="{{ asset('frontend/js/sliders/bookSlider.js') }}"></script>
  <script src="{{ asset('frontend/js/sliders/quoteSlider.js') }}"></script>
  <script src="{{ asset('frontend/js/sliders/collectionSlider.js') }}"></script>

  {{-- Most download book --}}
  <script>
    function getMostDownloadBooks(genre = null) {
      const url = genre ? '{{ route('ajax.mostDownloadBook') }}' + `?genre=${genre}` : '{{ route('ajax.mostDownloadBook') }}'

      const collectionUrl = genre 
        ? '{{ url('/page/collections') }}' + '/sach-tai-nhieu-nhat' + `?genre=${genre}` 
        : '{{ url('/page/collections') }}' + '/sach-tai-nhieu-nhat' + `?genre=all` 

      let container = document.querySelector('#mostDownloadBooks .box-content .row')
      container.innerHTML = ''

      displayLoading('#mostDownloadBooks .box-content .row')

      fetch(url)
      .then(response => response.json())
      .then(data => {
        hideLoading('#mostDownloadBooks .box-content .row')

        if(data.status) {

          data.result.books.forEach(book => {
            const coverUrl = '{{ url('storage/') }}' + '/' + book.cover_url
            let files = ''

            book.files.forEach(file => files += `<div class="most-download-book_card_label" style="background-color: ${file.color}">${file.name}</div>`);

            const item = 
            `
            <div class="col-12 col-md-6 col-lg-4">
              <div class="most-download-book_card">
                <a href="{{ url('/book') }}${'/' + book.slug}" class="d-flex">
                  <img src="${coverUrl}" alt="${book.title}" class="most-download-book_card_cover">

                  <div class="most-download-book_card_info ms-4 flex-grow-1">
                    <div class="most-download-book_card_title">${book.title}</div>
                    <div class="most-download-book_card_meta">${book.author_name}</div>

                    <div class="most-download-book_card_meta most-download-book_card_review">
                      <span>${book.rating}<i class='bx bxs-heart'></i></span>
                    </div>

                    <div class="most-download-book_card_meta">${book.downloads} luợt tải</div>

                    <div class="most-download-book_card_meta most-download-book_card_labels d-flex align-items-center flex-wrap">
                      ${files}
                    </div>
                  </div>
                </a>
              </div>
            </div> 
            
            `

            container.innerHTML += item;
          });

          container.innerHTML += 
          `
            <div class="text-center">
              <a href="${collectionUrl}" class="box_getAll">xem thêm</a>
            </div>
          
          `

          document.querySelectorAll('.read-most_nav_link').forEach(link => {
            if(link.classList.contains('active')) link.classList.remove('active');
          })

          if(genre) {
            document.querySelector('.read-most_nav_link.genre-' + genre).classList.add('active')
          }
          else {
            document.querySelector('.read-most_nav_link.genre-all').classList.add('active')
          }


        }
      })

    }
  </script>

  {{-- toast --}}
  <script>
    setTimeout(() => {
      const toastMessage = document.querySelector('.toast-message')
      toastMessage.style.left = '2rem';
    }, 500);
  </script>
@endpush
