@extends('partials.layouts.admin')

@section('documentTitle')
  Trang chủ
@endsection

@section('content')
<div class="row">

  <div class="col-12 mb-5">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-md-6">
            <canvas id="mostDownloadBooks"></canvas>
          </div>

          <div class="col-12 col-md-6">
            <canvas id="mostLovedBooks"></canvas>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-md-6">
            <h5 class="text-center">Top 3 thể loại được tải nhiều nhất</h5>
            <canvas id="mostDownloadGenres"></canvas>
          </div>

          <div class="col-12 col-md-6">
            <h5 class="text-center">Top 3 thể loại được yêu thích nhất</h5>
            <canvas id="mostLovedGenres"></canvas>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>

    const mostDownloadUrl = '{{ route('ajax.mostDownloadBook') }}'
    const mostDownloadGenreUrl = '{{ route('ajax.mostDownloadGenre') }}'
    const mostLovedUrl = '{{ route('ajax.mostLovedBook') }}'
    const mostLovedGenreUrl = '{{ route('ajax.mostLovedGenre') }}'

    fetch(mostDownloadUrl)
    .then(response => response.json())
    .then(data => {
      const mostDownloadBookChart = document.getElementById('mostDownloadBooks');

      const labels = data.result.books.map(book => book.title);
      const downloadData = data.result.books.map(book => book.downloads);

      new Chart(mostDownloadBookChart, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Số lượt tải',
            data: downloadData,
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    })

    fetch(mostLovedUrl)
    .then(response => response.json())
    .then(data => {
      const mostLovedBookChart = document.getElementById('mostLovedBooks');

      const labels = data.result.books.map(book => book.title);
      const ratingData = data.result.books.map(book => book.rating);

      new Chart(mostLovedBookChart, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Yêu thích',
            data: ratingData,
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    })
    
    fetch(mostDownloadGenreUrl)
    .then(response => response.json())
    .then(data => {
      const mostDownloadGenreChart = document.getElementById('mostDownloadGenres');

      const labels = data.result.genres.map(genre => genre.name);
      const downloadData = data.result.genres.map(genre => genre.sum);

      new Chart(mostDownloadGenreChart, {
        type: 'pie',
        data: {
          labels: labels,
          datasets: [{
            label: 'Lượt tải',
            data: downloadData,
            backgroundColor: [
              'rgb(255, 99, 132)',
              'rgb(54, 162, 235)',
              'rgb(255, 205, 86)'
            ],
            hoverOffset: 4
          }]
        },
        // options: {
        //   scales: {
        //     y: {
        //       beginAtZero: true
        //     }
        //   }
        // }
      });
    })

    fetch(mostLovedGenreUrl)
    .then(response => response.json())
    .then(data => {
      const mostDownloadGenreChart = document.getElementById('mostLovedGenres');

      const labels = data.result.genres.map(genre => genre.name);
      const ratingData = data.result.genres.map(genre => genre.sum);

      new Chart(mostDownloadGenreChart, {
        type: 'pie',
        data: {
          labels: labels,
          datasets: [{
            label: 'Yêu thích',
            data: ratingData,
            backgroundColor: [
              'rgb(255, 99, 132)',
              'rgb(54, 162, 235)',
              'rgb(255, 205, 86)'
            ],
            hoverOffset: 4
          }]
        },
        // options: {
        //   scales: {
        //     y: {
        //       beginAtZero: true
        //     }
        //   }
        // }
      });
    })

  </script>
@endpush