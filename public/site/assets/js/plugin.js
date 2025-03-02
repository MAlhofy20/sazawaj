jQuery(function () {
    "use strict";

    // ************************ Fakes the loading setting a timeout ************************
    setTimeout(function () {
        jQuery("body").addClass("loaded");
    }, 1000);


    // ************************ fixed menu ************************
    jQuery(window).scroll(function () {
        if (jQuery(window).scrollTop() > 30) {
            jQuery('header').addClass('stick');
        } else {
            jQuery('header').removeClass('stick');
        }
    });


    // ************************ Main Carousel ************************
// main Slider
    var mainSlider = new Swiper(".main-slider", {
        // Optional parameters
        direction: "horizontal",
        autoHeight: true,
        loop: true,
        speed: 1200,
        grabCursor: true,
        allowTouchMove: false,
        touchRatio: 0,
        // autoplay: {
        //     delay: 2500,
        //     disableOnInteraction: true,
        // },
        navigation: {
            nextEl: ".mainArrow.swiper-button-next",
            prevEl: ".mainArrow.swiper-button-prev",
        },
    });


    // ************************ Check if Rtl  ************************
    var rtlVal = false;
    jQuery('html').attr("dir") == "ltr" ? rtlVal = false : rtlVal = true;


    // ************************ cat carousel ************************
    if (jQuery('.authors-carousel').length) {
        jQuery('.authors-carousel').slick({
            rtl: rtlVal,
            arrows: false,
            dots: true,
            infinite: true,
            slidesToScroll: 4,
            speed: 300,
            slidesToShow: 4,
            autoplay: true,
            autoplaySpeed: 2000,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4,
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });
    }
    jQuery('.authors-carousel .slick-slide').css('margin-right', '38px');


    // ************************ Side menu ************************

    // Function to toggle the sidebar
    function addSidebar() {
        jQuery(".open-me label").addClass("active");

        var direction = jQuery("html").attr("dir");
        if (direction === "rtl") {
            jQuery("main").addClass("helpMoveRTL");
        } else {
            jQuery("main").addClass("helpMoveLTR");
        }

        jQuery(".menu-item").addClass("special");
        jQuery(".sidebar").addClass("noo");
    }

    function removeSidebar() {
        jQuery(".open-me label").removeClass("active");

        var direction = jQuery("html").attr("dir");
        if (direction === "rtl") {
            jQuery("main").removeClass("helpMoveRTL");
        } else {
            jQuery("main").removeClass("helpMoveLTR");
        }

        jQuery(".menu-item").removeClass("special");
        jQuery(".sidebar").removeClass("noo");
    }

    function toggleSubmenu() {
        if (jQuery(this).hasClass("open")) {
            jQuery(this)
                .siblings(".sub-menu")
                .animate({height: "hide", opacity: "hide"}, "slow");
            jQuery(this)
                .removeClass("open fa-solid fa-minus")
                .addClass("fa-solid fa-plus");
        } else {
            jQuery(this).parent().siblings(".menu-item").find(".sub-menu").animate(
                {
                    height: "hide",
                    opacity: "hide",
                },
                "slow",
            );
            jQuery(this)
                .parent()
                .siblings(".menu-item")
                .find("i")
                .removeClass("open fa-solid fa-minus")
                .addClass("fa-solid fa-plus");
            jQuery(this)
                .siblings(".sub-menu")
                .animate({height: "show", opacity: "show"}, "slow");
            jQuery(this)
                .removeClass("fa-solid fa-plus")
                .addClass("open fa-solid fa-minus");
        }
    }

    jQuery(".open-me label").on("change", function () {
        addSidebar();
    });
    jQuery(".close-me label").on("change", function () {
        removeSidebar();
    });
    jQuery(document).keyup(function (e) {
        if (e.keyCode === 27) {
            removeSidebar();
        }
    });
    jQuery(".dd-trigger").on("click", toggleSubmenu);


    // ************************ INPUT FOCUS ANIMATION ************************
    jQuery("input, textarea").focus(function () {
        jQuery(this).closest(".form-group").addClass("focus-visible");
    });
    jQuery("input, textarea").each(function () {
        if (jQuery(this).val() != "") {
            jQuery(this).closest(".form-group").addClass("focus-visible");
        }
    });
    jQuery("input, textarea").focusout(function () {
        if (jQuery(this).val() === "")
            jQuery(this).closest(".form-group").removeClass("focus-visible");
    });

    var btn = jQuery('.top');
    btn.on('click', function () {
        jQuery('html, body').animate({scrollTop: 0}, '1000');
    })


  //************************ Static ************************
    if (jQuery(".statics").length) {
        var a = 0;
        jQuery(window).scroll(function () {
            var $top = jQuery(".static-num").offset().top - window.innerHeight;
            if (a == 0 && jQuery(window).scrollTop() > $top) {
                jQuery(".static-num").each(function () {
                    var $this = jQuery(this),
                        countTo = $this.attr("data-number");
                    jQuery({ countNum: $this.text() }).animate(
                        { countNum: countTo },
                        {
                            duration: 2000,
                            easing: "swing",
                            step: function () {
                                $this.text(Math.floor(this.countNum).toLocaleString('de-DE'));
                            },
                            complete: function () {
                                $this.text(parseFloat(this.countNum).toLocaleString('de-DE'));
                            },
                        }
                    );
                });
                a = 1;
            }
        });
    }


    // ************************ tabs ************************
    jQuery("#library-tabs li:first-child").addClass("activeCat");
    jQuery(".book-card").hide();
    jQuery(".book-card:first").show(); // Show the first tab content initially
    // Click function
    jQuery("#library-tabs li").click(function () {
        if (!jQuery(this).hasClass("activeCat")) {
            var tab_id = jQuery(this).find("a").attr("data-tab");

            jQuery("#library-tabs li").removeClass("activeCat");
            jQuery(this).addClass("activeCat");
            jQuery(".book-card").slideUp();
            jQuery('.book-card[data-tab="' + tab_id + '"]').slideDown(); // Show the corresponding tab content
        }
        return false;
    });
    jQuery(document).ready(function($) {
        $('.slick.marquee').slick({
            speed:30000,
            autoplay: true,
            autoplaySpeed: 0,
            centerMode: true,
            cssEase: 'linear',
            slidesToShow: 1,
            slidesToScroll: 1,
            variableWidth: true,
            infinite: true,
            initialSlide: 1,
            arrows: false,
            buttons: false
        });
    });

    const sr = ScrollReveal({
      distance: '50px',
      duration: 1000,
      easing: 'cubic-bezier(0.215, 0.61, 0.355, 1)',
      interval: 150,
      reset: true,
    });

    // Apply animation to elements revealing from the top
    sr.reveal('.sec-tit, .about-img, .statics [class*="col-"]:not(.static-card [class*="col-"]):nth-child(odd), .new-members [class*="col-"]:nth-child(odd)', {
      origin: 'top',
      scale: 1,
      opacity: 0,
      delay: 200,
      distance: '50px',
    });

    // Apply the animation to elements revealing from the bottom
    sr.reveal('.about-content, .tip, .statics [class*="col-"]:not(.static-card [class*="col-"]):nth-child(even), .new-members [class*="col-"]:nth-child(even)', {
      origin: 'bottom',
      scale: 1,
      opacity: 0,
      delay: 200,
    });

    // Apply a different animation to elements revealing from the right
    sr.reveal('.about-url', {
      origin: 'right',
      distance: '100px',
      scale: 1.2,
      opacity: 0,
      delay: 300,
    });

});

//wow
wow = new WOW(
    {
        boxClass:     'wow',      // default
        animateClass: 'animated', // default
        offset:       0,          // default
        mobile:       true,       // default
        live:         true        // default
    }
)
new WOW().init();
