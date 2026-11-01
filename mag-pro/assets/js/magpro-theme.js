/**
 * Mag Pro Theme JavaScript
 * Version: 2.4.0
 * Author: Developer Zahir (https://developerzahir.com/)
 */

(function () {
  'use strict';

  // ==========================================================================
  // 1. Dark / Light Mode Engine (MagPro Style)
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

    // Set initial theme
    var currentTheme = document.documentElement.getAttribute('data-theme') || getTheme();
    setTheme(currentTheme);

    // Click handler for all dark mode toggles (desktop, mobile, and Elementor widget)
    document.addEventListener('click', function (e) {
      var toggleBtn = e.target.closest('.darkmode-toggle, .mobile-darkmode-toggle, .magpro-theme-toggle, [data-magpro-toggle="theme"]');
      if (toggleBtn) {
        e.preventDefault();
        var current = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
        var next = current === 'dark' ? 'light' : 'dark';
        setTheme(next);
      }
    });

    // Listen to system OS theme changes if user hasn't explicitly set preference
    if (window.matchMedia) {
      window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
        if (!localStorage.getItem('magpro_theme')) {
          setTheme(e.matches ? 'dark' : 'light');
        }
      });
    }
  }

  // ==========================================================================
  // 2. Search Toggle Engine (MagPro Nav Search)
  // ==========================================================================
  function initSearchToggle() {
    var header = document.getElementById('magpro-pro-header-wrapper');

    document.addEventListener('click', function (e) {
      // MagPro Main Nav Search Toggle (50x50 icon)
      var searchToggle = e.target.closest('.search-toggle');
      if (searchToggle) {
        e.preventDefault();
        if (header) {
          header.classList.toggle('search-active');
          if (header.classList.contains('search-active')) {
            var searchInput = header.querySelector('#nav-search .search-input');
            if (searchInput) {
              setTimeout(function () {
                searchInput.focus();
              }, 100);
            }
          }
        }
        return;
      }

      // Close search when clicking outside
      if (header && header.classList.contains('search-active')) {
        if (!e.target.closest('#nav-search') && !e.target.closest('.search-toggle')) {
          header.classList.remove('search-active');
        }
      }
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && header && header.classList.contains('search-active')) {
        header.classList.remove('search-active');
      }
    });
  }

  // ==========================================================================
  // 3. Mobile Navigation Drawer
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
      if (e.target.closest('.mobile-menu-toggle, .magpro-mobile-toggle')) {
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
  // 4. Sticky Main Navigation
  // ==========================================================================
  function initStickyMenu() {
    var menuWrap = document.querySelector('.main-menu-wrap');
    if (!menuWrap || !document.body.classList.contains('has-sticky-menu')) return;

    var menuOffset = menuWrap.getBoundingClientRect().top + window.pageYOffset;

    function handleScroll() {
      if (window.pageYOffset > menuOffset) {
        menuWrap.classList.add('is-sticky');
      } else {
        menuWrap.classList.remove('is-sticky');
      }
    }

    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();
  }

    // ==========================================================================
  // 5. AJAX Archive Pagination (Load More & Infinite Scroll)
  // ==========================================================================
  function initAjaxPagination() {
    var pager = document.querySelector('.magpro-ajax-pager');
    var postWrap = document.querySelector('.index-post-wrap');
    if (!pager || !postWrap) return;

    var type = pager.getAttribute('data-type') || 'load_more';
    var nextUrl = pager.getAttribute('data-next');
    var isLoading = false;

    function loadNext() {
      if (isLoading || !nextUrl) return;
      isLoading = true;

      var loadBtn = pager.querySelector('.magpro-load-more-btn');
      var btnText = pager.querySelector('.magpro-btn-text');
      var btnLoading = pager.querySelector('.magpro-btn-loading');
      var infLoader = pager.querySelector('.magpro-infinite-loader');

      if (btnText && btnLoading) {
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline-flex';
      }
      if (infLoader) {
        infLoader.classList.add('is-loading');
      }

      fetch(nextUrl)
        .then(function (response) {
          if (!response.ok) throw new Error('Network response error');
          return response.text();
        })
        .then(function (html) {
          var parser = new DOMParser();
          var doc = parser.parseFromString(html, 'text/html');
          var newPosts = doc.querySelectorAll('.index-post-wrap .index-post');
          var newPager = doc.querySelector('.magpro-ajax-pager');

          if (newPosts && newPosts.length > 0) {
            newPosts.forEach(function (post) {
              postWrap.appendChild(post);
            });
          }

          if (newPager && newPager.getAttribute('data-next')) {
            nextUrl = newPager.getAttribute('data-next');
            pager.setAttribute('data-next', nextUrl);
            isLoading = false;
            if (btnText && btnLoading) {
              btnText.style.display = 'inline-flex';
              btnLoading.style.display = 'none';
            }
            if (infLoader) {
              infLoader.classList.remove('is-loading');
            }
          } else {
            // No more posts to load
            nextUrl = null;
            pager.innerHTML = '<span class="magpro-no-more">No more posts to load</span>';
            pager.classList.add('all-loaded');
            isLoading = false;
          }
        })
        .catch(function (err) {
          console.error('MagPro AJAX pagination error:', err);
          isLoading = false;
          if (btnText && btnLoading) {
            btnText.style.display = 'inline-flex';
            btnLoading.style.display = 'none';
          }
          if (infLoader) {
            infLoader.classList.remove('is-loading');
          }
        });
    }

    if (type === 'load_more') {
      var btn = pager.querySelector('.magpro-load-more-btn');
      if (btn) {
        btn.addEventListener('click', function (e) {
          e.preventDefault();
          loadNext();
        });
      }
    } else if (type === 'infinite_scroll') {
      if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
          if (entries[0].isIntersecting) {
            loadNext();
          }
        }, { rootMargin: '300px' });
        observer.observe(pager);
      } else {
        window.addEventListener('scroll', function () {
          if (isLoading || !nextUrl) return;
          var rect = pager.getBoundingClientRect();
          if (rect.top <= window.innerHeight + 250) {
            loadNext();
          }
        }, { passive: true });
      }
    }
  }

  // Initialize on DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () {
      initThemeToggle();
      initSearchToggle();
      initMobileMenu();
      initStickyMenu();
      initAjaxPagination();
    });
  } else {
    initThemeToggle();
    initSearchToggle();
    initMobileMenu();
    initStickyMenu();
      initAjaxPagination();
  }
})();
