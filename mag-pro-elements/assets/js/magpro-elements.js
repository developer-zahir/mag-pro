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
  // Elementor Frontend Hooks
  // =========================================================================
  $(window).on('elementor/frontend/init', function () {
    if (elementorFrontend && elementorFrontend.hooks) {
      elementorFrontend.hooks.addAction('frontend/element_ready/magpro-tabs.default', function ($scope) {
        initMagProTabs();
      });
    }
  });

  // Regular Document Ready
  $(document).ready(function () {
    initMagProTabs();
  });
})(jQuery);

