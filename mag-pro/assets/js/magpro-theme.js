/**
 * Mag Pro Theme JavaScript
 * Version: 2.0.0
 * Author: Developer Zahir (https://developerzahir.com/)
 */

(function () {
  'use strict';

  // ==========================================================================
  // 1. Dark / Light Mode Engine
  // ==========================================================================
  function initThemeToggle() {
    function getTheme() {
      var saved = localStorage.getItem('magpro_theme');
      if (saved) return saved;
      return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    function setTheme(theme) {
      document.documentElement.setAttribute('data-theme', theme);
      if (document.body) {
        document.body.setAttribute('data-theme', theme);
      }
      localStorage.setItem('magpro_theme', theme);
      document.cookie = "magpro_theme=" + theme + "; path=/; max-age=" + (60 * 60 * 24 * 365);

      // Dispatch event for Elementor widgets or third-party plugins
      var event = new CustomEvent('magproThemeChanged', { detail: { theme: theme } });
      window.dispatchEvent(event);
    }

    // Set initial theme if not set
    var currentTheme = document.documentElement.getAttribute('data-theme') || getTheme();
    setTheme(currentTheme);

    // Toggle button clicks
    document.addEventListener('click', function (e) {
      var toggleBtn = e.target.closest('.magpro-theme-toggle, [data-magpro-toggle="theme"]');
      if (toggleBtn) {
        e.preventDefault();
        var current = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
        var next = current === 'dark' ? 'light' : 'dark';
        setTheme(next);
      }
    });

    // Listen to OS theme changes if user hasn't explicitly set preference
    if (window.matchMedia) {
      window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
        if (!localStorage.getItem('magpro_theme')) {
          setTheme(e.matches ? 'dark' : 'light');
        }
      });
    }
  }

  // ==========================================================================
  // 2. Mobile Drawer Navigation
  // ==========================================================================
  function initMobileMenu() {
    var drawer = document.querySelector('.magpro-mobile-drawer');
    var overlay = document.querySelector('.magpro-mobile-overlay');

    if (!drawer) return;

    function openDrawer() {
      drawer.classList.add('is-active');
      if (overlay) overlay.classList.add('is-active');
      document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
      drawer.classList.remove('is-active');
      if (overlay) overlay.classList.remove('is-active');
      document.body.style.overflow = '';
    }

    document.addEventListener('click', function (e) {
      if (e.target.closest('.magpro-mobile-toggle')) {
        e.preventDefault();
        openDrawer();
      } else if (e.target.closest('.magpro-mobile-close') || e.target === overlay) {
        e.preventDefault();
        closeDrawer();
      }
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && drawer.classList.contains('is-active')) {
        closeDrawer();
      }
    });
  }

  // ==========================================================================
  // 3. Search Modals & Triggers
  // ==========================================================================
  function initSearch() {
    var fullModal = document.getElementById('magpro-search-fullscreen');

    function openFullscreenSearch() {
      if (!fullModal) return;
      fullModal.classList.add('is-open');
      fullModal.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
      var input = fullModal.querySelector('.magpro-modal-search-field');
      if (input) {
        setTimeout(function () {
          input.focus();
        }, 100);
      }
    }

    function closeFullscreenSearch() {
      if (!fullModal) return;
      fullModal.classList.remove('is-open');
      fullModal.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
    }

    document.addEventListener('click', function (e) {
      // Trigger Fullscreen Modal
      var trigger = e.target.closest('.magpro-search-trigger[data-search-style="fullscreen"], a[href="#magpro-search-fullscreen"]');
      if (trigger) {
        e.preventDefault();
        openFullscreenSearch();
        return;
      }

      // Close Fullscreen Modal
      if (e.target.closest('.magpro-search-close') || (fullModal && e.target.classList.contains('magpro-search-modal-backdrop'))) {
        e.preventDefault();
        closeFullscreenSearch();
        return;
      }

      // Slide-down Search Bar
      var slideTrigger = e.target.closest('.magpro-search-trigger[data-search-style="slidedown"], .magpro-search-trigger[data-search-style="slide-down"]');
      if (slideTrigger) {
        e.preventDefault();
        var wrapper = slideTrigger.closest('.magpro-search-widget, .magpro-main-header');
        var slideBar = wrapper ? wrapper.querySelector('.magpro-search-slidedown-bar') : document.querySelector('.magpro-search-slidedown-bar');
        if (slideBar) {
          slideBar.classList.toggle('is-active');
          var slideInput = slideBar.querySelector('input[type="search"]');
          if (slideInput && slideBar.classList.contains('is-active')) {
            slideInput.focus();
          }
        }
        return;
      }

      // Header Replace Search Bar
      var replaceTrigger = e.target.closest('.magpro-search-trigger[data-search-style="replace"], .magpro-search-trigger[data-search-style="header-replace"]');
      if (replaceTrigger) {
        e.preventDefault();
        var container = replaceTrigger.closest('.magpro-header-search-wrap, .magpro-search-widget, .magpro-main-header');
        if (container) {
          container.classList.toggle('magpro-header-search-active');
          var replaceInput = container.querySelector('.magpro-search-replace-input, input[type="search"]');
          if (replaceInput && container.classList.contains('magpro-header-search-active')) {
            replaceInput.focus();
          }
        }
        return;
      }

      // Close Header Replace on close button
      if (e.target.closest('.magpro-search-replace-close')) {
        e.preventDefault();
        var activeContainer = e.target.closest('.magpro-header-search-active');
        if (activeContainer) {
          activeContainer.classList.remove('magpro-header-search-active');
        }
      }
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        if (fullModal && fullModal.classList.contains('is-open')) {
          closeFullscreenSearch();
        }
        var activeReplace = document.querySelector('.magpro-header-search-active');
        if (activeReplace) {
          activeReplace.classList.remove('magpro-header-search-active');
        }
      }
    });
  }

  // Initialize all components when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () {
      initThemeToggle();
      initMobileMenu();
      initSearch();
    });
  } else {
    initThemeToggle();
    initMobileMenu();
    initSearch();
  }
})();
