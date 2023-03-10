jQuery(function ($) {

    let bookingEntryTransportType = $('.booking-filter-radio--transport-type input[radio]');
    let bookingEntryAirport = $('.booking-filter-item--airport');
    let bookingEntryAirportInput = bookingEntryAirport.find('input');

    // -- remove attribute checked by click airport
    bookingEntryAirportInput.on('click touch', function(e) {
        bookingEntryAirportInput.removeAttr('checked');
    });

    // -- switch travel-type
    bookingEntryTransportType.on('click touch', function(e) {

        var thisType = $(this).val();

        bookingEntryTransportType.removeAttr('checked');

        if ( thisType == 'FLUG' ) {
            bookingEntryAirport.removeClass('d-none');
        } else {
            bookingEntryAirport.addClass('d-none');
        }

    });

});