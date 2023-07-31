
const menu = document.querySelector('.ico_menu')
const close = document.querySelector('.ico_close')
const catalogue = document.querySelector('.header_catalogue')

menu.addEventListener('click', () => {
  catalogue.classList.add('active')
})

close.addEventListener('click', () => {
  catalogue.classList.remove('active')
})

const createRatingInputs = document.querySelectorAll('#reviewForm .book-review_form_rating input[type=radio]')

createRatingInputs.forEach(input => {
  input.addEventListener('change', () => {
    const value = input.value

    for (let i = 1; i <= createRatingInputs.length; i++) {
      const inputIcon = createRatingInputs[i - 1].nextElementSibling.firstChild;
      inputIcon.style.color = '#6c757d';
    }

    for (let i = 1; i <= value; i++) {
      const inputIcon = createRatingInputs[i - 1].nextElementSibling.firstChild;
      inputIcon.style.color = '#fe7e73';
    }
  })
})

