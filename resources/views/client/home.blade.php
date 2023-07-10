@extends('partials.layouts.client')

@section('content')
{{-- banner --}}
<section>
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
<section>
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

              <div class="swiper-slide slider_item">
                <div class="book-card">
                  <a href="./detail.html">

                    <div class="book-card_image">
                      <img src="{{ asset('images/book.png') }}" loading="lazy" />
                      <div class="swiper-lazy-preloader"></div>
                    </div>

                    <div class="book-card_labels">
                      <div class="book-card_label book-card_label--mobi">MOBI</div>
                      <div class="book-card_label book-card_label--pdf">PDF</div>
                      <div class="book-card_label book-card_label--epub">EPUB</div>
                      <div class="book-card_label book-card_label--awz3">AWZ3</div>
                    </div>


                    <div class="book-card_info">
                      <div class="book-card_info_title">Tuổi trẻ đáng giá bao nhiêu</div>
                      <div class="book-card_info_meta">Book author</div>
                    </div>

                  </a>
                </div>
              </div>

              <div class="swiper-slide slider_item">
                <div class="book-card">
                  <a href="/">

                    <div class="book-card_image">
                      <img src="{{ asset('images/book.png') }}" loading="lazy" />
                      <div class="swiper-lazy-preloader"></div>
                    </div>

                    <div class="book-card_labels">
                      <div class="book-card_label book-card_label--mobi">MOBI</div>
                      <div class="book-card_label book-card_label--pdf">PDF</div>
                      <div class="book-card_label book-card_label--epub">EPUB</div>
                      <div class="book-card_label book-card_label--awz3">AWZ3</div>
                    </div>


                    <div class="book-card_info">
                      <div class="book-card_info_title">Tuổi trẻ đáng giá bao nhiêu</div>
                      <div class="book-card_info_meta">Book author</div>
                    </div>

                  </a>
                </div>
              </div>

              <div class="swiper-slide slider_item">
                <div class="book-card">
                  <a href="/">

                    <div class="book-card_image">
                      <img src="{{ asset('images/book.png') }}" loading="lazy" />
                      <div class="swiper-lazy-preloader"></div>
                    </div>

                    <div class="book-card_labels">
                      <div class="book-card_label book-card_label--mobi">MOBI</div>
                      <div class="book-card_label book-card_label--pdf">PDF</div>
                      <div class="book-card_label book-card_label--epub">EPUB</div>
                      <div class="book-card_label book-card_label--awz3">AWZ3</div>
                    </div>


                    <div class="book-card_info">
                      <div class="book-card_info_title">Tuổi trẻ đáng giá bao nhiêu</div>
                      <div class="book-card_info_meta">Book author</div>
                    </div>

                  </a>
                </div>
              </div>

              <div class="swiper-slide slider_item">
                <div class="book-card">
                  <a href="/">

                    <div class="book-card_image">
                      <img src="{{ asset('images/book.png') }}" loading="lazy" />
                      <div class="swiper-lazy-preloader"></div>
                    </div>

                    <div class="book-card_labels">
                      <div class="book-card_label book-card_label--mobi">MOBI</div>
                      <div class="book-card_label book-card_label--pdf">PDF</div>
                      <div class="book-card_label book-card_label--epub">EPUB</div>
                      <div class="book-card_label book-card_label--awz3">AWZ3</div>
                    </div>


                    <div class="book-card_info">
                      <div class="book-card_info_title">Tuổi trẻ đáng giá bao nhiêu</div>
                      <div class="book-card_info_meta">Book author</div>
                    </div>

                  </a>
                </div>
              </div>

              <div class="swiper-slide slider_item">
                <div class="book-card">
                  <a href="/">

                    <div class="book-card_image">
                      <img src="{{ asset('images/book.png') }}" loading="lazy" />
                      <div class="swiper-lazy-preloader"></div>
                    </div>

                    <div class="book-card_labels">
                      <div class="book-card_label book-card_label--mobi">MOBI</div>
                      <div class="book-card_label book-card_label--pdf">PDF</div>
                      <div class="book-card_label book-card_label--epub">EPUB</div>
                      <div class="book-card_label book-card_label--awz3">AWZ3</div>
                    </div>


                    <div class="book-card_info">
                      <div class="book-card_info_title">Tuổi trẻ đáng giá bao nhiêu</div>
                      <div class="book-card_info_meta">Book author</div>
                    </div>

                  </a>
                </div>
              </div>

              <div class="swiper-slide slider_item">
                <div class="book-card">
                  <a href="/">

                    <div class="book-card_image">
                      <img src="{{ asset('images/book.png') }}" loading="lazy" />
                      <div class="swiper-lazy-preloader"></div>
                    </div>

                    <div class="book-card_labels">
                      <div class="book-card_label book-card_label--mobi">MOBI</div>
                      <div class="book-card_label book-card_label--pdf">PDF</div>
                      <div class="book-card_label book-card_label--epub">EPUB</div>
                      <div class="book-card_label book-card_label--awz3">AWZ3</div>
                    </div>


                    <div class="book-card_info">
                      <div class="book-card_info_title">Tuổi trẻ đáng giá bao nhiêu</div>
                      <div class="book-card_info_meta">Book author</div>
                    </div>

                  </a>
                </div>
              </div>

              <div class="swiper-slide slider_item">
                <div class="book-card">
                  <a href="/">

                    <div class="book-card_image">
                      <img src="{{ asset('images/book.png') }}" loading="lazy" />
                      <div class="swiper-lazy-preloader"></div>
                    </div>

                    <div class="book-card_labels">
                      <div class="book-card_label book-card_label--mobi">MOBI</div>
                      <div class="book-card_label book-card_label--pdf">PDF</div>
                      <div class="book-card_label book-card_label--epub">EPUB</div>
                      <div class="book-card_label book-card_label--awz3">AWZ3</div>
                    </div>


                    <div class="book-card_info">
                      <div class="book-card_info_title">Tuổi trẻ đáng giá bao nhiêu</div>
                      <div class="book-card_info_meta">Book author</div>
                    </div>

                  </a>
                </div>
              </div>

              <div class="swiper-slide slider_item">
                <div class="book-card">
                  <a href="/">

                    <div class="book-card_image">
                      <img src="{{ asset('images/book.png') }}" loading="lazy" />
                      <div class="swiper-lazy-preloader"></div>
                    </div>

                    <div class="book-card_labels">
                      <div class="book-card_label book-card_label--mobi">MOBI</div>
                      <div class="book-card_label book-card_label--pdf">PDF</div>
                      <div class="book-card_label book-card_label--epub">EPUB</div>
                      <div class="book-card_label book-card_label--awz3">AWZ3</div>
                    </div>


                    <div class="book-card_info">
                      <div class="book-card_info_title">Tuổi trẻ đáng giá bao nhiêu</div>
                      <div class="book-card_info_meta">Book author</div>
                    </div>

                  </a>
                </div>
              </div>

              <div class="swiper-slide slider_item">
                <div class="book-card">
                  <a href="/">

                    <div class="book-card_image">
                      <img src="{{ asset('images/book.png') }}" loading="lazy" />
                      <div class="swiper-lazy-preloader"></div>
                    </div>

                    <div class="book-card_labels">
                      <div class="book-card_label book-card_label--mobi">MOBI</div>
                      <div class="book-card_label book-card_label--pdf">PDF</div>
                      <div class="book-card_label book-card_label--epub">EPUB</div>
                      <div class="book-card_label book-card_label--awz3">AWZ3</div>
                    </div>


                    <div class="book-card_info">
                      <div class="book-card_info_title">Tuổi trẻ đáng giá bao nhiêu</div>
                      <div class="book-card_info_meta">Book author</div>
                    </div>

                  </a>
                </div>
              </div>

              <div class="swiper-slide slider_item">
                <div class="book-card">
                  <a href="/">

                    <div class="book-card_image">
                      <img src="{{ asset('images/book.png') }}" loading="lazy" />
                      <div class="swiper-lazy-preloader"></div>
                    </div>

                    <div class="book-card_labels">
                      <div class="book-card_label book-card_label--mobi">MOBI</div>
                      <div class="book-card_label book-card_label--pdf">PDF</div>
                      <div class="book-card_label book-card_label--epub">EPUB</div>
                      <div class="book-card_label book-card_label--awz3">AWZ3</div>
                    </div>


                    <div class="book-card_info">
                      <div class="book-card_info_title">Tuổi trẻ đáng giá bao nhiêu</div>
                      <div class="book-card_info_meta">Book author</div>
                    </div>

                  </a>
                </div>
              </div>

              <div class="swiper-slide slider_item">
                <div class="book-card">
                  <a href="/">

                    <div class="book-card_image">
                      <img src="{{ asset('images/book.png') }}" loading="lazy" />
                      <div class="swiper-lazy-preloader"></div>
                    </div>

                    <div class="book-card_labels">
                      <div class="book-card_label book-card_label--mobi">MOBI</div>
                      <div class="book-card_label book-card_label--pdf">PDF</div>
                      <div class="book-card_label book-card_label--epub">EPUB</div>
                      <div class="book-card_label book-card_label--awz3">AWZ3</div>
                    </div>


                    <div class="book-card_info">
                      <div class="book-card_info_title">Tuổi trẻ đáng giá bao nhiêu</div>
                      <div class="book-card_info_meta">Book author</div>
                    </div>

                  </a>
                </div>
              </div>

              <div class="swiper-slide slider_item">
                <div class="book-card">
                  <a href="/">

                    <div class="book-card_image">
                      <img src="{{ asset('images/book.png') }}" loading="lazy" />
                      <div class="swiper-lazy-preloader"></div>
                    </div>

                    <div class="book-card_labels">
                      <div class="book-card_label book-card_label--mobi">MOBI</div>
                      <div class="book-card_label book-card_label--pdf">PDF</div>
                      <div class="book-card_label book-card_label--epub">EPUB</div>
                      <div class="book-card_label book-card_label--awz3">AWZ3</div>
                    </div>


                    <div class="book-card_info">
                      <div class="book-card_info_title">Tuổi trẻ đáng giá bao nhiêu</div>
                      <div class="book-card_info_meta">Book author</div>
                    </div>

                  </a>
                </div>
              </div>

              <div class="swiper-slide slider_item">
                <div class="book-card">
                  <a href="/">

                    <div class="book-card_image">
                      <img src="{{ asset('images/book.png') }}" loading="lazy" />
                      <div class="swiper-lazy-preloader"></div>
                    </div>

                    <div class="book-card_labels">
                      <div class="book-card_label book-card_label--mobi">MOBI</div>
                      <div class="book-card_label book-card_label--pdf">PDF</div>
                      <div class="book-card_label book-card_label--epub">EPUB</div>
                      <div class="book-card_label book-card_label--awz3">AWZ3</div>
                    </div>


                    <div class="book-card_info">
                      <div class="book-card_info_title">Tuổi trẻ đáng giá bao nhiêu</div>
                      <div class="book-card_info_meta">Book author</div>
                    </div>

                  </a>
                </div>
              </div>

              <div class="swiper-slide slider_item">
                <div class="book-card">
                  <a href="/">

                    <div class="book-card_image">
                      <img src="{{ asset('images/book.png') }}" loading="lazy" />
                      <div class="swiper-lazy-preloader"></div>
                    </div>

                    <div class="book-card_labels">
                      <div class="book-card_label book-card_label--mobi">MOBI</div>
                      <div class="book-card_label book-card_label--pdf">PDF</div>
                      <div class="book-card_label book-card_label--epub">EPUB</div>
                      <div class="book-card_label book-card_label--awz3">AWZ3</div>
                    </div>


                    <div class="book-card_info">
                      <div class="book-card_info_title">Tuổi trẻ đáng giá bao nhiêu</div>
                      <div class="book-card_info_meta">Book author</div>
                    </div>

                  </a>
                </div>
              </div>

              <div class="swiper-slide slider_item">
                <div class="book-card">
                  <a href="/">

                    <div class="book-card_image">
                      <img src="{{ asset('images/book.png') }}" loading="lazy" />
                      <div class="swiper-lazy-preloader"></div>
                    </div>

                    <div class="book-card_labels">
                      <div class="book-card_label book-card_label--mobi">MOBI</div>
                      <div class="book-card_label book-card_label--pdf">PDF</div>
                      <div class="book-card_label book-card_label--epub">EPUB</div>
                      <div class="book-card_label book-card_label--awz3">AWZ3</div>
                    </div>


                    <div class="book-card_info">
                      <div class="book-card_info_title">Tuổi trẻ đáng giá bao nhiêu</div>
                      <div class="book-card_info_meta">Book author</div>
                    </div>

                  </a>
                </div>
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

      </div>
    </div>
  </div>
