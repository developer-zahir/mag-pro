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
    $('.magpro-ticker-slide-wrap').each(function () {
      var $wrap = $(this);
      if ($wrap.data('tickerInit')) return;
      $wrap.data('tickerInit', true);

      var $items = $wrap.find('.magpro-ticker-content .magpro-ticker-item');
      if ($items.length <= 1) return;

      var currentIndex = 0;
      var timer = null;
      var interval = 4500;

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

      $wrap.find('.magpro-ticker-next').on('click', function () {
        next();
        start();
      });

      $wrap.find('.magpro-ticker-prev').on('click', function () {
        prev();
        start();
      });

      $wrap.on('mouseenter', stop).on('mouseleave', start);
      start();
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
    }
  });

  // Regular Document Ready
  $(document).ready(function () {
    initMagProTabs();
    initMagProTickers();
  });
})(jQuery);
