jQuery(function ($) {
    let bookingEntry = $('.detail-booking-entrypoint');

    // -- check if booking entry is loaded, otherwise script not needed

    if ( bookingEntry.length > 0 ) {
        // -- transport type / airport behaviour
        let bookingEntryTransportType = $('.booking-filter-radio--transport-type input[type="radio"]');
        let bookingEntryAirportField = $('.booking-filter-item--airport');

        // -- switch travel-type
        bookingEntryTransportType.on('change', function(e) {
            var thisType = $(this).val();

            if ( thisType == 'FLUG' ) {
                bookingEntryAirportField.removeClass('d-none');
            } else {
                bookingEntryAirportField.addClass('d-none');
            }
        });

        // -- on click calendar
        let bookingEntryCalendar = $('.booking-filter-field--date-range');

        // -- define some variables needed later
        var getTransportType, getAirport = null;

        bookingEntryCalendar.on('click touch', function(e) {
            e.preventDefault();

            // -- collect data
            getTransportType = $('.booking-filter-radio--transport-type input[type="radio"]:checked').val();

            console.log(getTransportType);

            e.stopPropagation();
        })
    }
});