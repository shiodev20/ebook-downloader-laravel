@extends('partials.layouts.admin')

@section('documentTitle')
  {{ $book->title }}
@endsection

@section('content')
  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Sách {{ $book->id }} | {{ date_format(date_create($book->publish_date), 'd-m-Y') }}</h4>

          <form id="bookAddForm" action="{{ route('books.update', ['book' => $book->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">

              {{-- Title --}}
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label font-weight-bold" for="title">Tên sách</label>
                  <input class="form-control form-control-sm font-weight-bold" id="title" name="title"
                    style="{{ $errors->has('title') ? 'border: 1px solid #dc3545' : '' }}" type="text"
                    value="{{ $book->title }}">
                  @error('title')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              {{-- Num pages --}}
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label font-weight-bold" for="numPages">Số trang</label>
                  <input type="number" class="form-control form-control-sm font-weight-bold" id="numPages"
                    name="numPages" style="{{ $errors->has('numPages') ? 'border: 1px solid #dc3545' : '' }}"
                    value="{{ $book->num_pages }}">
                  @error('numPages')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              {{-- Author --}}
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label font-weight-bold" for="author">Tác giả</label>
                  <select class="js-example-basic-single" style="width: 100%;" name="author" id="author">
                    <option value="">Lựa chọn</option>
                    @foreach ($authors as $author)
                      <option value="{{ $author->id }}" {{ $author->id == $book->author_id ? 'selected' : '' }}>
                        {{ $author->name }}</option>
                    @endforeach
                  </select>
                  @error('author')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              {{-- Publisher --}}
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label font-weight-bold" for="publisher">Nhà xuất bản</label>
                  <select class="js-example-basic-single" style="width: 100%;" name="publisher" id="publisher">
                    <option value="">Lựa chọn</option>
                    @foreach ($publishers as $publisher)
                      <option value="{{ $publisher->id }}"
                        {{ $publisher->id == $book->publisher_id ? 'selected' : '' }}>{{ $publisher->name }}</option>
                    @endforeach
                  </select>
                  @error('publisher')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>


              {{-- Genre --}}
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label font-weight-bold" for="genres">Thể loại</label>
                  <select class="js-example-basic-multiple" multiple="multiple" style="width: 100%;" name="genres[]"
                    id="genres">
                    @foreach ($genres as $genre)
                      <option value="{{ $genre->id }}" {{ $book->genres->contains($genre->id) ? 'selected' : '' }}>
                        {{ $genre->name }}</option>
                    @endforeach
                  </select>
                  @error('genres')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              
              {{-- Collection --}}
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label font-weight-bold" for="collections">Tuyển tập</label>
                  <select class="js-example-basic-multiple" multiple="multiple" style="width: 100%;" name="collections[]"
                    id="collections">
                    @foreach ($collections as $collection)
                      <option value="{{ $collection->id }}" {{ $book->collections->contains($collection->id) ? 'selected' : '' }}>
                        {{ $collection->name }}</option>
                    @endforeach
                  </select>
                  @error('collections')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>

            </div>

            <hr>

            <div class="row">

              {{-- Book cover --}}
              <div class="col-md-3">
                <div class="form-group mb-0">
                  <label class="form-label font-weight-bold" for="bookCover">Ảnh bìa sách <small><i>(png/jpeg)</i></small></label>
                  <div>
                    <input type="file" name="cover" class="file-upload-default" onchange="preview_imageBook()" id="bookCoverInput" value="{{ url('/storage/' . $book->cover_url)}}">
                    <div class="input-group col-xs-12 mb-1">
                      <button class="file-upload-browse btn btn-primary btn-sm" type="button">Tải ảnh</button>
                    </div>
                    <img 
                      id="bookCoverRender" 
                      class="rounded border" 
                      src="{{ url('/storage/' . $book->cover_url) }}"
                      width="110px" height="150px" />
                  </div>

                  @error('cover')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>


              {{-- Book files --}}
              <div class="col-md-9">
                <label class="form-label font-weight-bold" for="bookFiles">File sách</label>

                @foreach ($fileTypes as $fileType)
                  <div class="form-group mb-3" style="height: 30px; width: 100%; max-width: 700px;">
                    <input type="file" name="{{ $fileType->name }}" class="file-upload-default" style="height: 100%;">

                    <div class="input-group col-xs-12" style="height: 100%;">

                      <span class="input-group-prepend" style="height: 100%;">
                        <button type="button" class="file-upload-browse btn text-white font-weight-bold p-0" style="width: 100px; background-color: {{ $fileType->color }}">{{ $fileType->name }}</button>
                      </span>

                      <input type="text" class="form-control file-upload-info" disabled style="height: 100%;" value="{{ $fileType->file_name }}">

                      @if ($fileType->url)
                        <a href="{{ route('downloads.index', ['book' => $book->id]) .'?url=' . $fileType->url }}" class="btn btn-info py-2" style="border-radius: 0; height: 100%;"><i class="fa-solid fa-download"></i></a>
                        <a href="{{ route('books.deleteFile', ['book' => $book->id, 'fileType' => $fileType->id]) }}" class="btn btn-danger py-2" style="border-radius: 0 15px 15px 0; height: 100%;"><i class="fa-solid fa-trash"></i></a>
                      @else
                        <button class="btn btn-info py-2" style="border-radius: 0; height: 100%;" disabled><i class="fa-solid fa-download"></i></button>
                        <button class="btn btn-danger py-2" style="border-radius: 0 15px 15px 0; height: 100%;" disabled><i class="fa-solid fa-trash"></i></button>
                      @endif
                    </div>
                    @error($fileType->name)
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                  </div>
                @endforeach

              </div>

            </div>

            <hr>

            {{-- Description --}}
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label class="form-label font-weight-bold" for="description">Mô tả</label>
                  <textarea name="description" id="description" class="form-control" rows="10">{{ $book->description }}</textarea>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-success w-100">Cập nhật</button>

          </form>
        </div>

      </div>
    </div>

    <div class="col-12 grid-margin">
      <div class="accordion" id="bookReviewAccordion" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;">
        <div class="card bg-primary">

          <div class="card-header p-2" id="bookReview">
            <button class="btn btn-block text-left text-white" type="button" data-toggle="collapse"
              data-target="#bookReviewCollapse" aria-expanded="true" aria-controls="bookReviewCollapse">
              Thông tin đánh giá
            </button>
          </div>

          <div id="bookReviewCollapse" class="collapse show" aria-labelledby="bookReview" data-parent="#bookReviewAccordion">
            <div class="card-body bg-white py-3 px-4">

              <div class="row">

                {{-- Download --}}
                <div class="col-md-2">
                  <div class="form-group">
                    <label class="form-label font-weight-bold" for="publishDate">Lượt tải</label>
                    <input readonly type="text" class="form-control form-control-sm font-weight-bold"
                      value="{{ $book->downloads }}">
                  </div>
                </div>

                {{-- Rating --}}
                <div class="col-md-2">
                  <div class="form-group">
                    <label class="form-label font-weight-bold" for="publishDate">Đánh giá</label>
                    <input readonly type="text" class="form-control form-control-sm font-weight-bold"
                      value="{{ $book->rating }}">
                  </div>
                </div>

              </div>

              <hr>

              <div class="row">
                <div class="col">
                  @foreach ($book->reviews as $review)
                    <div class="book-review_review pb-5 w-100">
                      <div class="row g-4">
            
                        <div class="col-sm-12 col-md-3">
  
                          <div class="book-review_review_author d-flex flex-row flex-md-column justify-content-between align-items-center align-items-md-start">
  
                            <div class="book-review_review_author_item d-flex flex-row flex-md-column align-items-center align-items-md-start">
                              <span class="p-1 fs-4 font-weight-bold">{{ $review->user->username }}</span>
                            </div>
  
                            <span class="book-review_review_author_item p-1">{{ date_format(date_create($review->created_at), 'd-m-Y') }}</span>
  
                          </div>
  
                        </div>
                        
                        <div class="col-sm-12 col-md-9">
                          <div class="book-review_review_rating" style="color: #fe7e73;">
                            <span>{{ $review->rate }} <i class="fa-solid fa-heart" style="font-size: .8rem"></i></span>
                          </div>
                          <div class="book-review_review_content">
                            <p>{{ $review->content }}</p>
                          </div>
                        </div>
                        
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>

            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    const inputs = document.querySelectorAll('#bookAddForm input')
    const selects = document.querySelectorAll('#bookAddForm select')

    inputs.forEach(input => {
      input.addEventListener('input', () => {
        input.style.border = '1px solid #CED4DA'
        const invalidFeedBack = document.querySelector(`input[id=${input.id}] + .invalid-feedback`)
        if (invalidFeedBack) invalidFeedBack.style.visibility = 'hidden'
      })
    })

    selects.forEach(select => {
      select.addEventListener('change', () => {
        select.style.border = '1px solid #CED4DA'
        const invalidFeedBack = document.querySelector(`select[id=${select.id}] + .invalid-feedback`)
        if (invalidFeedBack) invalidFeedBack.style.visibility = 'hidden'
      })
    })
  </script>
@endpush