</section>

<section>
  <div class="container mt-5 p-0">
    <div class="row">
      <div class="col">
        <div class="box py-4 px-4">

          <div class="box-header d-flex justify-content-between align-items-center flex-column flex-md-row">
            <h2 class="box_title my-3">tải nhiều nhất</h2>

            <ul class="read-most_nav nav nav-pills">
              <li class="read-most_nav_item nav-item">
                <a class="read-most_nav_link nav-link active" aria-current="page" href="#">Tất Cả</a>
              </li>
              <li class="read-most_nav_item nav-item">
                <a class="read-most_nav_link nav-link" href="#">Kỹ Năng Sống</a>
              </li>
              <li class="read-most_nav_item nav-item">
                <a class="read-most_nav_link nav-link" href="#">Kinh Doanh - Tiền Tệ</a>
              </li>
            </ul>

          </div>

          <div>
            <hr class="divider">
          </div>

          <div class="box-content">
            <div class="row g-4">

              <div class="col-12 col-md-6 col-lg-4">
                <div class="most-download-book_card">
                  <a href="/" class="d-flex">
                    <img src="{{ asset('images/book.png') }}" alt="" class="most-download-book_card_cover">

                    <div class="most-download-book_card_info ms-4 flex-grow-1">
                      <div class="most-download-book_card_title">Tuổi trẻ đáng giá bao nhiêu ?</div>
                      <div class="most-download-book_card_meta">Roise Nguyen</div>

                      <div class="most-download-book_card_meta most-download-book_card_review">
                        <span>4.7 <i class='bx bxs-heart'></i></span>
                      </div>

                      <div class="most-download-book_card_meta">1,000 luợt tải</div>

                      <div
                        class="most-download-book_card_meta most-download-book_card_labels d-flex align-items-center flex-wrap">
                        <div class="most-download-book_card_label most-download-book_card_label--mobi">MOBI</div>
                        <div class="most-download-book_card_label most-download-book_card_label--pdf">PDF</div>
                        <div class="most-download-book_card_label most-download-book_card_label--epub">EPUB</div>
                        <div class="most-download-book_card_label most-download-book_card_label--awz3">AWZ3</div>
                      </div>
                    </div>
                  </a>
                </div>
              </div>

              <div class="col-12 col-md-6 col-lg-4">
                <div class="most-download-book_card">
                  <a href="/" class="d-flex">
                    <img src="{{ asset('images/book.png') }}" alt="" class="most-download-book_card_cover">

                    <div class="most-download-book_card_info ms-4 flex-grow-1">
                      <div class="most-download-book_card_title">Tuổi trẻ đáng giá bao nhiêu ?</div>
                      <div class="most-download-book_card_meta">Roise Nguyen</div>

                      <div class="most-download-book_card_meta most-download-book_card_review">
                        <span>4.7 <i class='bx bxs-heart'></i></span>
                      </div>

                      <div class="most-download-book_card_meta">1,000 luợt tải</div>

                      <div
                        class="most-download-book_card_meta most-download-book_card_labels d-flex align-items-center flex-wrap">
                        <div class="most-download-book_card_label most-download-book_card_label--mobi">MOBI</div>
                        <div class="most-download-book_card_label most-download-book_card_label--pdf">PDF</div>
                        <div class="most-download-book_card_label most-download-book_card_label--epub">EPUB</div>
                        <div class="most-download-book_card_label most-download-book_card_label--awz3">AWZ3</div>
                      </div>
                    </div>
                  </a>
                </div>
              </div>

              <div class="col-12 col-md-6 col-lg-4">
                <div class="most-download-book_card">
                  <a href="/" class="d-flex">
                    <img src="{{ asset('images/book.png') }}" alt="" class="most-download-book_card_cover">

                    <div class="most-download-book_card_info ms-4 flex-grow-1">
                      <div class="most-download-book_card_title">Tuổi trẻ đáng giá bao nhiêu ?</div>
                      <div class="most-download-book_card_meta">Roise Nguyen</div>

                      <div class="most-download-book_card_meta most-download-book_card_review">
                        <span>4.7 <i class='bx bxs-heart'></i></span>
                      </div>

                      <div class="most-download-book_card_meta">1,000 luợt tải</div>

                      <div
                        class="most-download-book_card_meta most-download-book_card_labels d-flex align-items-center flex-wrap">
                        <div class="most-download-book_card_label most-download-book_card_label--mobi">MOBI</div>
                        <div class="most-download-book_card_label most-download-book_card_label--pdf">PDF</div>
                        <div class="most-download-book_card_label most-download-book_card_label--epub">EPUB</div>
                        <div class="most-download-book_card_label most-download-book_card_label--awz3">AWZ3</div>
                      </div>
                    </div>
                  </a>
                </div>
              </div>

              <div class="col-12 col-md-6 col-lg-4">
                <div class="most-download-book_card">
                  <a href="/" class="d-flex">
                    <img src="{{ asset('images/book.png') }}" alt="" class="most-download-book_card_cover">

                    <div class="most-download-book_card_info ms-4 flex-grow-1">
                      <div class="most-download-book_card_title">Tuổi trẻ đáng giá bao nhiêu ?</div>
                      <div class="most-download-book_card_meta">Roise Nguyen</div>

                      <div class="most-download-book_card_meta most-download-book_card_review">
                        <span>4.7 <i class='bx bxs-heart'></i></span>
                      </div>

                      <div class="most-download-book_card_meta">1,000 luợt tải</div>

                      <div
                        class="most-download-book_card_meta most-download-book_card_labels d-flex align-items-center flex-wrap">
                        <div class="most-download-book_card_label most-download-book_card_label--mobi">MOBI</div>
                        <div class="most-download-book_card_label most-download-book_card_label--pdf">PDF</div>
                        <div class="most-download-book_card_label most-download-book_card_label--epub">EPUB</div>
                        <div class="most-download-book_card_label most-download-book_card_label--awz3">AWZ3</div>
                      </div>
                    </div>
                  </a>
                </div>
              </div>

              <div class="col-12 col-md-6 col-lg-4">
                <div class="most-download-book_card">
                  <a href="/" class="d-flex">
                    <img src="{{ asset('images/book.png') }}" alt="" class="most-download-book_card_cover">

                    <div class="most-download-book_card_info ms-4 flex-grow-1">
                      <div class="most-download-book_card_title">Tuổi trẻ đáng giá bao nhiêu ?</div>
                      <div class="most-download-book_card_meta">Roise Nguyen</div>

                      <div class="most-download-book_card_meta most-download-book_card_review">
                        <span>4.7 <i class='bx bxs-heart'></i></span>
                      </div>

                      <div class="most-download-book_card_meta">1,000 luợt tải</div>

                      <div
                        class="most-download-book_card_meta most-download-book_card_labels d-flex align-items-center flex-wrap">
                        <div class="most-download-book_card_label most-download-book_card_label--mobi">MOBI</div>
                        <div class="most-download-book_card_label most-download-book_card_label--pdf">PDF</div>
                        <div class="most-download-book_card_label most-download-book_card_label--epub">EPUB</div>
                        <div class="most-download-book_card_label most-download-book_card_label--awz3">AWZ3</div>
                      </div>
                    </div>
                  </a>
                </div>
              </div>

              <div class="col-12 col-md-6 col-lg-4">
                <div class="most-download-book_card">
                  <a href="/" class="d-flex">
                    <img src="{{ asset('images/book.png') }}" alt="" class="most-download-book_card_cover">

                    <div class="most-download-book_card_info ms-4 flex-grow-1">
                      <div class="most-download-book_card_title">Tuổi trẻ đáng giá bao nhiêu ?</div>
                      <div class="most-download-book_card_meta">Roise Nguyen</div>

                      <div class="most-download-book_card_meta most-download-book_card_review">
                        <span>4.7 <i class='bx bxs-heart'></i></span>
                      </div>

                      <div class="most-download-book_card_meta">1,000 luợt tải</div>

                      <div
                        class="most-download-book_card_meta most-download-book_card_labels d-flex align-items-center flex-wrap">
                        <div class="most-download-book_card_label most-download-book_card_label--mobi">MOBI</div>
                        <div class="most-download-book_card_label most-download-book_card_label--pdf">PDF</div>
                        <div class="most-download-book_card_label most-download-book_card_label--epub">EPUB</div>
                        <div class="most-download-book_card_label most-download-book_card_label--awz3">AWZ3</div>
                      </div>
                    </div>
                  </a>
                </div>
              </div>

              <div class="col-12 col-md-6 col-lg-4">
                <div class="most-download-book_card">
                  <a href="/" class="d-flex">
                    <img src="{{ asset('images/book.png') }}" alt="" class="most-download-book_card_cover">

                    <div class="most-download-book_card_info ms-4 flex-grow-1">
                      <div class="most-download-book_card_title">Tuổi trẻ đáng giá bao nhiêu ?</div>
                      <div class="most-download-book_card_meta">Roise Nguyen</div>

                      <div class="most-download-book_card_meta most-download-book_card_review">
                        <span>4.7 <i class='bx bxs-heart'></i></span>
                      </div>

                      <div class="most-download-book_card_meta">1,000 luợt tải</div>

                      <div
                        class="most-download-book_card_meta most-download-book_card_labels d-flex align-items-center flex-wrap">
                        <div class="most-download-book_card_label most-download-book_card_label--mobi">MOBI</div>
                        <div class="most-download-book_card_label most-download-book_card_label--pdf">PDF</div>
                        <div class="most-download-book_card_label most-download-book_card_label--epub">EPUB</div>
                        <div class="most-download-book_card_label most-download-book_card_label--awz3">AWZ3</div>
                      </div>
                    </div>
                  </a>
                </div>
              </div>

              <div class="col-12 col-md-6 col-lg-4">
                <div class="most-download-book_card">
                  <a href="/" class="d-flex">
                    <img src="{{ asset('images/book.png') }}" alt="" class="most-download-book_card_cover">

                    <div class="most-download-book_card_info ms-4 flex-grow-1">
                      <div class="most-download-book_card_title">Tuổi trẻ đáng giá bao nhiêu ?</div>
                      <div class="most-download-book_card_meta">Roise Nguyen</div>

                      <div class="most-download-book_card_meta most-download-book_card_review">
                        <span>4.7 <i class='bx bxs-heart'></i></span>
                      </div>

                      <div class="most-download-book_card_meta">1,000 luợt tải</div>

                      <div
                        class="most-download-book_card_meta most-download-book_card_labels d-flex align-items-center flex-wrap">
                        <div class="most-download-book_card_label most-download-book_card_label--mobi">MOBI</div>
                        <div class="most-download-book_card_label most-download-book_card_label--pdf">PDF</div>
                        <div class="most-download-book_card_label most-download-book_card_label--epub">EPUB</div>
                        <div class="most-download-book_card_label most-download-book_card_label--awz3">AWZ3</div>
                      </div>
                    </div>
                  </a>
                </div>
              </div>

              <div class="col-12 col-md-6 col-lg-4">
                <div class="most-download-book_card">
                  <a href="/" class="d-flex">
                    <img src="{{ asset('images/book.png') }}" alt="" class="most-download-book_card_cover">

                    <div class="most-download-book_card_info ms-4 flex-grow-1">
                      <div class="most-download-book_card_title">Tuổi trẻ đáng giá bao nhiêu ?</div>
                      <div class="most-download-book_card_meta">Roise Nguyen</div>

                      <div class="most-download-book_card_meta most-download-book_card_review">
                        <span>4.7 <i class='bx bxs-heart'></i></span>
                      </div>

                      <div class="most-download-book_card_meta">1,000 luợt tải</div>

                      <div
                        class="most-download-book_card_meta most-download-book_card_labels d-flex align-items-center flex-wrap">
                        <div class="most-download-book_card_label most-download-book_card_label--mobi">MOBI</div>
                        <div class="most-download-book_card_label most-download-book_card_label--pdf">PDF</div>
                        <div class="most-download-book_card_label most-download-book_card_label--epub">EPUB</div>
                        <div class="most-download-book_card_label most-download-book_card_label--awz3">AWZ3</div>
                      </div>
                    </div>
                  </a>
                </div>
              </div>

              <div class="col-12 col-md-6 col-lg-4">
                <div class="most-download-book_card">
                  <a href="/" class="d-flex">
                    <img src="{{ asset('images/book.png') }}" alt="" class="most-download-book_card_cover">

                    <div class="most-download-book_card_info ms-4 flex-grow-1">
                      <div class="most-download-book_card_title">Tuổi trẻ đáng giá bao nhiêu ?</div>
                      <div class="most-download-book_card_meta">Roise Nguyen</div>

                      <div class="most-download-book_card_meta most-download-book_card_review">
                        <span>4.7 <i class='bx bxs-heart'></i></span>
                      </div>

                      <div class="most-download-book_card_meta">1,000 luợt tải</div>

                      <div
                        class="most-download-book_card_meta most-download-book_card_labels d-flex align-items-center flex-wrap">
                        <div class="most-download-book_card_label most-download-book_card_label--mobi">MOBI</div>
                        <div class="most-download-book_card_label most-download-book_card_label--pdf">PDF</div>
                        <div class="most-download-book_card_label most-download-book_card_label--epub">EPUB</div>
                        <div class="most-download-book_card_label most-download-book_card_label--awz3">AWZ3</div>
                      </div>
                    </div>
                  </a>
                </div>
              </div>

              <div class="col-12 col-md-6 col-lg-4">
                <div class="most-download-book_card">
                  <a href="/" class="d-flex">
                    <img src="{{ asset('images/book.png') }}" alt="" class="most-download-book_card_cover">

                    <div class="most-download-book_card_info ms-4 flex-grow-1">
                      <div class="most-download-book_card_title">Tuổi trẻ đáng giá bao nhiêu ?</div>
                      <div class="most-download-book_card_meta">Roise Nguyen</div>

                      <div class="most-download-book_card_meta most-download-book_card_review">
                        <span>4.7 <i class='bx bxs-heart'></i></span>
                      </div>

                      <div class="most-download-book_card_meta">1,000 luợt tải</div>

                      <div
                        class="most-download-book_card_meta most-download-book_card_labels d-flex align-items-center flex-wrap">
                        <div class="most-download-book_card_label most-download-book_card_label--mobi">MOBI</div>
                        <div class="most-download-book_card_label most-download-book_card_label--pdf">PDF</div>
                        <div class="most-download-book_card_label most-download-book_card_label--epub">EPUB</div>
                        <div class="most-download-book_card_label most-download-book_card_label--awz3">AWZ3</div>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
              
              <div class="col-12 col-md-6 col-lg-4">
                <div class="most-download-book_card">
                  <a href="/" class="d-flex">
                    <img src="{{ asset('images/book.png') }}" alt="" class="most-download-book_card_cover">

                    <div class="most-download-book_card_info ms-4 flex-grow-1">
                      <div class="most-download-book_card_title">Tuổi trẻ đáng giá bao nhiêu ?</div>
                      <div class="most-download-book_card_meta">Roise Nguyen</div>

                      <div class="most-download-book_card_meta most-download-book_card_review">
                        <span>4.7 <i class='bx bxs-heart'></i></span>
                      </div>

                      <div class="most-download-book_card_meta">1,000 luợt tải</div>

                      <div
                        class="most-download-book_card_meta most-download-book_card_labels d-flex align-items-center flex-wrap">
                        <div class="most-download-book_card_label most-download-book_card_label--mobi">MOBI</div>
                        <div class="most-download-book_card_label most-download-book_card_label--pdf">PDF</div>
                        <div class="most-download-book_card_label most-download-book_card_label--epub">EPUB</div>
                        <div class="most-download-book_card_label most-download-book_card_label--awz3">AWZ3</div>
                      </div>
                    </div>
                  </a>
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

@push('js')
  <script src="{{ asset('js/sliders/bannerSlider.js') }}"></script>
  <script src="{{ asset('js/sliders/bookSlider.js') }}"></script>
@endpush