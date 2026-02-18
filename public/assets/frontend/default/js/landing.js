(function ($) {
    'use strict';

    //mobile menu
    $("#mobile-menu").meanmenu({
        meanMenuContainer: ".mobile-menu",
        meanScreenWidth: "991",
        meanExpand: ['<i class="fa-regular fa-angle-right"></i>'],
    });

    //Sidebar Toggle
    $(".offcanvas-close,.offcanvas-overlay").on("click", function () {
        $(".offcanvas-area").removeClass("info-open");
        $(".offcanvas-overlay").removeClass("overlay-open");
    });
    $(".sidebar-toggle").on("click", function () {
        $(".offcanvas-area").addClass("info-open");
        $(".offcanvas-overlay").addClass("overlay-open");
    });

    //Body overlay Js
    $(".body-overlay").on("click", function () {
        $(".offcanvas-area").removeClass("opened");
        $(".body-overlay").removeClass("opened");
    });

    // Header sticky
    $(window).scroll(function () {
        if ($(this).scrollTop() > 200) {
            $("#header-sticky").addClass("active-sticky");
        } else {
            $("#header-sticky").removeClass("active-sticky");
        }
    });

    // Back to top js  
    var progressPath = document.querySelector(".backtotop-wrap path");
    if (progressPath) {
        var pathLength = progressPath.getTotalLength();
        progressPath.style.transition = progressPath.style.WebkitTransition =
            "none";
        progressPath.style.strokeDasharray = pathLength + " " + pathLength;
        progressPath.style.strokeDashoffset = pathLength;
        progressPath.getBoundingClientRect();
        progressPath.style.transition = progressPath.style.WebkitTransition =
            "stroke-dashoffset 10ms linear";
        var updateProgress = function () {
            var scroll = $(window).scrollTop();
            var height = $(document).height() - $(window).height();
            var progress = pathLength - (scroll * pathLength) / height;
            progressPath.style.strokeDashoffset = progress;
        };
        updateProgress();
        $(window).scroll(updateProgress);
        var offset = 150;
        var duration = 550;
        jQuery(window).on("scroll", function () {
            if (jQuery(this).scrollTop() > offset) {
                jQuery(".backtotop-wrap").addClass("active-progress");
            } else {
                jQuery(".backtotop-wrap").removeClass("active-progress");
            }
        });
        jQuery(".backtotop-wrap").on("click", function (event) {
            event.preventDefault();
            jQuery("html, body").animate({
                scrollTop: 0
            }, duration);
            return false;
        });
    }


    // Customer review slider 
    if ($(".customer-review-slider-active").length > 0) {
        var customerReviewSlider = new Swiper(".customer-review-slider-active", {
            slidesPerView: 3,
            spaceBetween: 30,
            loop: true,
            roundLengths: true,
            autoplay: {
                delay: 3000,
            },
            pagination: {
                el: ".bd-swiper-dot",
                clickable: true,
            },
            breakpoints: {
                1200: {
                    slidesPerView: 3,
                },
                992: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 2,
                },
                576: {
                    slidesPerView: 1,
                },
                0: {
                    slidesPerView: 1,
                },
            },
        });
    }

    // Customer review slider 
    if ($(".trusted-slider-active").length > 0) {
        var trustedSlider = new Swiper(".trusted-slider-active", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            roundLengths: true,
            autoplay: {
                delay: 3000,
            },
            navigation: {
                nextEl: ".trusted-slider-next",
                prevEl: ".trusted-slider-prev",
            },
            pagination: {
                el: ".bd-swiper-dot",
                clickable: true,
            },
        });
    }
    // brand slider 
    if ($(".brand-active").length > 0) {
        var brandSlider = new Swiper('.brand-active', {
            slidesPerView: "auto",
            spaceBetween: "auto",
            freeMode: true,
            loop: true,
            allowTouchMove: false,
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
            },
            spaceBetween: 32,
            speed: 10000,
            slidesPerView: 7,
            breakpoints: {
                '1200': {
                    slidesPerView: 7,
                },
                '992': {
                    slidesPerView: 4,
                },
                '768': {
                    slidesPerView: 3,
                },
                '576': {
                    slidesPerView: 2,
                },
                '0': {
                    slidesPerView: 2,
                },
            },
        });
    }

    if ($(".js-example-basic-single").length > 0) {
        $('.js-example-basic-single').select2();
    }
})(jQuery);
