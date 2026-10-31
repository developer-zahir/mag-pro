/**
 * Mag Pro Theme - JavaScript Utilities
 * Dark/Light Mode Switcher & Ticker Logic
 * Author: Developer Zahir
 * URI: https://developerzahir.com/
 */

(function () {
  'use strict';

  // =========================================================================
  // Dark / Light Mode Toggle
  // =========================================================================
  function initThemeToggle() {
    var toggleButtons = document.querySelectorAll('.magpro-theme-toggle, .magpro-floating-toggle');
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
      if (tickerWrap.dataset.tickerInit === 'true') return;
      tickerWrap.dataset.tickerInit = 'true';

      var items = tickerWrap.querySelectorAll('.magpro-ticker-content .magpro-ticker-item');
      if (items.length <= 1) return;

      var prevBtn = tickerWrap.querySelector('.magpro-ticker-prev');
      var nextBtn = tickerWrap.querySelector('.magpro-ticker-next');
      var currentIndex = 0;
      var timer = null;
      var intervalMs = 4500;

      function showItem(index) {
        items.forEach(function (el) {
          el.classList.remove('active');
        });
        items[index].classList.add('active');
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
        nextBtn.addEventListener('click', function () {
          nextItem();
          startTimer();
        });
      }

      if (prevBtn) {
        prevBtn.addEventListener('click', function () {
          prevItem();
          startTimer();
        });
      }

      tickerWrap.addEventListener('mouseenter', stopTimer);
      tickerWrap.addEventListener('mouseleave', startTimer);

      startTimer();
    });
  }

  // Document Ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () {
      initThemeToggle();
      initNewsTickers();
    });
  } else {
    initThemeToggle();
    initNewsTickers();
  }
})();
