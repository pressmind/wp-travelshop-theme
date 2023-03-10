jQuery(function ($) {
    let bookingEntry = $('.detail-booking-entrypoint');

    // -- check if booking entry is loaded, otherwise script not needed

    if ( bookingEntry.length > 0 ) {
        // -- transport type / airport behaviour
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

        // -- on click calendar
        let bookingEntryClendar = $('.booking-filter-field--date-range');

        bookingEntryCalendar.on('click touch', function(e) {
            e.preventDefault();

            console.log('clicked booking-calendar');

            e.stopPropagation();
        })
    }
});