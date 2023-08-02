@unless ($breadcrumbs->isEmpty())

  <div class="breadcrumb">
    @foreach ($breadcrumbs as $breadcrumb)

      @if (!is_null($breadcrumb->url) && !$loop->last)
          <li class="breadcrumb_item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
          <i class="bx bx-chevron-right" style="display: {{ $loop->last ? 'none'  : ''}};"></i>
      @else
          <li class="breadcrumb_item active">{{ $breadcrumb->title }}</li>
          <i class="bx bx-chevron-right" style="display: {{ $loop->last ? 'none'  : ''}};""></i>
      @endif

    @endforeach
  </div>

@endunless
