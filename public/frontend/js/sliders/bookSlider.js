const bookSlider = new Swiper('#bookSlider', {
  speed: 400,
  spaceBetween: 50,
  loop: true,
  breakpoints: {
    0: {
      slidesPerView: 2,
      spaceBetween: 5,
      navigation: {
        enabled: false,
        nextEl: null,
        prevEl: null,
      },
    },
    576: {
      slidesPerView: 3,
      spaceBetween: 5,
      navigation: {
        enabled: true
      },
    },
    768: {
      slidesPerView: 4,
      spaceBetween: 5
    },
    992: {
      slidesPerView: 5,
      spaceBetween: 5
    },
    1200: {
      slidesPerView: 6,
      spaceBetween: 5
    }
  },
  navigation: {
    nextEl: '.slider_navigation--next',
    prevEl: '.slider_navigation--prev',
  },
});
