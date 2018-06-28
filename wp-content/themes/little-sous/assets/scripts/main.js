(function($) {

    LS.stickyNavHeight = 0;

    LS.screenSize = {
        'large': 1130,
        'small': 580,
    };

    LS.breakpoint = {
        'largeOnly': "screen and (min-width:" + LS.screenSize.large + "px)",
        'largeMedium': "screen and (min-width:" + LS.screenSize.small + "px)",
        'mediumSmall': "screen and (max-width:" + LS.screenSize.large + "px)",
        'mediumOnly': "screen and (max-width:" + LS.screenSize.large + "px) and (min-width:" + LS.screenSize.small + "px)",
        'smallOnly': "screen and (max-width:" + LS.screenSize.small + "px)",
    };

    LS.card = {
        init: function() {
            $('.js-card').hover(function() {
                $(this).toggleClass('is-active');
            });
        }
    };

    LS.header = {
        init: function() {
            LS.header.clickHandlers();
            LS.header.sticky();
            LS.header.search();
        },
        clickHandlers: function() {
            $(document).on('click', '.js-menu', function() {
                $('html').toggleClass('is-menu-open');
                $('.js-nav').toggleClass('is-hidden--medium-small');
                $('.js-menu').toggleClass('is-hidden--medium-small');
            });
        },
        sticky: function() {
            enquire.register(LS.breakpoint.largeOnly, {
                match: function() {
                    $('.js-nav').scrollToFixed({
                        fixed: function() {
                            LS.stickyNavHeight = $('.js-nav').height();
                            LS.socialButtons.init();
                        }
                    });
                },
                unmatch: function() {
                    $('.js-nav').trigger('detach.ScrollToFixed');
                }
            });
            enquire.register(LS.breakpoint.mediumSmall, {
                match: function() {
                    $('.js-header').scrollToFixed();
                },
                unmatch: function() {
                    $('.js-header').trigger('detach.ScrollToFixed');
                }
            });
        },
        search: function() {
            $(document).on('click', '.js-search-icon', function() {
                $input = $('.js-search-input');
                $search = $input.parent();
                inputVal = false;

                if ($input.val()) { inputVal = true; }

                if (!inputVal && $input.hasClass('is-active')) {
                    // close search bar
                    $input.removeClass('is-active');
                    $search.removeClass('is-active');

                } else if (!inputVal || (inputVal && !$input.hasClass('is-active'))) {
                    // open search bar
                    $input.focus().addClass('is-active');
                    $search.addClass('is-active');

                } else if ($input.hasClass('is-active')) {
                    // trigger search
                    $('.js-search-submit').click();
                } else {
                    return;
                }

            });
        }
    };

    LS.steps = {
        init: function() {
            LS.steps.clickHandlers();
        },
        clickHandlers: function() {
            $(document).on('click', '.js-step-checkbox', function() {
                $step = $(this).parents('.step');
                $step.toggleClass('is-checked');
                $step.find('.step__content').slideToggle();
            });
        }
    };

    LS.socialButtons = {
        init: function() {
            $('.js-social-buttons').scrollToFixed({
                'marginTop': LS.stickyNavHeight + 30
            });
        }
    };

    LS.slideshow = {
        init: function() {
            LS.slideshow.configure();
            LS.slideshow.nav();
            LS.slideshow.close();
            // LS.dfpAds.init();
            LS.dfpAds.init();
        },
        close: function() {
            $(document).on('click', '.js-slideshow-close', function() {
                $('.js-slides, .js-slides-sidebar, .js-slides-thumbnails').slick('unslick');
                $('.js-slideshow').hide();
                $('html, body').removeClass('is-slideshow-open');
            });
        },
        configure: function() {
            $('.js-slides').slick({
                asNavFor: '.js-slides-sidebar, .js-slides-thumbnails',
                fade: true,
                arrows: false,
            });
            $('.js-slides-sidebar').slick({
                asNavFor: '.js-slides, .js-slides-thumbnails',
                fade: true,
                arrows: false,
            });
            $('.js-slides-thumbnails').slick({
                slidesToShow: 9,
                slidesToScroll: 1,
                asNavFor: '.js-slides, .js-slides-sidebar',
                dots: false,
                centerMode: false,
                focusOnSelect: true,
                arrows: false,
                variableWidth: true,
            });
        },
        nav: function() {
            $(document).on('click', '.js-slides-left', function() {
                $parent = $(this).closest('.js-slideshow');
                $slideshow = $parent.find('.js-slides');
                $slideshow.slick('slickPrev');
            });
            $(document).on('click', '.js-slides-right', function() {
                $parent = $(this).closest('.js-slideshow');
                $slideshow = $parent.find('.js-slides');
                $slideshow.slick('slickNext');
            });
        },
    };

    $(document).ready(function(){
        LS.dfpAds.inject_ads();
        LS.dfpAds.init();
        LS.card.init();
        LS.header.init();
        LS.steps.init();

        if (LS.LoadMorePostsArray) {
            for (var i = 0; i < LS.LoadMorePostsArray.length; i++) {
                new LoadMorePosts(LS.LoadMorePostsArray[i]);
            }
        }

        if (LS.LoadSlideshowArray) {
            for (var j = 0; j < LS.LoadSlideshowArray.length; j++) {
                new LoadSlideshow(LS.LoadSlideshowArray[j]);
            }
        }

    });

    $(window).on('more_loaded', function() {
        LS.dfpAds.refresh();
        LS.card.init();
    });

    $(window).load(function() {
        LS.dfpAds.sticky_ads();
    });

    $(window).on('slideshow_loaded', function() {
        // $('.slideshow .is-loading-overlay__loader').hide();
        // $('.js-royalSlider').removeClass('is-invisible');
        LS.slideshow.init();
    });





})(jQuery);