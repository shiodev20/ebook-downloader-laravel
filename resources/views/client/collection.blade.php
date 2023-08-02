@extends('partials.layouts.client')

@section('documentTitle')
{{ $pageTitle }}
@endsection

@section('content')
 {{-- breadcrumbs --}}
  <section id="breadcrumbs">
    <div class="container mt-5">
      <div class="row">
        <div class="box">
          <div class="box-content">
            {{ Breadcrumbs::render('page', $model) }}
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="page">
    <div class="container mt-5 shadow-sm">
      <div class="row">
        <div class="box py-4 px-4">

          <div class="box_header d-flex justify-content-between align-items-center">
            <h2 class="box_title">{{ $pageTitle }}</h2>
          </div>

          <div>
            <hr class="divider">
          </div>

          <div class="box_content">
            <div class="row">

              @foreach ($books as $book)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-5">
                  <div class="book-card">
                    <a href="{{ route('client.detail', ['slug' => $book->slug]) }}">

                      <div class="book-card_image">
                        <img src="{{ url('storage/'.$book->cover_url) }}"/>
                      </div>

                      <div class="book-card_labels">
                        @foreach ($book->files as $file)
                          <div class="most-download-book_card_label" style="background-color: {{ $file->color }}">{{ $file->name }}</div>
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

            <div class="mt-4 d-flex justify-content-center fs-4">
              {{ $books->links() }}
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
@endsection