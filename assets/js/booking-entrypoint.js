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


        bookingEntryCalendar.on('click touch', function(e) {
            e.preventDefault();

            // -- define some variables needed later
            var getTransportType, getAirport, getDur, getOffer, getMediaObject = null;

            // -- collect data
            getTransportType = $('.booking-filter-radio--transport-type input[type="radio"]:checked').val();
            getDur = $('.booking-filter-field--duration').val();
            getOffer = $('.booking-filter-field--offer').val();
            getMediaObject = $('.booking-filter-field--mediaobject').val();

            // -- check transporttype for flight, if yes set airport
            if ( getTransportType === 'FLUG' ) {
                getAirport = bookingEntryAirportField.find('input[type="radio"]:checked').val();
            }

            renderBookingCalendar(getTransportType, getAirport, getDur, getOffer, getMediaObject);

            e.stopPropagation();
        });

        function renderBookingCalendar(transportType, airport, duration, offer, mediaobject) {

            // -- request array
            var calendarRequest = {
                'action': 'detail-booking-calendar',
                'transport_type': transportType,
                'airport': airport,
                'duration': duration,
                'offer': offer,
                'media_object_id': mediaobject
            };
            console.log('Render calendar with values:');
            console.log(calendarRequest);
        }
    }
});