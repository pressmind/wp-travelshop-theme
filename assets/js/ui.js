jQuery(function ($) {

    // ------------------------------------------------
    // -- smooth scroll
    // ------------------------------------------------

    $('.smoothscroll').on('click', function (e) {
        e.preventDefault();
        var target = this.hash;
        var $target = $(target);
        $('html, body').stop().animate({
            'scrollTop': $target.offset().top
        }, 900, 'swing', function () {
            window.location.hash = target;
        });
    });

    // ------------------------------------------------
    // -- pull to refresh feature
    // ------------------------------------------------

    PullToRefresh.init({
        mainElement: 'body',
        distIgnore: 50,
        onRefresh: function () {
            window.location.reload();
        }
    });

    // ------------------------------------------------
    // -- sticky / hide handling sticky booking cta
    // -- using content-main
    // ------------------------------------------------
    if ($('.sticky-booking-cta').length > 0) {
        var scrollPos = $(window).scrollTop(),
            hideTrigger = ($('.content-main').offset().top + $('.content-main').height()) - ($(window).height() * 1.75);

        if (scrollPos > hideTrigger) {
            $('.sticky-booking-cta').hide(300);
        } else {
            $('.sticky-booking-cta').show(300);
        }

        // -- again by scroll
        $(window).scroll(function (e) {
            scrollPos = $(window).scrollTop();
            hideTrigger = ($('.content-main').offset().top + $('.content-main').height()) - ($(window).height() * 1.75);

            if (scrollPos > hideTrigger) {
                $('.sticky-booking-cta').hide(300);
            } else {
                $('.sticky-booking-cta').show(300);
            }
        });
    }
    // --------------------------------
    // --- Affix Header
    // --------------------------------
    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll >= 200) {
            $('.header-main').addClass('affix');
        } else {
            $('.header-main').removeClass('affix');
        }
    });

    // --------------------------------
    // --- Detail Bottom Bar
    // --------------------------------
    $(window).scroll(function () {
        var currentScrollPosition = $(window).scrollTop();
        if (currentScrollPosition >= 400 && currentScrollPosition <= ($('.footer-main').offset().top - (Math.max(document.documentElement.clientHeight, window.innerHeight || 0) - 250))) {
            $('.mobile-bar').addClass('show');
        } else {
            $('.mobile-bar').removeClass('show');
        }
    });

    // --------------------------------
    // --- Detail Image Slider
    // --------------------------------
    if ($('.image-slider').length > 0) {
        var slider = tns({
            container: '.image-slider',
            items: 1,
            mouseDrag: true,
            navContainer: '.image-slider',
            navAsThumbnails: true,
            edgePadding: 15,
            responsive: {
                992: {
                    disable: true
                }
            },
            controlsText: ['<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#06f" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                '  <path stroke="none" d="M0 0h24v24H0z"/>\n' +
                '  <polyline points="15 6 9 12 15 18" />\n' +
                '</svg>', '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#06f" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                '  <path stroke="none" d="M0 0h24v24H0z"/>\n' +
                '  <polyline points="9 6 15 12 9 18" />\n' +
                '</svg>'
            ]
        })
    }

    // -----------------------------------------------
    // -- Itinerary Steps Toggle
    // -----------------------------------------------
    if ($('.itinerary').length > 0) {
        $('.itinerary-step').find('h3').on('click', function (e) {
            $(e.target).parent().toggleClass('step-open');
        });
        $('.itinerary-toggleall .it-open').on('click', function () {
            $('.itinerary-step').addClass('step-open');
            $('.it-close').css('display', 'inline-block');
            $('.it-open').css('display', 'none');
        });
        $('.itinerary-toggleall .it-close').on('click', function () {
            $('.itinerary-step').removeClass('step-open');
            $('.it-open').css('display', 'inline-block');
            $('.it-close').css('display', 'none');
        });
    }

    // -----------------------------------------------
    // -- Description Block Toggle
    // -----------------------------------------------
    if ($('.description-block-wrapper').length > 0) {
        $('.description-block-element').find('h3').on('click', function (e) {
            $(e.target).parent().toggleClass('description-block-open');
        });
    }

    // --------------------------------
    // --- Itinerary Steps Image Slider
    // --------------------------------
    if ($('.itinerary-step-gallery').length > 0) {

        if ($(window).width() < 992) {
            $('.itinerary-step-gallery').each(function (key) {
                let slider = tns({
                    container: '.it-gallery-' + key,
                    items: 1,
                    mouseDrag: true,
                    navContainer: '.it-gallery-' + key,
                    navAsThumbnails: true,
                    edgePadding: 15,
                    responsive: {
                        992: {
                            disable: true
                        }
                    },
                    controlsText: ['<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#06f" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                        '  <path stroke="none" d="M0 0h24v24H0z"/>\n' +
                        '  <polyline points="15 6 9 12 15 18" />\n' +
                        '</svg>', '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#06f" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                        '  <path stroke="none" d="M0 0h24v24H0z"/>\n' +
                        '  <polyline points="9 6 15 12 9 18" />\n' +
                        '</svg>'
                    ]
                })
            });
        }
    }

    // --------------------------------
    // --- Description Block Image Slider
    // --------------------------------
    if ($('.description-block-element-gallery').length > 0) {

        if ($(window).width() <= 992) {
            $('.description-block-element-gallery').each(function (key) {
                let slider = tns({
                    container: '.description-block-gallery-' + key,
                    items: 1,
                    mouseDrag: true,
                    navContainer: '.description-block-gallery-' + key,
                    navAsThumbnails: true,
                    edgePadding: 15,
                    responsive: {
                        992: {
                            disable: true
                        }
                    },
                    controlsText: ['<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#06f" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                        '  <path stroke="none" d="M0 0h24v24H0z"/>\n' +
                        '  <polyline points="15 6 9 12 15 18" />\n' +
                        '</svg>', '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#06f" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                        '  <path stroke="none" d="M0 0h24v24H0z"/>\n' +
                        '  <polyline points="9 6 15 12 9 18" />\n' +
                        '</svg>'
                    ]
                })
            });
        }
    }

    // -----------------------------------------------
    // -- Tooltips for images
    // -----------------------------------------------
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });


    // --------------------------------
    // --- Gallery
    // --------------------------------
    if ($('.detail-gallery-overlay-inner').length > 0) {
        var slider = tns({
            container: '.detail-gallery-overlay-inner',
            items: 1,
            mouseDrag: true,
            navContainer: '#detail-gallery-thumbnails',
            navAsThumbnails: true,
            controlsText: ['<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                '  <path stroke="none" d="M0 0h24v24H0z"/>\n' +
                '  <polyline points="15 6 9 12 15 18" />\n' +
                '</svg>', '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                '  <path stroke="none" d="M0 0h24v24H0z"/>\n' +
                '  <polyline points="9 6 15 12 9 18" />\n' +
                '</svg>'
            ]
        })
    }

    if ($('.detail-image-grid-holder').length > 0 || $('.detail-gallerythumb').length > 0) {
        function addGalleryClasses() {
            console.log('open');
            $('.detail-gallery-overlay').addClass('is--show');
            $('body').addClass('modal-open');
        }

        function removeGalleryClasses() {
            console.log('close');
            $('.detail-gallery-overlay').removeClass('is--show');
            $('body').removeClass('modal-open');
        }
        $('.detail-image-grid-holder img').on('click', function () {
            addGalleryClasses();
        })
        $('.detail-gallery-overlay-close').on('click', function () {
            removeGalleryClasses();
        })
        $('.detail-gallerythumb').on('click', function () {
            addGalleryClasses();
        })
    }

    // --------------------------------
    // --- Detail Image Gallery Thumb
    // --------------------------------
    if ($('.detail-gallerythumb').length > 0) {
        $('.detail-gallerythumb').width($('.detail-gallerythumb').height());
        $(window).resize(function () {
            $('.detail-gallerythumb').width($('.detail-gallerythumb').height());
        })
    }


    // --------------------------------
    // --- Breadcrumb
    // --------------------------------
    if ($('.breadcrumb').length > 0) {
        function renderBreadCrumb(bc) {
            let itemsWidth = 0;
            bc.children().each(function (key, item) {
                itemsWidth += $(item).outerWidth();
            });
            if ($(window).width() <= itemsWidth + 60) {
                bc.children().hide();
                $('.bc-separator').css('display', 'flex');
                // bc.children().first().show();
                // bc.children().last().show();
            } else {
                // console.log(false);
                bc.children().show();
                $('.bc-separator').hide();
            }
        }

        renderBreadCrumb($('.breadcrumb'));

        $(window).resize(function () {
            renderBreadCrumb($('.breadcrumb'));
        })
    }

    // --------------------------------
    // --- Booking Calendar
    // --------------------------------

    if ($('.booking-calendar-slider').length > 0) {
        var booking_calendar_slider = tns({
            container: '.booking-calendar-slider',
            items: 3,
            mouseDrag: true,
            loop: false,
            nav: false,
            controlsText: ['<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                '  <path stroke="none" d="M0 0h24v24H0z"/>\n' +
                '  <polyline points="15 6 9 12 15 18" />\n' +
                '</svg>', '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
                '  <path stroke="none" d="M0 0h24v24H0z"/>\n' +
                '  <polyline points="9 6 15 12 9 18" />\n' +
                '</svg>'
            ]
        })
    }

    // --------------------------------
    // --- Register PWA ServiceWorker
    // --------------------------------

    if (ts_pwa && 'serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            navigator.serviceWorker.register('/service-worker.min.js').then(function (registration) {
                // Registration was successful
                //console.log('ServiceWorker registration successful with scope: ', registration.scope);
            }, function (err) {
                // registration failed :(
                //console.log('ServiceWorker registration failed: ', err);
            });
        });
    }

    // ------------------------------
    // -- content modal
    // ------------------------------

    if ($('.modal-wrapper').length > 0) {
        $('a[data-modal="true"]').on('click', function (e) {
            e.preventDefault();
            let modalId = $(this).data('modal-id');
            // -- show modal
            $('body').find('#modal-id-post-' + modalId).addClass('is--open');
            let target = document.querySelector('.is--open .modal-body-outer');
            bodyScrollLock.disableBodyScroll(target);
            e.stopPropagation();
        })

        $('.modal-close').on('click', function (e) {
            e.preventDefault();
            let target = document.querySelector('.is--open .modal-body-outer');
            $('.modal-wrapper.is--open').removeClass('is--open');
            bodyScrollLock.enableBodyScroll(target);
            e.stopPropagation();
        })

        $(document).on('keyup', function (e) {
            if (e.which == 27) $('.modal-close').click(); // esc
        });
    }

    // ------------------------------
    // -- view switch on result page
    // ------------------------------
    if ($('.pm-switch-result-view').length > 0) {

        if (window.localStorage.getItem('pm-switch-checkbox') == '1') {
            $('.pm-switch-result-view .pm-switch-checkbox').prop('checked', true);
        }

        $('#search-result').on('click', '.pm-switch-result-view .pm-switch-checkbox', function (e) {

            let query_string = window.location.search.replace(/(\?|&)(view=).*?(&|$)/, '');

            if ($(this).prop('checked') == true) {
                window.localStorage.setItem('pm-switch-checkbox', '1');
                if (query_string == '') {
                    query_string += '?'
                } else {
                    query_string += '&'
                }
                query_string += 'view=' + $(this).val();

            } else {
                window.localStorage.removeItem('pm-switch-checkbox');
            }

            window.history.pushState(null, '', window.location.pathname + query_string);
            location.reload();

        })
    }

    /**
     * this removes a current jquery violation:
     * "Added non-passive event listener to a scroll-blocking 'touchstart' event. Consider marking event handler as 'passive' to make the page more responsive"
     * https://stackoverflow.com/questions/46094912/added-non-passive-event-listener-to-a-scroll-blocking-touchstart-event
     * @type {{setup: $.event.special.touchstart.setup}}
     */
    $.event.special.touchstart = {
        setup: function (_, ns, handle) {
            if ((ns.indexOf('noPreventDefault') > -1)) {
                this.addEventListener("touchstart", handle, {
                    passive: false
                });
            } else {
                this.addEventListener("touchstart", handle, {
                    passive: true
                });
            }
        }
    };




    // -----------------------
    // --- Content slider
    // -----------------------

    if ($('.content-block-content-slider .content-slider--inner').length > 0 && $('.content-block-content-slider .content-slider--inner .content-slider--item').length > 1) {

        var contentSlider = tns({
            container: '.content-slider--inner',
            items: 1,
            slideBy: 'page',
            autoplay: true,
            autoplayTimeout: 7500,
            autoplayButton: false,
            autoplayHoverPause: true,
            prevButton: '.prev-button',
            nextButton: '.next-button',
            nav: false,
            autoHeight: false, // if this is set to true, we have a white space on load effect... perhaps a bug in the tiny-slider
        });

    }

});