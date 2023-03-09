jQuery(function ($) {


    // ------------------------------------------------
    // -- little fix for 100vw
    // ------------------------------------------------
    function setVw() {
        let vw = document.documentElement.clientWidth / 100;
        document.documentElement.style.setProperty('--vw', `${vw}px`);
    }

    setVw();
    window.addEventListener('resize', setVw);
    
    // ------------------------------------------------
    // -- is mobile?
    // ------------------------------------------------
    let isMobile = deviceDetection(); // initial false

    function deviceDetection() {
        if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
            || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
            isMobile = true;
        }

        return false;
    }

    // ------------------------------------------------
    // -- share page
    // ------------------------------------------------
    let sharePage = $('.page-share');

    if ( sharePage.length > 0 ) {

        var sharePageLink = sharePage.find('.page-share-toggler');

        sharePageLink.on('click', function(e) {
            e.preventDefault();

            // -- check if functionality "navigator.share" is given and is moble
            if ( navigator.share && isMobile ) {
                navigator.share({
                    title: document.title,
                    url: $(this).data('share-link'),
                }).then(() => {
                    // @todo: hier kann man noch nen callback machen, zum beispiel der Button wird kurz grün mit einem "check" drin o.ä,
                    console.log("Vielen Dank für's teilen!");
                });
            } else {
                sharePage.addClass('is-open');
            }

            e.stopPropagation();
        });

        // -- close mechanism for share modal
        sharePage.find('.close-share').on('click', function(e){
            e.preventDefault();

            sharePage.removeClass('is-open');

            e.stopPropagation();
        });

        // -- share options
        // -- close modal after timeout when button clicked
        sharePage.find('.share-button:not(.share-button--copy)').on('click', function(e) {
            setTimeout(function() {
                sharePage.removeClass('is-open');
            }, 2500);
        });

        // -- copy functionality
        sharePage.find('.share-button--copy').on('click', function(e) {
            e.preventDefault();

            var linkToCopy = sharePage.find('.page-share-toggler').data('share-link');

            navigator.clipboard.writeText(linkToCopy).then(function() {
                sharePage.find('.share-copy-info--success').fadeIn(250);

                setTimeout(function() {
                    sharePage.find('.share-copy-info--success').fadeOut(250);
                }, 1500);

                setTimeout(function() {
                    sharePage.removeClass('is-open');
                }, 2500);
            }, function(err) {
                sharePage.find('.share-copy-info--error').fadeIn(250);

                setTimeout(function() {
                    sharePage.find('.share-copy-info--error').fadeOut(250);
                }, 1500);
            });

            e.stopPropagation();
        });

    }

    // ------------------------------------------------
    // -- Auto Popup
    // ------------------------------------------------
    if($('#modal-id-post-automodal').length) {
        let aboutToleave = false;
        let timeoutId;
        let active = true;

        if(active && $('#auto-modal-content').attr('data-type') == 'leave') {
            if(localStorage.getItem('leaveMessageFired') == 'true' && $('#auto-modal-content').attr('data-multiple') == 'false') {
                active = false;
            }
            $(document).mouseleave(function () {
                timeoutId = setTimeout(() => {
                    aboutToleave = true;
                }, $('#auto-modal-content').attr('data-delay'))
            });
            $(document).mouseenter(function () {
                clearTimeout(timeoutId);
                aboutToleave = false;
            });
            let leaveMessageInt = setInterval(() => {
                if(aboutToleave) {
                    $('#modal-id-post-automodal').addClass('is--open');
                    if($('#auto-modal-content').attr('data-multiple') == 'false') {
                        localStorage.setItem('leaveMessageFired', 'true');
                        clearInterval(leaveMessageInt);
                    }
                }
            }, 500);
        }
        if(active && $('#auto-modal-content').attr('data-type') == 'delay') {
            timeoutId = setTimeout(() => {
                $('#modal-id-post-automodal').addClass('is--open');
            }, $('#auto-modal-content').attr('data-delay'))
        }

    }
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

    // -------------------------------------
    // --- init for various image slider
    // -------------------------------------

    var imageSlider = $('.image-slider');
    var imageSliderContainer = '';
    var imageSliderId = '';
    var imageSliderLoop = false;
    var imageSliderNav = false;
    var imageSliderNavPosition = "bottom";
    var imageSliderCounter = null;
    var imageSliderSpeed = 300;
    var imageSliderAutoplay = false;
    var imageSliderAutoplayTimeout = 5000;
    var imageSliderControlsContainer = '.slider-controls';

    if ( imageSlider.length > 0 ) {
        imageSlider.each(function(element, index) {
            imageSliderId = $(this).attr('id');

            // -- slider container is REQUIRED
            imageSliderContainer = $(this).data('slider-container');
            imageSliderContainer = '#' + imageSliderId + ' ' + imageSliderContainer;

            // -- check if counter
            if ( typeof $(this).data('counter') !== 'undefined' && $(this).data('counter') !== '' ) {
                imageSliderCounter = $(this).data('counter');
            }

            // -- check if speed is set
            if ( typeof $(this).data('speed') !== 'undefined' && $(this).data('speed') !== '' ) {
                imageSliderSpeed = parseInt($(this).data('speed'));
            }

            // -- check if nav is set
            if ( typeof $(this).data('nav') !== 'undefined' ) {
                imageSliderNav = $(this).data('nav');
            }

            // -- check if nav-position is set
            if ( typeof $(this).data('nav-position') !== 'undefined' && $(this).data('nav-position') !== '' ) {
                imageSliderNavPosition = $(this).data('nav-position');
            }

            // -- check if loop is set
            if ( typeof $(this).data('loop') !== 'undefined' && $(this).data('loop') !== '' ) {
                imageSliderLoop = $(this).data('loop');
            }

            // -- check if autoplay is set
            if ( typeof $(this).data('autoplay') !== 'undefined' ) {
                imageSliderAutoplay = $(this).data('autoplay');
            }

            // -- check if autoplayTimeout is set
            if ( typeof $(this).data('autoplay-timeout') !== 'undefined' && $(this).data('autoplay-timeout') !== '' ) {
                imageSliderAutoplayTimeout = parseInt($(this).data('autoplay-timeout'));
            }

            // -- check if controls-container is set
            if ( typeof $(this).data('controls-container') !== 'undefined' && $(this).data('controls-container') !== '' ) {
                imageSliderControlsContainer = $(this).data('controls-container');
            }

            // -- reset controls container by id
            imageSliderControlsContainer = '#' + imageSliderId + ' ' + imageSliderControlsContainer;

            window[imageSliderId] = tns({
                container: imageSliderContainer,
                nav: imageSliderNav,
                navPosition: imageSliderNavPosition,
                mouseDrag: true,
                disable: false,
                gutter: 0,
                items: 1,
                loop: imageSliderLoop,
                slideBy: 1,
                controls: true,
                controlsContainer: imageSliderControlsContainer,

            });

            // -- setup counter
            if ( imageSliderCounter !== null && imageSliderCounter !== '' ) {
                imageSliderCounter = '#' + imageSliderId + ' ' + imageSliderCounter;

                if ( $(imageSliderCounter).length > 0 ) {

                    window[imageSliderId].events.on('indexChanged', function( info, eventName ) {
                        $(imageSliderCounter).text(info.displayIndex);
                    });
                }
            }
        });
    }

    // --------------------------------
    // --- Detail Image Slider
    // --------------------------------
    // if ($('.image-slider').length > 0) {
    //     var slider = tns({
    //         container: '.image-slider',
    //         items: 1,
    //         mouseDrag: true,
    //         navContainer: '.image-slider',
    //         navAsThumbnails: true,
    //         edgePadding: 15,
    //         responsive: {
    //             992: {
    //                 disable: true
    //             }
    //         },
    //         controlsText: ['<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#06f" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
    //             '  <path stroke="none" d="M0 0h24v24H0z"/>\n' +
    //             '  <polyline points="15 6 9 12 15 18" />\n' +
    //             '</svg>', '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#06f" fill="none" stroke-linecap="round" stroke-linejoin="round">\n' +
    //             '  <path stroke="none" d="M0 0h24v24H0z"/>\n' +
    //             '  <polyline points="9 6 15 12 9 18" />\n' +
    //             '</svg>'
    //         ]
    //     })
    // }

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

    // ------------------------------------------------
    // -- Teaser block modal
    // ------------------------------------------------
    let teaserBlock = $('.teaser-block-preview');
    let teaserBlockToggle = $('.teaser-block-toggle');
    let teaserBlockNotToggleableClass = 'not-toggleable';
    let teaserBlockModalClose = $('.teaser-block-modal-close');

    function teaserBlockHandler() {
        var storeInnerHeight, storeThisHeight = null;

        teaserBlock.each(function(e) {
            storeInnerHeight = $(this).find('.teaser-block-preview--inner').height();
            storeThisHeight = $(this).height();

            // -- set initiator class
            if ( storeInnerHeight > storeThisHeight ) {
                if ( !$(this).hasClass(teaserBlockNotToggleableClass) ) {
                    $(this).removeClass(teaserBlockNotToggleableClass);
                }
            } else {
                if ( $(this).hasClass(teaserBlockNotToggleableClass) ) {
                    $(this).addClass(teaserBlockNotToggleableClass);
                }
            }
        })
    }

    // -- close modal
    teaserBlockModalClose.on('click', function(e) {
        e.preventDefault();

        $(this).parents('.show').removeClass('show');
        
        e.stopPropagation();
    });

    // -- open modal
    teaserBlockToggle.on('click', function(e) {
        e.preventDefault();

        var thisButton = $(this);
        var thisID = thisButton.data('id');

        $('#teaser-modal--' + thisID ).addClass('show');

        e.stopPropagation();
    });

    teaserBlockHandler();

    var resizeInitiator;

    window.onresize = function() {
        clearTimeout(resizeInitiator);
        resizeInitiator = setTimeout(teaserBlockHandler, 100);
    }


    // ------------------------------------------------
    // -- Accordion
    // ------------------------------------------------

    let accToggle = $('.accordion-toggle');
    let accOpenClass = 'is-open';
    let accToggleAll = $('button.accordion-toggle-all');

    if ( accToggle.length > 0 ) {

        accToggleAll.on('click', function(e) {

            var thisAccGroup = $(this).parents('.accordion-group');
            var thisAction = $(this).data('toggle');

            if ( thisAction === 'open' ) {
                // open all
                thisAccGroup.find('.accordion-item:not(.is-open) .accordion-toggle').trigger('click');
                $(this).data('toggle', 'close');
                $(this).attr('data-toggle', 'close');
            } else {
                // close all
                thisAccGroup.find('.accordion-item.is-open .accordion-toggle').trigger('click');
                $(this).data('toggle', 'open');
                $(this).attr('data-toggle', 'open');
            }

            e.stopPropagation();
        })

        accToggle.on('click', function(e) {
            e.preventDefault();

            // -- get inner height
            var accContentHeight = $(this).parent().find('.accordion-content--inner').outerHeight();
            var accContent = $(this).parent().find('.accordion-content');
            var accWrapper = $(this).parent();

            if ( $(this).parent().hasClass(accOpenClass) ) {
                accContent.removeAttr('style');
                accContent.css({'height': accContentHeight + 'px'});

                // animate
                accContent.animate({
                    'height': '0px',
                }, 300, function(){
                    accWrapper.removeClass(accOpenClass);
                });
            } else {
                accContent.css({'height': '0px'});

                // animate
                accContent.animate({
                    'height': accContentHeight + 'px',
                }, 300, function(){
                    accWrapper.addClass(accOpenClass);
                });
            }

            e.stopPropagation();
        });
    }


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
            controlsContainer: '.detail-gallery-overlay .slider-controls'
        })
    }

    if ( $('.detail-header-gallery-grid--modal').length > 0) {
        function addGalleryClasses() {
            console.log('open');
            $('.detail-gallery-overlay').addClass('open');
            $('body').addClass('modal-open');
        }

        function removeGalleryClasses() {
            console.log('close');
            $('.detail-gallery-overlay').removeClass('open');
            $('body').removeClass('modal-open');
        }
        $('.detail-header-gallery-grid--modal').on('click', function () {
            addGalleryClasses();
        })
        $('.detail-gallery-overlay-close').on('click', function () {
            removeGalleryClasses();
        })
        $('.detail-header-gallery-grid--modal').on('click', function () {
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
    // --- Booking Calendar Hover
    // -----------------------
    if($('.travel-date').length) {
        $('.travel-date a').on('mouseover', function(e) {
            let duration = $(e.target).attr('data-duration');
            let counter = 1;
            $(e.target).parent().nextAll().each((index, item) => {
                if((index + 1) < duration) {
                    if($(item).text().trim().length) {
                        $(item).addClass('active');
                        counter++;
                    } else {
                        let looped = false;
                        if(!looped) {
                            $(item).parent().parent().next().find('.calendar li').each((index2, item2) => {
                                if($(item2).text().trim().length && !$(item2).hasClass('weekday') && counter < duration) {
                                    $(item2).addClass('active');
                                    counter++;
                                }
                                looped = true;
                            });
                        }
                    }
                }
            });
        });
        $('.travel-date a').on('mouseout', function(e) {
            $('.calendar li').removeClass('active');
        });
    }

    // -----------------------
    // --- FAQ Schema Accordion
    // -----------------------
    if($('.content-block-schema-accordion').length) {
        $('.accordion-item').each((ind, item) => {
            $(item).on('click', '.accordion-question', (e) => {
                $(item).hasClass('active') ? '' : $('.accordion-item').removeClass('active');
                $(item).toggleClass('active');
            });
        });
    }

    // -----------------------
    // -- click handling various dropdowns
    // -----------------------
    let dropdownNotClose = '.dropdown-menu-wishlist, .dropdown-menu-booking-select, .dropdown-menu-booking-person-select';

    $(dropdownNotClose).find('button[data-type="close-popup"]').on('click', function(e) {
        e.preventDefault();

        $(this).parents('.dropdown-menu.show').removeClass('show');

        e.stopPropagation();
    });

    $(dropdownNotClose).on('click', function(e) {

        // -- little hook
        // -- backdrop checker
        if ( $(e.target).css('container-name') === 'backdrop' ) {
            $(e.target).removeClass('show');
            $(e.target).parent().find('button[data-type="close-popup"]').trigger('click');
        }

        // -- hook for filter prompt
        if ( $(e.target).hasClass('filter-prompt') || $(e.target).parents('.filter-prompt').length > 0 ) {
            $(e.target).parents('.dropdown').find('.dropdown-menu').removeClass('show');
        }

        // -- make select happen on klick .form-radio or inner elements of .form-radio
        if ( $(e.target).hasClass('form-radio') || $(e.target).parents('.form-radio').length > 0 ) {
            var element = null;
            var elementText = '';

            if ( $(e.target).hasClass('form-radio') ) {
                element = $(e.target);
            } else {
                element = $(e.target).parents('.form-radio');
            }

            elementText = element.find('label').text();

            $(e.target).parents('.dropdown').find('.selected-options').text(elementText);
        }

        e.stopPropagation();
    });

    // -- personen select
    function personenCounter() {
        var pCounter = $('.personen-select-counter');
        var pCounterButton = '.personen-select-counter-btn';
        var pCounterInput = pCounter.find('.personen-select-counter-input');
        var pCounterValue = pCounterInput.val();
        var pCounterMin = pCounterInput.data('min');
        var pCounterMax = pCounterInput.data('max');
        var pCounterTarget = pCounterInput.data('target-input');
        var pCounterValueNew = 0;

        if ( pCounterMin === '' ) {
            pCounterMin = '1';
        }

        if ( parseInt(pCounterValue) >= parseInt(pCounterMin) ) {
            pCounter.find(pCounterButton + '[data-type="-"]').prop('disabled', true);
        } else {
            pCounter.find(pCounterButton + '[data-type="-"]').prop('disabled', false);
        }

        if ( pCounterMax !== '' ) {
            if ( parseInt(pCounterValue) === parseInt(pCounterMax) ) {
                pCounter.find(pCounterButton + '[data-type="+"]').prop('disabled', true);
            } else {
                pCounter.find(pCounterButton + '[data-type="+"]').prop('disabled', false);
            }
        }

        // -- +/- click
        pCounter.find(pCounterButton).on('click', function() {

            var thisButtonType = $(this).data('type');
            var setValue = true;
            // refresh value
            pCounterValue = pCounterInput.val();

            if ( thisButtonType === '-' ) { // -
                pCounterValueNew = parseInt(pCounterValue) - 1;
            } else { // +
                pCounterValueNew = parseInt(pCounterValue) + 1;
            }

            if ( parseInt(pCounterValueNew) > parseInt(pCounterMin) ) {
                pCounter.find(pCounterButton + '[data-type="-"]').prop('disabled', false);
            } else {
                pCounter.find(pCounterButton + '[data-type="-"]').prop('disabled', true);
            }

            if ( pCounterMax !== '' ) {
                if ( parseInt(pCounterValueNew) === parseInt(pCounterMax) ) {
                    pCounter.find(pCounterButton + '[data-type="+"]').prop('disabled', true);
                } else {
                    pCounter.find(pCounterButton + '[data-type="+"]').prop('disabled', false);
                }
            }

            if ( parseInt(pCounterValueNew) >= 1 ) {
                setValue = true;
            }

            if ( pCounterMax !== '' ) {
                setValue = false;

                if ( parseInt(pCounterValueNew) <= parseInt(pCounterMax) ) {
                    setValue = true;
                }
            }

            if ( setValue ) {
                if ( pCounterValueNew > 1 ) {
                    $(pCounterTarget).text(pCounterValueNew + ' ' + pCounterInput.data('plural'));
                } else {
                    $(pCounterTarget).text(pCounterValueNew + ' ' + pCounterInput.data('singular'));
                }
                pCounterInput.val(pCounterValueNew);
            }

        });
    }

    if ( $('.personen-select-counter').length > 0 ) {
        personenCounter();
    }
    
    // -----------------------
    // -- click handling document
    // -----------------------
    $(document).click(function(event) {
        var $target = $(event.target);

        // -- backdrop checker
        if ( $target.css('container-name') === 'backdrop' ) {

            $target.parent().find('button[data-type="close-popup"]').trigger('click');

            // -- trigger click on data-type="popup-close", to hide item by klick on close button..
            // -- @todo: best way?
        }
    });
});