/**
 * Mag Pro Theme - JavaScript Utilities
 * Dark/Light Mode Switcher, Ticker & Slider Logic
 * Author: Developer Zahir
 * URI: https://developerzahir.com/
 */

(function () {
  'use strict';

  // =========================================================================
  // Dark / Light Mode Toggle
  // =========================================================================
  function initThemeToggle() {
    var toggleButtons = document.querySelectorAll('.magpro-theme-toggle');
    if (!toggleButtons.length) return;

    function getActiveTheme() {
      return document.documentElement.getAttribute('data-theme') || 'light';
    }

    function setTheme(theme) {
      document.documentElement.setAttribute('data-theme', theme);
      try {
        localStorage.setItem('magpro_theme', theme);
      } catch (e) {
        // localStorage might be unavailable or restricted
      }

      // Dispatch event for any third-party listeners (Elementor, charts, etc.)
      window.dispatchEvent(new CustomEvent('magproThemeChanged', { detail: { theme: theme } }));
    }

    toggleButtons.forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        var current = getActiveTheme();
        var nextTheme = current === 'dark' ? 'light' : 'dark';
        setTheme(nextTheme);
      });
    });

    // Listen to system theme changes if user has no saved preference
    if (window.matchMedia) {
      var colorSchemeQuery = window.matchMedia('(prefers-color-scheme: dark)');
      colorSchemeQuery.addEventListener('change', function (e) {
        try {
          if (!localStorage.getItem('magpro_theme')) {
            setTheme(e.matches ? 'dark' : 'light');
          }
        } catch (err) {}
      });
    }
  }

  // =========================================================================
  // Breaking News Ticker (Multiple instances supported)
  // =========================================================================
  function initNewsTickers() {
    var tickerWraps = document.querySelectorAll('.magpro-ticker-wrap');
    if (!tickerWraps.length) return;

    tickerWraps.forEach(function (tickerWrap) {
      // Skip continuous marquee style
      if (tickerWrap.classList.contains('magpro-ticker-marquee-wrap') || tickerWrap.querySelector('.magpro-ticker-marquee')) {
        return;
      }

      if (tickerWrap.dataset.tickerInit === 'true') return;
      tickerWrap.dataset.tickerInit = 'true';

      var items = tickerWrap.querySelectorAll('.magpro-ticker-content .magpro-ticker-item');
      if (items.length <= 1) return;

      var prevBtn = tickerWrap.querySelector('.magpro-ticker-prev');
      var nextBtn = tickerWrap.querySelector('.magpro-ticker-next');
      var currentIndex = 0;
      var timer = null;
      var intervalMs = parseInt(tickerWrap.dataset.speed, 10) || 4500;

      function showItem(index) {
        items.forEach(function (el) {
          el.classList.remove('active');
        });
        if (items[index]) {
          items[index].classList.add('active');
        }
      }

      function nextItem() {
        currentIndex = (currentIndex + 1) % items.length;
        showItem(currentIndex);
      }

      function prevItem() {
        currentIndex = (currentIndex - 1 + items.length) % items.length;
        showItem(currentIndex);
      }

      function startTimer() {
        stopTimer();
        timer = setInterval(nextItem, intervalMs);
      }

      function stopTimer() {
        if (timer) {
          clearInterval(timer);
          timer = null;
        }
      }

      if (nextBtn) {
        nextBtn.addEventListener('click', function (e) {
          e.preventDefault();
          nextItem();
          startTimer();
        });
      }

      if (prevBtn) {
        prevBtn.addEventListener('click', function (e) {
          e.preventDefault();
          prevItem();
          startTimer();
        });
      }

      tickerWrap.addEventListener('mouseenter', stopTimer);
      tickerWrap.addEventListener('mouseleave', startTimer);

      showItem(0);
      startTimer();
    });
  }

  // =========================================================================
  // Slider / Carousel for Sidebar & Templates (Pure Vanilla Fallback)
  // =========================================================================
  function initThemeSliders() {
    var sliders = document.querySelectorAll('.magpro-slider-wrap');
    if (!sliders.length) return;

    sliders.forEach(function (slider) {
      if (slider.dataset.sliderInit === 'true') return;
      slider.dataset.sliderInit = 'true';

      var track = slider.querySelector('.magpro-slider-track');
      var slides = slider.querySelectorAll('.magpro-slide-item');
      if (!track || !slides.length) return;

      var total = slides.length;
      var autoplay = slider.dataset.autoplay === 'true';
      var speed = parseInt(slider.dataset.speed, 10) || 4000;
      var desktop = parseInt(slider.dataset.desktop, 10) || 3;
      var tablet = parseInt(slider.dataset.tablet, 10) || 2;
      var mobile = parseInt(slider.dataset.mobile, 10) || 1;

      var current = 0;
      var timer = null;

      function getVisible() {
        var w = window.innerWidth;
        if (w <= 600) return mobile;
        if (w <= 1024) return tablet;
        return desktop;
      }

      function update() {
        var visible = getVisible();
        var maxIndex = Math.max(0, total - visible);
        if (current > maxIndex) current = 0;
        if (current < 0) current = maxIndex;

        var slideW = slides[0].offsetWidth || 0;
        track.style.transform = 'translateX(' + -(current * slideW) + 'px)';

        var dots = slider.querySelectorAll('.magpro-slider-dot');
        dots.forEach(function (dot, i) {
          dot.classList.toggle('active', i === current);
        });
      }

      function next() {
        var visible = getVisible();
        var maxIndex = Math.max(0, total - visible);
        current = current >= maxIndex ? 0 : current + 1;
        update();
      }

      function prev() {
        var visible = getVisible();
        var maxIndex = Math.max(0, total - visible);
        current = current <= 0 ? maxIndex : current - 1;
        update();
      }

      function start() {
        stop();
        if (autoplay) {
          timer = setInterval(next, speed);
        }
      }

      function stop() {
        if (timer) {
          clearInterval(timer);
          timer = null;
        }
      }

      var nextBtn = slider.querySelector('.magpro-slider-next');
      var prevBtn = slider.querySelector('.magpro-slider-prev');
      if (nextBtn) {
        nextBtn.addEventListener('click', function (e) {
          e.preventDefault();
          next();
          start();
        });
      }
      if (prevBtn) {
        prevBtn.addEventListener('click', function (e) {
          e.preventDefault();
          prev();
          start();
        });
      }

      slider.addEventListener('mouseenter', stop);
      slider.addEventListener('mouseleave', start);

      window.addEventListener('resize', update);
      update();
      start();
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

// Document Ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () {
      initThemeToggle();
      initNewsTickers();
      initThemeSliders();
      initMagProSearch();
    });
  } else {
    initThemeToggle();
    initNewsTickers();
    initThemeSliders();
      initMagProSearch();
  }
})();
