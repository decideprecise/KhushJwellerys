jQuery(document).ready(function ($) {

    //sticky tbar
    $(document).on('click', '.sticky-t-bar .close', function () {
        $(this).siblings('.sticky-bar-content').slideToggle();
        $('.sticky-t-bar').toggleClass('active');
        $('body').toggleClass('stick-t-bar-hide');

    });

    var slider_auto, slider_loop, rtl;

    if (rara_ecommerce_data.auto == '1') {
        slider_auto = true;
    } else {
        slider_auto = false;
    }

    if (rara_ecommerce_data.loop == '1') {
        slider_loop = true;
    } else {
        slider_loop = false;
    }

    if (rara_ecommerce_data.rtl == '1') {
        rtl = true;
    } else {
        rtl = false;
    }

    // banner slider-layout-one
    $('.site-banner.banner-one .item-wrap').owlCarousel({
        items: 1,
        autoplay: slider_auto,
        loop: slider_loop,
        nav: true,
        dots: false,
        autoplaySpeed: 800,
        rtl: rtl,
        animateOut: rara_ecommerce_data.animation,

        responsive: {
            0: {
                margin: 10,
                stagePadding: 20,
            },
            768: {
                margin: 10,
                stagePadding: 80,
            },
            1025: {
                margin: 40,
                stagePadding: 150,
            },
            1200: {
                margin: 50,
                stagePadding: 200,
            },
            1367: {
                margin: 60,
                stagePadding: 300,
            },
            1501: {
                margin: 68,
                stagePadding: 342,
            }
        }
    });

    //testimonialhomepage
    $('.testimonial-section .testimonial-wrapper .section-grid').addClass('owl-carousel');

    $('.testimonial-section .testimonial-wrapper .section-grid').owlCarousel({
        items: 1,
        loop: false,
        margin: 10,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: false
            },
            600: {
                items: 1,
                nav: false
            },
            1000: {
                items: 1,
                nav: false,
                loop: false
            }
        }

    });

    //salewrapper
    $('.product-sale-section .sale-item-wrapper').owlCarousel({
        items: 3,
        loop: true,
        margin: 25,
        nav: true,
        dots: false,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            767: {
                items: 2,
            },
            1000: {
                items: 3,
                loop: false
            }
        }
    });


    //bannerproductslider
    $('.site-banner.banner-cat-one .item-wrap').addClass('owl-carousel');

    //carouselformobileonly
    $(document).ready(function () {
        if ($(window).width() <= 1024) {
            startCarousel();
        } else {
            $('.site-banner.banner-cat-one .item-wrap').addClass('off');
        }
    });

    $(window).resize(function () {
        if ($(window).width() <= 1024) {
            startCarousel();
        } else {
            stopCarousel();
        }
    });

    function startCarousel() {
        $(".site-banner.banner-cat-one .item-wrap").owlCarousel({
            nav: false,
            slideSpeed: 500,
            paginationSpeed: 400,
            autoplay: false,
            items: 1,
            dots: false,
            itemsDesktop: false,
            itemsDesktopSmall: false,
            itemsTablet: false,
            itemsMobile: false,
            loop: false,
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                },
                768: {
                    items: 2,
                    nav: true,
                    margin: 20,
                },
            }

        });
    }
    function stopCarousel() {
        var owl = $('.site-banner.banner-cat-one .owl-carousel');
        owl.trigger('destroy.owl.carousel');
        owl.addClass('off');
    }

    //homepageblogsectioncarousel
    //adding carouselonresize
    var winWidth = $(window).width();
    $(window).on('resize', function () {
        if ($(window).width() <= 767) {
            $('.blog-section .section-grid').addClass('owl-carousel');
            $('.blog-section .section-grid').owlCarousel({
                items: 1,
                nav: false,
                dots: true,
            });
        }
    });

    if (winWidth <= 767) {
        $('.blog-section .section-grid').addClass('owl-carousel');
        $('.blog-section .section-grid').owlCarousel({
            items: 1,
            nav: false,
            dots: true,
        });
    }

    //backtotop
    $(window).scroll(function () {
        if ($(window).scrollTop() > 200) {
            $('#back-to-top').addClass('show');
        }
        else {
            $('#back-to-top').removeClass('show');
        }
    });

    $('#back-to-top').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 800);
    });

    var topBarHeight = $('.sticky-t-bar.active').outerHeight();
    var adminHeight = $('.admin-bar #wpadminbar').outerHeight();

    $('<button class="angle-down"><i class="fas fa-chevron-down"></i> </button>').insertAfter($('.mobile-header .mbl-header-mid .main-navigation .menu-item-has-children > a'));
    $('.mobile-header .mbl-header-mid .main-navigation .menu-item-has-children .angle-down').click(function () {
        $(this).next().slideToggle();
        $(this).toggleClass('active');
    });
    $('.mobile-header .toggle-btn').on('click', function () {
        $('.mobile-header-popup').slideToggle();
        $('.mobile-header-popup').css('top', adminHeight);

        if ($('.sticky-t-bar').hasClass('active')) {
            $('.mobile-header-popup').css('top', topBarHeight + adminHeight);

        }
    });


    $(window).on('resize', function () {
        var stickyHeight = $('.sticky-t-bar.active').outerHeight();
        var rAdminHeight = $('#wpadminbar').outerHeight();

        if ($('#wpadminbar').length > 0) {
            $('.mobile-header-popup').css('top', 0 + rAdminHeight);
        }

        else if ($('#wpadminbar').length > 0 && stickyHeight) {
            $('.mobile-header-popup').css('top', stickyHeight + rAdminHeight);
        }
        else {
            $('.mobile-header-popup').css('top', 0);

        }
    });


    $(window).on('load', function () {
        var stickyHeight = $('.sticky-t-bar.active').outerHeight();
        var rAdminHeight = $('#wpadminbar').outerHeight();

        if ($('#wpadminbar').length > 0) {
            $('.mobile-header-popup').css('top', 0 + rAdminHeight);
        }

        else if ($('#wpadminbar').length > 0 && stickyHeight) {
            $('.mobile-header-popup').css('top', stickyHeight + rAdminHeight);
        }
        else {
            $('.mobile-header-popup').css('top', 0);

        }
    });



    $('.mobile-header .special-menu .special-toggle-btn').on('click', function () {
        $('.mobile-header .special-menu .category-menu-list ').slideToggle();
    });

    $('.mobile-header .special-menu .close-category-toggle').on('click', function () {
        $('.mobile-header .special-menu .category-menu-list ').slideToggle();
    });

    /**
    * First Letter of word to Drop Cap
    * https://stackoverflow.com/questions/5458605/first-word-selector 
    * https://paulund.co.uk/capitalize-first-letter-string-javascript
    */
    if ($("body").hasClass("single-post") || $("body").hasClass("page")) {
        $.fn.wrapStart = function (numWords) {
            var node = this.contents().filter(function () {
                return this.nodeType == 3;
            }).first(),
                text = node.text(),
                first = text.split(" ", numWords).join(" ");
            firstLetter = first.charAt(0);
            finale = '<span class="dropcap">' + firstLetter + '</span>' + first.slice(1);

            if (!node.length)
                return;

            node[0].nodeValue = text.slice(first.length);
            node.before(finale);
        };
        if (($('.post-template-default').length > 0 || ($('.page-template-default').length > 0 && $('.home').length == 0)) && rara_ecommerce_data.drop_cap == 1) {
            $('.entry-content p').wrapStart(1);
        }
    }

    //for accessibility
    $('.main-navigation ul li a, .special-menu a').on('focus', function () {
        $(this).parents('li').addClass('focused');
    }).on('blur', function () {
        $(this).parents('li').removeClass('focused');
    });

    $(".user-block a").on('focus', function () {
        $(this).parents(".user-block").addClass("hover");
    }).on('blur', function () {
        $(this).parents(".user-block").removeClass("hover");
    });

    $(".cart-block a").on('focus', function () {
        $(this).parents(".cart-block").addClass("hover");
    }).on('blur', function () {
        $(this).parents(".cart-block").removeClass("hover");
    });


    $('.btn-close.close-main-nav-toggle').on('click', function () {
        $('.mobile-header-popup').slideToggle();
    });
});