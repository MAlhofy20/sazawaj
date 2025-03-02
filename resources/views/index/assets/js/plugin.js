jQuery(function () {
    'use strict';

    // Mobile Menu
    jQuery('.mobile-nav-list .sub-menu').slideUp();
    jQuery('.mobile-nav-list .menu-item > i').on('click', function () {
        if (jQuery(this).hasClass('open')) {
            jQuery(this).siblings('.sub-menu').slideUp();
            jQuery(this).removeClass('open');
        } else {
            jQuery(this).parent().siblings(".menu-item").find(".sub-menu").slideUp();
            jQuery(this).parent().siblings(".menu-item").find("i").removeClass("open");
            jQuery(this).siblings('.sub-menu').slideDown();
            jQuery(this).addClass('open')
        }
    });
    jQuery('.nav-btn').on('click', function () {
        jQuery('.mobile-nav-list, .nav-overlay').addClass('trans-none');
        return false;
    });
    jQuery('.nav-overlay').on('click', function () {
        jQuery('.mobile-nav-list, .nav-overlay').removeClass('trans-none')
    });


    //
    jQuery('.screenCarousel').owlCarousel({
        rtl: true,
        margin: 40,
        smartSpeed: 1500,
        nav: false,
        navText: ['<i class="fas fa-long-arrow-alt-left"></i>', '<i class="fas fa-long-arrow-alt-right"></i>'],
        dots: true,
        loop: true,
        autoplay: false,
        autoplayHoverPause: true,
        autoplayTimeout: 2000,
        mouseDrag: true,
        touchDrag: true,
        //center: true,
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 3,
            },
            992: {
                items: 5,
            }
        }
    });
    jQuery('.screenCarousel .owl-stage').after('<div class="owl-stage-outer-bg"></div>');


    //
    if (jQuery('.app-statics').length) {
        var a = 0;
        jQuery(window).scroll(function () {
            var oTop = jQuery('.app-static-item-num').offset().top - window.innerHeight;
            if (a == 0 && jQuery(window).scrollTop() > oTop) {
                jQuery('.app-static-item-num').each(function () {
                    var $this = jQuery(this),
                        countTo = $this.attr('data-count');
                    jQuery({
                        countNum: $this.text()
                    }).animate({
                            countNum: countTo
                        },
                        {
                            duration: 2000,
                            easing: 'swing',
                            step: function () {
                                $this.text(Math.floor(this.countNum));
                            },
                            complete: function () {
                                $this.text(this.countNum);
                                //alert('finished');
                            }
                        });
                });
                a = 1;
            }
        });
    }


    //ScrollReveal
    window.sr = ScrollReveal({
        reset: true,
        duration: 500,
        useDelay: "always",
        mobile: false,
        //delay: 200,
        afterReveal: function (el) {
            jQuery(el).attr("style", "");
        }
    });
    sr.reveal(".head-menu,.banner-data-vision," +
        ".sec-tit," +
        ".about-item," +
        ".app-static-item," +
        ".app-download-logo", {origin: "top"});
    sr.reveal(".banner-data-main," +
        ".sec-slogan," +
        ".partner-item," +
        ".app-download-urls," +
        ".app-download-contact-item ", {origin: "bottom"});
    sr.reveal(".about-data [class*='col']:first-of-type," +
        ".app-categories [class*='col']:first-of-type", {origin: "right"});
    sr.reveal(".home-banner [class*='col']:last-of-type," +
        ".app-categories [class*='col']:last-of-type," +
        ".app-downloads [class*='col']:last-of-type", {origin: "left"});


});
