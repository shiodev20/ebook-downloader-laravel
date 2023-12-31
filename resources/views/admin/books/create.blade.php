@extends('partials.layouts.admin')

@section('documentTitle')
  Thêm sách
@endsection

@section('content')
  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Tạo sách</h4>

          <form id="bookAddForm" action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">

              {{-- Title --}}
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label font-weight-bold" for="title">Tên sách</label>
                  <input 
                    class="form-control form-control-sm font-weight-bold" id="title" name="title"
                    style="{{ $errors->has('title') ? 'border: 1px solid #dc3545' : '' }}" type="text"
                    value="{{ old('title') }}">
                  @error('title')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              {{-- Num pages --}}
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label font-weight-bold" for="numPages">Số trang</label>
                  <input 
                    type="number"
                    class="form-control form-control-sm font-weight-bold" id="numPages" name="numPages"
                    style="{{ $errors->has('numPages') ? 'border: 1px solid #dc3545' : '' }}" 
                    value="{{ old('numPages') }}">
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
                      <option value="{{ $author->id }}">{{ $author->name }}</option>
                    @endforeach
                  </select>
                  @error('author')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              {{-- Genre --}}
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label font-weight-bold" for="genres">Thể loại</label>
                  <select class="js-example-basic-multiple" multiple="multiple" style="width: 100%;" name="genres[]" id="genres">
                    @foreach ($genres as $genre)
                      <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                    @endforeach
                  </select>
                  @error('genres')
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
                      <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                    @endforeach
                  </select>
                  @error('publisher')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>

               {{-- Collection --}}
               <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label font-weight-bold" for="collections">Tuyển tập</label>
                  <select class="js-example-basic-multiple" multiple="multiple" style="width: 100%;" name="collections[]" id="collections">
                    @foreach ($collections as $collection)
                      <option value="{{ $collection->id }}">{{ $collection->name }}</option>
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
                <div class="form-group">
                  <label class="form-label font-weight-bold" for="bookCover">Ảnh bìa sách <small><i>(png/jpeg)</i></small></label>
                  <div>
                    <input type="file" name="cover" class="file-upload-default" onchange="preview_imageBook()" id="bookCoverInput">
                    <div class="input-group col-xs-12 mb-1">
                      <button class="file-upload-browse btn btn-primary btn-sm" type="button">Tải ảnh</button>
                    </div>
                    <img class="rounded border" id="bookCoverRender" src="{{ old('cover') ? old('cover') : asset('images/book-cover-default.jpg') }}" width="150px" height="200px" />
                  </div>

                  @error('cover')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>


              {{-- Book files --}}
              <div class="col-md-9 mb-3">
                <label class="form-label font-weight-bold" for="first_name">File sách</label>

                @foreach ($fileTypes as $fileType)
                  <div class="form-group" style="height: 40px;">
                    <input type="file" name="{{ $fileType->name }}" class="file-upload-default" style="height: 100%;">

                    <div class="input-group col-xs-12" style="height: 100%;">
                      <span class="input-group-prepend" style="height: 100%;">
                        <button 
                          type="button" 
                          class="file-upload-browse btn text-white font-weight-bold"
                          style="width: 100px; background-color: {{ $fileType->color }}">{{ $fileType->name }}</button>
                      </span>
                      <input type="text" class="form-control file-upload-info" disabled style="height: 100%;">
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
                  <textarea name="description" id="description" class="form-control" rows="10" cols="100"></textarea>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Tạo</button>

          </form>
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
      if(invalidFeedBack) invalidFeedBack.style.visibility = 'hidden'
    })
  })

  selects.forEach(select => {
    select.addEventListener('change', () => {
      select.style.border = '1px solid #CED4DA'
      const invalidFeedBack = document.querySelector(`select[id=${select.id}] + .invalid-feedback`)
      if(invalidFeedBack) invalidFeedBack.style.visibility = 'hidden'
    })
  })

</script>
@endpush