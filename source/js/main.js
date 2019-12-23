(function($) {
"use strict";
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

  WIKI.isotope = function() {
    var isotope = $('.c-archive');
    isotope.isotope({
      itemSelector: '.c-archive .c-entry',
      masonry: {
        // use outer width of grid-sizer for columnWidth
        columnWidth: '.grid-sizer'
      }
    })
  }

  WIKI.LoginProcess = function() {
    $('.c-modal__close').click(function(e) {
      WIKI._Modal($(this).closest('.c-modal'), false);
    });

    $('.c-modal__button-close').click(function(e) {
      WIKI._Modal($(this).closest('.c-modal'), false);
    });

    $('.c-modal__backdrop').click(function(e) {
      WIKI._Modal($(this).closest('.c-modal'), false);
    });

    $('.c-modal__trigger-footer-link').click(function(e) {
      e.preventDefault();
      $(this).closest('.c-modal').find('.c-modal__footer').slideToggle();
      $(this).closest('.c-modal').find('.c-modal__form').toggleClass('is-not-active');
      $(this).closest('.c-modal').find('.c-modal__form button[type="submit"]').attr('disabled', true);
    });

    $(window).on('hashchange', function (e) {
      if(window.location.hash == '#login') {
        WIKI._Modal($('.c-modal--signin'), true);
        history.replaceState('', document.title, window.location.origin + window.location.pathname);
      }

      if(window.location.hash == '#notification') {
        WIKI._Modal($('.c-modal--notification'), true);
        history.replaceState('', document.title, window.location.origin + window.location.pathname);
      }

    }).trigger('hashchange');

    var signinform = $('.c-modal--signin .c-modal__body form');

    signinform.submit(function(e) {
      e.preventDefault();

      var submit_button = $(this).find('button[type="submit"]'),
        formdata = signinform.serialize();

      var ajax = $.ajax({
        type : 'post',
        dataType : 'json',
        url: ajax_url,
        data: formdata,
      })
        .done(function(data, textStatus, jqXHR) {

          signinform.closest('.c-modal').find('.c-modal__response').html(data.text).removeClass('is-success is-error').addClass('is-visible' + ' is-' + data.status).slideDown(200);

          if(data.status == 'success') {
            signinform[0].reset();
            window.location.reload();
          }

        })
        .fail(function(jqXHR, textStatus, errorThrown) {
        });

    });

  }

  WIKI._Modal = function(modal, show) {
    // Close all other modals
    $('.c-modal').removeClass('is-visible').attr('aria-hidden', 'false');

    if(show) {
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

  WIKI._ScrollLock = function(targetelem, state) {
    if(state) {
      bodyScrollLock.disableBodyScroll(targetelem[0]);
    } else {
      bodyScrollLock.enableBodyScroll(targetelem[0]);
    }
  }

    
  /* READY FUNCTION
    ============================= */
   
  $(function() {

    WIKI.isotope();
    WIKI.LoginProcess();

    
  });
  
})(jQuery);