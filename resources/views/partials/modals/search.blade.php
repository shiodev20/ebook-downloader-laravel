<div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">

        <div class="search-form">
          <div class="search-form_header">
            <span class="search-form_icon search-form_icon--search"><i class="bx bx-search"></i></span>
            <a class="search-form_icon search-form_icon--close" role="button"><i class="bx bx-x"></i></a>
            <input type="text" class="search-form_input" placeholder="Nhập tên sách" name="search"/>
          </div>

          <div class="search-form_body">
            <div class="search-form_result">

            </div>
          </div>

        </div>



      </div>
    </div>
  </div>
</div>

@push('js')
  <script>
    const searchInput = document.querySelector('#searchModal input[name=search]') 
    
    searchInput.addEventListener('input', (e) => {
      const filter = e.target.value

      const url = '{{ route('ajax.bookSearch') }}' + `?filter=${filter}`

      displayLoading('#searchModal .search-form_result')

      fetch(url)
      .then(response => response.json())
      .then(data => {
        hideLoading('#searchModal .search-form_result')

        const container = document.querySelector('#searchModal .search-form_result')
        container.innerHTML = '' 

        data.forEach(book => {
          const coverUrl = '{{ url('storage/') }}' + '/' + book.cover_url
          let files = ''

          book.files.forEach(file => files += `<div class="most-download-book_card_label" style="background-color: ${file.color}">${file.name}</div>`);

          const item = 
          `
          <a href="{{ url('/book') }}${'/' + book.slug}">
            <div class="search-book_card d-flex">
              <img src="${coverUrl}" alt="${book.title}" class="search-book_card_cover">

              <div class="search-book_card_info ms-4 flex-grow-1">
                <div class="search-book_card_title">${book.title}</div>
                <div class="search-book_card_meta">${book.author_name}</div>

                <div class="search-book_card_meta search-book_card_review">
                  <span>${book.rating}<i class='bx bxs-heart'></i></span>
                </div>

                <div class="search-book_card_meta">${book.downloads} luợt tải</div>

                <div class="search-book_card_meta search-book_card_labels d-flex align-items-center flex-wrap">
                  ${files}
                </div>
              </div>
            </div>
          </a>
          `
          container.innerHTML += item
        })
      })
      if(filter) {
      }

    })
  </script>
@endpush