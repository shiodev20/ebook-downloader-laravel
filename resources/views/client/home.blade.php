@extends('partials.layouts.client')

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
          <a href="./list.html" class="box_getAll">xem thêm</a>
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
                    <a href="./detail.html">

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
        <div class="box py-4 px-4">

          <div class="box-header d-flex justify-content-between align-items-center flex-column flex-md-row">
            <h2 class="box_title my-3">tải nhiều nhất</h2>

            <ul class="read-most_nav nav nav-pills">
              <li class="read-most_nav_item nav-item" onclick="getMostDownloadBooks()">
                <a class="read-most_nav_link nav-link active genre-{{'all'}}"  aria-current="page" style="cursor: pointer">Tất Cả</a>
              </li>
              @foreach ($genres as $genre)
                <li class="read-most_nav_item nav-item" onclick="getMostDownloadBooks('{{ $genre->id }}')">
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
                    <a href="/" class="d-flex">
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
          <h2 class="box_title">sách nên đọc</h2>
          <a href="./list.html" class="box_getAll">xem thêm</a>
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
                    <a href="./detail.html">

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
          <a href="/" class="box_getAll">xem thêm</a>
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
                    <a href="/">
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


@endsection

@push('js')
  <script src="{{ asset('frontend/js/sliders/bannerSlider.js') }}"></script>
  <script src="{{ asset('frontend/js/sliders/bookSlider.js') }}"></script>
  <script src="{{ asset('frontend/js/sliders/quoteSlider.js') }}"></script>
  <script src="{{ asset('frontend/js/sliders/collectionSlider.js') }}"></script>

  <script>
    function getMostDownloadBooks(genre = null) {
      const url = genre ? '{{ route('client.mostDownloadBook') }}' + `?genre=${genre}` : '{{ route('client.mostDownloadBook') }}'

      fetch(url)
      .then(response => response.json())
      .then(data => {
        if(data.status) {
          let container = document.querySelector('#mostDownloadBooks .box-content .row');
          container.innerHTML = ''

          data.result.books.forEach(book => {
            const coverUrl = '{{ url('storage/') }}' + '/' + book.cover_url
            let files = ''

            book.files.forEach(file => files += `<div class="most-download-book_card_label" style="background-color: ${file.color}">${file.name}</div>`);

            const item = 
            `
            <div class="col-12 col-md-6 col-lg-4">
              <div class="most-download-book_card">
                <a href="/" class="d-flex">
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
@endpush