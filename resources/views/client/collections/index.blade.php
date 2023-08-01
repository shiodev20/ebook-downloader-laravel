@extends('partials.layouts.client')

@section('documentTitle')
Tuyển tập hay
@endsection

@section('content')
  <section id="page">
    <div class="container mt-5 shadow-sm">
      <div class="row">
        <div class="box py-4 px-4">

          <div class="box_header d-flex justify-content-between align-items-center">
            <h2 class="box_title">Tuyển tập hay</h2>
          </div>

          <div>
            <hr class="divider">
          </div>

          <div class="box_content">
            <div class="row">

              @foreach ($collections as $collection)
                <div class="col-sm-12 col-md-6 col-lg-4 mb-5">
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

            <div class="mt-4 d-flex justify-content-center fs-4">
              {{ $collections->links() }}
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
@endsection