const bannserSlider = new Swiper('#bannerSlider', {
  speed: 400,
  spaceBetween: 100,
  loop: true,
  autoplay: {
    delay: 2000,
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
