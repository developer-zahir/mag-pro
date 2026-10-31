/**
 * Mag Pro Elements - Frontend Scripts
 * Author: Developer Zahir
 * URI: https://developerzahir.com/
 */

(function ($) {
  'use strict';

  // =========================================================================
  // Tabbed Posts Widget Handler
  // =========================================================================
  function initMagProTabs() {
    $('.magpro-tabs-wrap').each(function () {
      var $wrap = $(this);
      if ($wrap.data('tabsInit')) return;
      $wrap.data('tabsInit', true);

      $wrap.find('.magpro-tab-button').on('click', function (e) {
        e.preventDefault();
        var $btn = $(this);
        var targetTab = $btn.data('tab');

        $wrap.find('.magpro-tab-button').removeClass('active');
        $btn.addClass('active');

        $wrap.find('.magpro-tab-panel').removeClass('active');
        $wrap.find('.magpro-tab-' + targetTab).addClass('active');
      });
    });
  }

  // =========================================================================
  // News Ticker Slider Handler for Widget
  // =========================================================================
  function initMagProTickers() {
    $('.magpro-ticker-wrap').each(function () {
      var $wrap = $(this);
      // Skip continuous marquee ticker
      if ($wrap.hasClass('magpro-ticker-marquee-wrap') || $wrap.find('.magpro-ticker-marquee').length) {
        return;
      }
      if ($wrap.data('tickerInit')) return;
      $wrap.data('tickerInit', true);

      var $items = $wrap.find('.magpro-ticker-content .magpro-ticker-item');
      if ($items.length <= 1) return;

      var currentIndex = 0;
      var timer = null;
      var interval = parseInt($wrap.data('speed'), 10) || 4500;

      function showItem(idx) {
        $items.removeClass('active');
        $items.eq(idx).addClass('active');
      }

      function next() {
        currentIndex = (currentIndex + 1) % $items.length;
        showItem(currentIndex);
      }

      function prev() {
        currentIndex = (currentIndex - 1 + $items.length) % $items.length;
        showItem(currentIndex);
      }

      function start() {
        stop();
        timer = setInterval(next, interval);
      }

      function stop() {
        if (timer) {
          clearInterval(timer);
          timer = null;
        }
      }

      $wrap.find('.magpro-ticker-next').off('click').on('click', function (e) {
        e.preventDefault();
        next();
        start();
      });

      $wrap.find('.magpro-ticker-prev').off('click').on('click', function (e) {
        e.preventDefault();
        prev();
        start();
      });

      $wrap.off('mouseenter mouseleave').on('mouseenter', stop).on('mouseleave', start);
      showItem(0);
      start();
    });
  }

  // =========================================================================
  // Post Slider / Carousel Handler
  // =========================================================================
  function initMagProSliders() {
    $('.magpro-slider-wrap').each(function () {
      var $slider = $(this);
      if ($slider.data('sliderInit')) return;
      $slider.data('sliderInit', true);

      var $track = $slider.find('.magpro-slider-track');
      var $slides = $slider.find('.magpro-slide-item');
      var totalSlides = $slides.length;
      if (totalSlides === 0) return;

      var autoplay = $slider.data('autoplay') === true || $slider.data('autoplay') === 'true';
      var speed = parseInt($slider.data('speed'), 10) || 4000;
      var desktop = parseInt($slider.data('desktop'), 10) || 3;
      var tablet = parseInt($slider.data('tablet'), 10) || 2;
      var mobile = parseInt($slider.data('mobile'), 10) || 1;

      var currentIndex = 0;
      var timer = null;
      var startX = 0;
      var currentX = 0;
      var isSwiping = false;

      function getVisibleCount() {
        var width = $(window).width();
        if (width <= 600) return mobile;
        if (width <= 1024) return tablet;
        return desktop;
      }

      function updateLayout() {
        var visible = getVisibleCount();
        var gap = 16;

        $slides.css({
          'flex': '0 0 calc(' + (100 / visible) + '% - ' + ((visible - 1) * gap / visible) + 'px)',
          'min-width': '0'
        });

        // Generate Dots
        var maxIndex = Math.max(0, totalSlides - visible);
        var $dotsWrap = $slider.find('.magpro-slider-dots');
        if ($dotsWrap.length) {
          $dotsWrap.empty();
          for (var d = 0; d <= maxIndex; d++) {
            var activeClass = (d === currentIndex) ? ' active' : '';
            $dotsWrap.append('<span class="magpro-slider-dot' + activeClass + '" data-index="' + d + '"></span>');
          }
        }

        goToSlide(currentIndex);
      }

      function goToSlide(idx) {
        var visible = getVisibleCount();
        var maxIndex = Math.max(0, totalSlides - visible);
        if (idx < 0) idx = maxIndex;
        if (idx > maxIndex) idx = 0;
        currentIndex = idx;

        var slideItemWidth = $slides.first().outerWidth(true) || 0;
        var translateX = -(currentIndex * slideItemWidth);
        $track.css('transform', 'translateX(' + translateX + 'px)');

        $slider.find('.magpro-slider-dot').removeClass('active');
        $slider.find('.magpro-slider-dot[data-index="' + currentIndex + '"]').addClass('active');
      }

      function next() {
        goToSlide(currentIndex + 1);
      }

      function prev() {
        goToSlide(currentIndex - 1);
      }

      function startTimer() {
        stopTimer();
        if (autoplay) {
          timer = setInterval(next, speed);
        }
      }

      function stopTimer() {
        if (timer) {
          clearInterval(timer);
          timer = null;
        }
      }

      $slider.find('.magpro-slider-next').off('click').on('click', function (e) {
        e.preventDefault();
        next();
        startTimer();
      });

      $slider.find('.magpro-slider-prev').off('click').on('click', function (e) {
        e.preventDefault();
        prev();
        startTimer();
      });

      $slider.off('click', '.magpro-slider-dot').on('click', '.magpro-slider-dot', function () {
        var targetIdx = parseInt($(this).data('index'), 10);
        goToSlide(targetIdx);
        startTimer();
      });

      // Pause on hover
      $slider.off('mouseenter mouseleave').on('mouseenter', stopTimer).on('mouseleave', startTimer);

      // Touch Swipe Support
      $slider.off('touchstart touchmove touchend');
      $slider.on('touchstart', function (e) {
        stopTimer();
        startX = e.originalEvent.touches[0].clientX;
        isSwiping = true;
      });

      $slider.on('touchmove', function (e) {
        if (!isSwiping) return;
        currentX = e.originalEvent.touches[0].clientX;
      });

      $slider.on('touchend', function () {
        if (!isSwiping) return;
        isSwiping = false;
        var diffX = startX - currentX;
        if (Math.abs(diffX) > 40) {
          if (diffX > 0) {
            next();
          } else {
            prev();
          }
        }
        startTimer();
      });

      // Window Resize Listener
      $(window).off('resize.magproSlider').on('resize.magproSlider', function () {
        updateLayout();
      });

      updateLayout();
      startTimer();
    });
  }

  

  // =========================================================================
  // Header & Widget Search Interactions (3 Styles: Modal, Slide Down, Header Replace)
  // =========================================================================
  function initMagProSearch() {
    var triggers = document.querySelectorAll('.magpro-search-trigger');
    if (!triggers.length) return;

    function openSearch(style, btn, targetId) {
      if (style === 'header-replace') {
        var headerRow = btn.closest('.main-header-bar, .ast-builder-grid-row, .site-header-row, .ast-main-header-wrap, .ast-above-header-bar, .ast-below-header-bar, .site-header, header');
        var replaceBar = targetId ? document.getElementById(targetId) : null;
        if (!replaceBar && headerRow) {
          replaceBar = headerRow.querySelector('.magpro-search-replace-bar');
        }
        if (!replaceBar) {
          replaceBar = document.getElementById('magpro-search-replace-bar');
        }
        if (headerRow) {
          headerRow.classList.add('magpro-header-search-active');
          if (replaceBar && !headerRow.contains(replaceBar)) {
            headerRow.appendChild(replaceBar);
          }
        }
        if (replaceBar) {
          replaceBar.classList.add('active');
          replaceBar.setAttribute('aria-hidden', 'false');
          var rInput = replaceBar.querySelector('input[type="search"]');
          if (rInput) setTimeout(function () { rInput.focus(); }, 120);
        }
      } else if (style === 'slide-down' || style === 'header-cover') {
        var slideBar = targetId ? document.getElementById(targetId) : document.getElementById('magpro-search-slide-down');
        if (!slideBar) slideBar = document.querySelector('.magpro-search-slide-down, .magpro-search-cover');
        if (slideBar) {
          slideBar.classList.add('active');
          slideBar.setAttribute('aria-hidden', 'false');
          var sInput = slideBar.querySelector('input[type="search"]');
          if (sInput) setTimeout(function () { sInput.focus(); }, 120);
        }
      } else {
        var modal = targetId ? document.getElementById(targetId) : document.getElementById('magpro-search-modal');
        if (!modal) modal = document.querySelector('.magpro-search-modal');
        if (modal) {
          modal.classList.add('active');
          modal.setAttribute('aria-hidden', 'false');
          document.body.classList.add('magpro-search-modal-open');
          var mInput = modal.querySelector('input[type="search"]');
          if (mInput) setTimeout(function () { mInput.focus(); }, 150);
        }
      }
    }

    function closeAllSearch() {
      // 1. Modals
      document.querySelectorAll('.magpro-search-modal').forEach(function (m) {
        m.classList.remove('active');
        m.setAttribute('aria-hidden', 'true');
      });
      // 2. Slide downs
      document.querySelectorAll('.magpro-search-slide-down, .magpro-search-cover').forEach(function (s) {
        s.classList.remove('active');
        s.setAttribute('aria-hidden', 'true');
      });
      // 3. Header Replace
      document.querySelectorAll('.magpro-header-search-active').forEach(function (h) {
        h.classList.remove('magpro-header-search-active');
      });
      document.querySelectorAll('.magpro-search-replace-bar').forEach(function (r) {
        r.classList.remove('active');
        r.setAttribute('aria-hidden', 'true');
      });
      document.body.classList.remove('magpro-search-modal-open');
    }

    triggers.forEach(function (btn) {
      if (btn.dataset.searchInit === 'true') return;
      btn.dataset.searchInit = 'true';

      btn.addEventListener('click', function (e) {
        e.preventDefault();
        var style = btn.getAttribute('data-target-style') || (btn.closest('[data-search-style]') ? btn.closest('[data-search-style]').getAttribute('data-search-style') : 'full-screen');
        var widgetWrap = btn.closest('.magpro-widget-search-wrap');
        var targetId = null;
        if (widgetWrap) {
          var siblingModal = widgetWrap.querySelector('.magpro-search-modal, .magpro-search-slide-down, .magpro-search-replace-bar, .magpro-search-cover');
          if (siblingModal && siblingModal.id) {
            targetId = siblingModal.id;
          }
        }
        openSearch(style, btn, targetId);
      });
    });

    var closeButtons = document.querySelectorAll('.magpro-search-modal-close, .magpro-search-modal-backdrop, .magpro-search-slide-down-close, .magpro-search-replace-close, .magpro-search-cover-close');
    closeButtons.forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        closeAllSearch();
      });
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' || e.keyCode === 27) {
        closeAllSearch();
      }
    });
  }

// =========================================================================
  // Elementor Frontend Hooks
  // =========================================================================
  $(window).on('elementor/frontend/init', function () {
    if (window.elementorFrontend && window.elementorFrontend.hooks) {
      window.elementorFrontend.hooks.addAction('frontend/element_ready/magpro-tabs.default', function () {
        initMagProTabs();
      });
      window.elementorFrontend.hooks.addAction('frontend/element_ready/magpro-news-ticker.default', function () {
        initMagProTickers();
      });
      window.elementorFrontend.hooks.addAction('frontend/element_ready/magpro-slider.default', function () {
        initMagProSliders();
      });
      window.elementorFrontend.hooks.addAction('frontend/element_ready/magpro-search.default', function () {
        initMagProSearch();
      });
    }
  });

  // Regular Document Ready
  $(document).ready(function () {
    initMagProTabs();
    initMagProTickers();
    initMagProSliders();
    initMagProSearch();
  });
})(jQuery);
