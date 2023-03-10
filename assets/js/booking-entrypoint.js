jQuery(function ($) {

    let bookingEntryTransportType = $('.booking-filter-radio--transport-type input[type="radio"]');
    let bookingEntryAirport = $('.booking-filter-item--airport');

    // -- switch travel-type
    bookingEntryTransportType.on('change', function(e) {

        var thisType = $(this).val();

        if ( thisType == 'FLUG' ) {
            bookingEntryAirport.removeClass('d-none');
        } else {
            bookingEntryAirport.addClass('d-none');
        }

    });

});