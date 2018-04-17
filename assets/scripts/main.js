/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 *
 * ======================================================================== */
(function($) {
  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var tofino = {
    // JavaScript to be fired on all pages
    common: {
      init: function() {
        WebFontConfig = {
          google: {
            families: [
              'Coustard'
            ]
          },
          // custom: {
          //     families: ['Parker', "Montserrat"]
          // },
          // inactive: function () {
          //   $('body').css({ 'visibility': 'visible' });
          // },
          // active: function () {
          //   $('body').css({ 'visibility': 'visible' });
          // },
          timeout: 2000
        };
        (function () {
          var wf = document.createElement('script');
          wf.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://ajax.googleapis.com/ajax/libs/webfont/1.5.18/webfont.js';
          wf.type = 'text/javascript';
          wf.async = 'true';
          var s = document.getElementsByTagName('script')[0];
          s.parentNode.insertBefore(wf, s);
        }());
        //Iniitalize svg4everybody
        svg4everybody();

        //List for notication close
        $('#tofino-notification .close').on('click', function() {
          if (tofinoJS.cookieExpires) {
            Cookies.set('tofino-notification-closed', 'yes', {expires: parseInt(tofinoJS.cookieExpires)});
          } else {
            Cookies.set('tofino-notification-closed', 'yes');
          }
        });

        //Assign sticky
        var $sticky = $('.navbar-sticky-top');

        if ($sticky.length) {
          //Sticky polyfill for css position: sticky
          $sticky.Stickyfill();

          //Assign stick offset
          var stickyTop = $sticky.offset().top;

          $(window).scroll(function() {
            if ($(this).scrollTop() > stickyTop) {
              $sticky.addClass('stuck');
            } else {
              $sticky.removeClass('stuck');
            }
          });
        }

        $('.slick-wrap').slick({
          infinite: true,
          autoplay: true,
          autoplaySpeed: 2500,
          fade: true,
          cssEase: 'linear',
          dots: false,
          arrows: true
        });

        $('.modal-link').on('click', function(){
          var target = $(this).data('target');
          location.hash = target;
        })

        if (location.hash) {
          $(location.hash).modal('show');
        }
      }
    },
    // Home page
    home: {
      init: function() {
        $('.hero-images').slick({
          infinite: true,
          autoplay: true,
          autoplaySpeed: 3500,
          fade: true,
          cssEase: 'linear',
          dots: false,
          arrows: false
        });
      }
    },
    blog: {
      init: function() {
        $('.testimonial-wrapper').slick({
          infinite: true,
          autoplay: true,
          autoplaySpeed: 2500,
          fade: true,
          cssEase: 'linear',
          dots: false,
          arrows: false
        });

        var feed = new Instafeed({
          get: 'user',
          userId: '3130462414',
          accessToken: '3130462414.1677ed0.2aae7962ffd04940bcb04c69cb7dc28b',
          template: '<div class="col-xs-6 col-sm-4 col-md-2 col-instafeed"><img src="{{image}}" /></div>',
          resolution: 'standard_resolution',
          limit: 12
        });
        feed.run();
      }
    }
  };
  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var namespace = tofino;
      funcname = funcname === undefined ? 'init' : funcname;
      if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      UTIL.fire('common');
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
      });
    }
  };
  $(UTIL.loadEvents);

}(jQuery));  // Fully reference jQuery after this point.
