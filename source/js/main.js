(function ($) {
  var body = $('body');
  "use strict";
  var isiOS = false;

  var WIKI = WIKI || {},
    home_url = php_array.home_url,
    ajax_url = php_array.ajax_url,
    posts_per_page = php_array.posts_per_page,
    template_url = php_array.templateurl,
    $document = $(document),
    $html = $('html'),
    $body = $('body'),
    $header = $('.js-main-header'),
    $sitebackdrop = $('.c-site-backdrop'),
    $offcanvas = $('.c-offcanvas'),
    hash = window.location.hash,
    hash_object = queryString.parse(hash),
    iOS = false,
    IE = false;

  WIKI.isotope = function () {
    var isotope = $('.c-archive');
    isotope.isotope({
      itemSelector: '.c-archive .c-entry',
      masonry: {
        // use outer width of grid-sizer for columnWidth
        columnWidth: '.grid-sizer'
      }
    })
  }

  WIKI.LoginProcess = function () {
    $('.c-modal__close').click(function (e) {
      WIKI._Modal($(this).closest('.c-modal'), false);
    });

    $('.c-modal__button-close').click(function (e) {
      WIKI._Modal($(this).closest('.c-modal'), false);
    });

    $('.c-modal__backdrop').click(function (e) {
      WIKI._Modal($(this).closest('.c-modal'), false);
    });

    $('.c-modal__trigger-footer-link').click(function (e) {
      e.preventDefault();
      $(this).closest('.c-modal').find('.c-modal__footer').slideToggle();
      $(this).closest('.c-modal').find('.c-modal__form').toggleClass('is-not-active');
      $(this).closest('.c-modal').find('.c-modal__form button[type="submit"]').attr('disabled', true);
    });

    $(window).on('hashchange', function (e) {
      if (window.location.hash == '#login') {
        WIKI._Modal($('.c-modal--signin'), true);
        history.replaceState('', document.title, window.location.origin + window.location.pathname);
      }

      if (window.location.hash == '#new') {
        WIKI._Modal($('.c-modal--add-post'), true);
        history.replaceState('', document.title, window.location.origin + window.location.pathname);
      }

      if (window.location.hash == '#notification') {
        WIKI._Modal($('.c-modal--notification'), true);
        history.replaceState('', document.title, window.location.origin + window.location.pathname);
      }

    }).trigger('hashchange');

    var signinform = $('.c-modal--signin .c-modal__body form');

    signinform.submit(function (e) {
      e.preventDefault();

      var submit_button = $(this).find('button[type="submit"]'),
        formdata = signinform.serialize();

      var ajax = $.ajax({
        type: 'post',
        dataType: 'json',
        url: ajax_url,
        data: formdata,
      })
        .done(function (data, textStatus, jqXHR) {

          signinform.closest('.c-modal').find('.c-modal__response').html(data.text).removeClass('is-success is-error')
            .addClass('is-visible' + ' is-' + data.status).slideDown(200);

          if (data.status == 'success') {
            signinform[0].reset();
            window.location.reload();
          }

        })
        .fail(function (jqXHR, textStatus, errorThrown) {
        });

    });

  }

  WIKI._Modal = function (modal, show) {
    // Close all other modals
    $('.c-modal').removeClass('is-visible').attr('aria-hidden', 'false');

    if (show) {
      $html.addClass('is-scroll-locked');
      WIKI._ScrollLock(modal, true);
      modal.addClass('is-visible');
      modal.attr('aria-hidden', 'false');
    } else {
      $html.removeClass('is-scroll-locked');
      WIKI._ScrollLock(modal, false);
      modal.removeClass('is-visible');
      modal.attr('aria-hidden', 'true');
      modal.find('.c-modal__response').removeClass('is-visible is-success is-error');
    }
  }

  WIKI.LogoutProcess = function () {
    var signoutform = $('.c-user-logout__data');
    var logout_btn = $('.c-user-logout__svg'),
    formdata = signoutform.serialize();

    console.log(formdata);

    logout_btn.on('click', function (e) {
      e.preventDefault();

      var ajax = $.ajax({
        type: 'post',
        dataType: 'json',
        url: ajax_url,
        data: formdata,
      })
        .done(function (data, textStatus, jqXHR) {

          if (data.status == 'success') {
            window.location.reload();
          }

        })
        .fail(function (jqXHR, textStatus, errorThrown) {
        });

    })
  }

  WIKI.addPost = function () {
    var signinform = $('.c-modal--add-post .c-modal__body form');

    signinform.submit(function (e) {
      e.preventDefault();
      console.log('testDSE');
      var submit_button = $(this).find('button[type="submit"]'),
        formdata = signinform.serialize();

      var ajax = $.ajax({
        type: 'post',
        dataType: 'json',
        url: ajax_url,
        data: formdata,
      })
        .done(function (data, textStatus, jqXHR) {

          signinform.closest('.c-modal').find('.c-modal__response').html(data.text).removeClass('is-success is-error')
            .addClass('is-visible' + ' is-' + data.status).slideDown(200);

          if (data.status == 'success') {
            signinform[0].reset();
            window.location.reload();
          }

        })
        .fail(function (jqXHR, textStatus, errorThrown) {
        });

    });

  }

  // WIKI._ScrollLock = function (targetelem, state) {
  //   if (state) {
  //     bodyScrollLock.disableBodyScroll(targetelem[0]);
  //   } else {
  //     bodyScrollLock.enableBodyScroll(targetelem[0]);
  //   }
  // }

  WIKI.stickyMenu = function() {
    var $window        = $(window),
      height          = $window.height(),
      width           = $window.width(),
      menu            = $('.c-main-header'),
      menuheight      = menu.height();

    var scrollTop = $window.scrollTop();

    console.log(scrollTop);
    console.log(menuheight);

    if (scrollTop > (menuheight) ) {
      $('body').addClass('is-sticky');
    }else {
      $('body').removeClass('is-sticky');
    }
  }


  WIKI._ScrollTo = function ($target, offset, offsettype, duration, callback) {
    var offset_default = $('.c-main-header').outerHeight();

    if ($('#wpadminbar:visible').length) offset_default += 32;

    var duration_default = 800;
    var offsettype_default = 'abs';

    if (typeof offset == 'undefined') offset = offset_default;
    if (typeof offsettype == 'undefined') offsettype = offsettype_default;
    if (typeof duration == 'undefined') duration = duration_default;

    if (offsettype == 'rel') {
      offset += offset_default;
    }

    $('html, body').stop().animate({
      scrollTop: typeof $target === 'number' ? $target + 1 : $target.offset().top - offset + 1 // + 1 because of rounding
    }, duration, callback);
  };

  WIKI.MobileOffcanvas = function () {
    var nav = $('.c-main-header');
    $('.c-main-header__nav-trigger-wrapper').on('click', function (e) {
      if(nav.hasClass('js-is-mobile-open')){
        nav.removeClass('js-is-mobile-open')
      } else {
        nav.addClass('js-is-mobile-open');
        $('.c-main-header__wrapper').addClass('js-is-header-fixed')
      }
      $(this).toggleClass('is-open');
      body.toggleClass('is-offcanvas-mobile-open');
      WIKI._ScrollLock($('.c-mobile-offcanvas__main'), body.hasClass('is-offcanvas-mobile-open'));
    });

    $('.c-main-nav-mobile .menu-item__sub-menu-opener ').click(function (e) {
      e.preventDefault();
      $(this).closest('.menu-item').toggleClass('is-expanded').find('.sub-menu').slideToggle();
    });

    $('.c-main-nav-mobile a').on('click', function (e) {
      var $this = $(this)[0];
      if (($this.href && $this.href.indexOf('#') != -1) && ($this.hostname == location.hostname) && (($this.pathname == location.pathname) || ('/' + $this.pathname == location.pathname))) {
        e.preventDefault();
        $('.c-main-header__nav-trigger-wrapper').removeClass('is-open');
        body.removeClass('is-offcanvas-mobile-open');
        WIKI._ScrollLock($('.c-mobile-offcanvas__main'), false);
        WIKI._ScrollTo($($this.hash), 0);
      }
    });
  };

  WIKI._ScrollLock = function (targetelem, state) {
    if (state) {
      body.addClass('is-scroll-locked');
      if (isiOS) bodyScrollLock.disableBodyScroll(targetelem[0]);
    } else {
      body.removeClass('is-scroll-locked');
      if (isiOS) bodyScrollLock.enableBodyScroll(targetelem[0]);
    }
  };

  /* READY FUNCTION
    ============================= */

  $(function () {

    //WIKI.isotope();
    WIKI.LoginProcess();
    WIKI.LogoutProcess();
    WIKI.addPost();
    WIKI.MobileOffcanvas();
  });

  $(window).on('scroll', function() {
    WIKI.stickyMenu();
  })

})(jQuery);
