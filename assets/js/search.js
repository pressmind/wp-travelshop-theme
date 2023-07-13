jQuery(function ($) {

// -----------------------------------------------
// --- Filter
// -----------------------------------------------

    // Filter toggle second level filter (open second level tree item)
    $('#search-filter').on('click', '.toggle-second-level', function (e) {
        $(this).parent().toggleClass('is-open');
    });


    // Filter toggle
    $('.list-filter-close').on('click', function (e) {
        e.preventDefault();
        $('.content-block-list-filter').removeClass('is-open');
    });

    $('#search-result').on('click', '.list-filter-open', function (e) {
        e.preventDefault();
        $('.content-block-list-filter').addClass('is-open');
    });

    // -- make filter span-checkboxes clickable
    function addFilterCheckboxEventListener() {
        $('#search-filter').on('click','#filter .form-check>span', function (e) {
            if ($(e.target).siblings('input').is(':disabled')) {
                return;
            }
            if ($(e.target).siblings('input').is(':checked')) {
                $(e.target).siblings('input').prop('checked', false).trigger('change');
            } else {
                $(e.target).siblings('input').prop('checked', true).trigger('change');
            }
        });
    }

    addFilterCheckboxEventListener();


// -- offcanvas
    var $offcanvasToggle = $('.offcanvas-toggler'),
        $offcanvasBackdrop = $('#offanvas-backdrop'),
        $offcanvasClose = $('.offcanvas-close');

    $offcanvasToggle.unbind('click');

    $offcanvasToggle.on('click', function (e) {
        e.preventDefault();

        // -- trigger modal.
        $offcanvasBackdrop.modal('show');

        var $target = $($(this).data('target'));

        $target.addClass('is-open');

        e.stopPropagation();
    });

    $offcanvasBackdrop.unbind('click');

    $offcanvasBackdrop.on('click', function (e) {
        e.preventDefault();

        $offcanvasBackdrop.modal('hide');

        e.stopPropagation();
    });


    $offcanvasClose.on('click', function () {
        $offcanvasBackdrop.modal('hide');

    });

    $offcanvasBackdrop.on('hide.bs.modal', function (e) {
        // -- reset class from offcanvas
        $('.offcanvas.is-open').removeClass('is-open');
    });

// ------------------------------------------
// --- Search toggle
// ------------------------------------------
    if ($('#search').length > 0) {
        var $searchToggle = $('.search-toggler'),
            $searchWrapper = $('.header-main .col-search'),
            $searchBackdrop = $('#search-backdrop');

        $searchToggle.on('click', function (e) {
            $searchBackdrop.modal('show');
            $searchWrapper.addClass('is-open');

            e.stopPropagation();
        });

        $searchBackdrop.unbind('click');

        $searchBackdrop.on('click', function (e) {
            e.preventDefault();
            $searchBackdrop.modal('hide');
            e.stopPropagation();
        });

        $searchBackdrop.on('hide.bs.modal', function (e) {
            $searchWrapper.removeClass('is-open');
        });

        $searchBackdrop.on('show.bs.modal', function (e) {
            $searchWrapper.addClass('is-open');
        });
    }

    // ------------------------------------------
    // --- rangeslider
    // ------------------------------------------

    if (false && $('.js-range-slider').length > 0) {
        var rSliderElement = new rSlider({
            target: '#js-range-slider',
            values: { min: parseInt($(".js-range-slider").attr('data-min')), max: parseInt($(".js-range-slider").attr('data-max'))},
            step: parseInt($(".js-range-slider").attr('data-step')),
            set: [parseInt($(".js-range-slider").attr('data-val-from')), parseInt($(".js-range-slider").attr('data-val-to'))],
            range: true,
            tooltip: true,
            scale: false,
            labels: false,
            disabled: $(".js-range-slider").attr('data-disable') == 'true'
        });
    }






});