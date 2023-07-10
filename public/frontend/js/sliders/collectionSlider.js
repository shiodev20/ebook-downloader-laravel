const collectionSlider = new Swiper('#collectionSlider', {
  speed: 400,
  spaceBetween: 50,
  loop: true,
  breakpoints: {
    0: {
      slidesPerView: 1,
      spaceBetween: 10,
      navigation: {
        enabled: false,
        nextEl: null,
        prevEl: null,
      },
    },
    768: {
      slidesPerView: 2,
      spaceBetween: 10,
      navigation: {
        enabled: true
      },
    },
    992: {
      slidesPerView: 3,
      spaceBetween: 10
    },
  },
  navigation: {
    nextEl: '.slider_navigation--next',
    prevEl: '.slider_navigation--prev',
  },
});
