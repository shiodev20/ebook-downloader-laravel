const quoteSlider = new Swiper('#quoteSlider', {
  speed: 400,
  spaceBetween: 100,
  loop: true,
  autoplay: {
    delay: 5000,
  },
  effect: 'fade',
  fadeEffect: {
    crossFade: true
  },
  breakpoints: {
    0: {
      navigation: {
        enabled: false,
        nextEl: null,
        prevEl: null,
      },
    },
    675: {
      navigation: {
        enabled: true
      },
    }
  },
  navigation: {
    nextEl: '.slider_navigation--next',
    prevEl: '.slider_navigation--prev',
  },
});