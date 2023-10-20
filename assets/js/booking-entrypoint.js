jQuery(function ($) {

    TSBookingEntrypoint = function(CheapestPrice){
        this.id_media_object = CheapestPrice.id_media_object;
        this.id_date = CheapestPrice.id_date;
        this.id_booking_package = CheapestPrice.id_booking_package;
        this.transport_type = CheapestPrice.transport_type;
        this.airport = CheapestPrice.airport;
        this.duration = CheapestPrice.duration;
        this.id_offer = CheapestPrice.id;
        this.id_housing_package = CheapestPrice.id_housing_package;
        this.date_departure = dayjs(CHEAPEST_PRICE.date_departure.date).format('YYYY-MM-DD');
        this.persons = $('.booking-filter-item--persons input[type="text"]').val();
        this.sliderIndex = 0;
        this.calendarTemplate = null;

        this.init = function(){
            let bookingEntry = $('.detail-booking-entrypoint');
            if (bookingEntry.length === 0) {
                return;
            }

            this.initTransportTypeField();
            this.initDurationTypeField();
            this.initAirportField();
            this.initPersonsField();

            if(bookingEntry.find('.booking-filter-items').hasClass('active')) {
                this.calendarTemplate = 'list';
                this.initDateList();
            }else{
                this.calendarTemplate = 'calendar';
                this.initCalendarField();
            }
            this.plausibilityFilter();
        }

        this.initTransportTypeField = function () {
            let bookingEntryTransportType = $('.booking-filter-radio--transport-type input[type="radio"]');
            var me = this;
            bookingEntryTransportType.on('change', function(e) {
                me.transport_type = $(this).val();
                me.handleAirportField();
                me.plausibilityFilter();
                me.getPriceCalendar(false);
            });
        }

        this.initDurationTypeField = function () {
            let bookingEntryDuration = $('.booking-filter-radio--duration input[type="radio"]');
            var me = this;
            bookingEntryDuration.on('change', function(e) {
                me.duration = parseInt($(this).val());
                me.plausibilityFilter();
                me.getPriceCalendar(false);
            });
        }

        this.handleAirportField = function (){
            if (this.transport_type === 'FLUG') {
                this.airport = $('.booking-filter-item--airport input[type="radio"]:checked').val();
                $('.booking-filter-item--airport').removeClass('d-none');
            }else{
                this.airport = null;
                $('.booking-filter-item--airport').addClass('d-none');
            }
        }

        this.initAirportField = function () {
            this.handleAirportField();
            var me = this;
            $('.booking-filter-item--airport input[type="radio"]').on('change', function(e) {
                me.airport = $(this).val();
                me.getPriceCalendar(false);
            });
        }

        this.initPersonsField = function () {
            var me = this;
            $('.booking-filter-item--persons input[type="text"]').on('change', function(e) {
                me.persons = $(this).val();
                me.getPriceCalendar(false);
            });

        }

        this.initCalendarField = function () {
            // click outside calendar => close
            $(document).click(function(event) {
                var target = $(event.target);
                if ($('.booking-filter-item--date-range').length > 0 && $('.booking-filter-item--date-range').hasClass('open')) {
                    if (!target.hasClass('booking-filter-item--date-range') && target.parents('.booking-filter-item--date-range').length < 1) {
                        // @TODO
                        console.log('close calendar');
                    }
                }
            });
            var me = this;
            $('.booking-filter-field--date-range').on('click touch', function(e) {
                e.preventDefault();
                me.getPriceCalendar(true);
                $('.dropdown, .dropdown-menu').removeClass('show');
                e.stopPropagation();
            });
        }

        this.getPriceCalendar = function (show_calendar) {
            $('#booking-entry-calendar').addClass('is-loading');
            let request = {
                'pm-tr': this.transport_type,
                'pm-ap': this.airport,
                'pm-du': this.duration,
                'persons' : this.persons,
                'id_media_object': this.id_media_object,
                'template': this.calendarTemplate
            };
            var me = this;
            $.ajax({
                url: '/wp-content/themes/travelshop/pm-ajax-endpoint.php?action=detail-booking-entrypoint-calendar',
                data: request,
                type: 'POST',
                dataType: "json",
                success: function(data) {
                    if(me.calendarTemplate === 'list') {
                        $('#booking-filter-item--dates').html(data.html);
                        let active_date_el = $('.booking-offer-item input[data-date_departure="' + me.date_departure + '"], .booking-offer-item input[data-id_date="' + me.id_date + '"]');
                        if(active_date_el.length > 0) {
                            $(active_date_el).parent().addClass('is-active');
                            me.id_date = parseInt($(active_date_el).data('id_date'));
                            $(active_date_el).prop('checked', true);
                            $(active_date_el).attr('checked', 'checked');
                            me.setPriceAndBookingBtn($(active_date_el).data('price_info'), $(active_date_el).data('booking_url'), $(active_date_el).data('id_offer'));
                            me.checkAvailability();
                        }else{
                            me.id_date = null;
                            me.date_departure = null;
                        }

                    }else{
                        $('#booking-entry-calendar').removeClass('is-loading');
                        $('#booking-entry-calendar').html(data.html);

                        me.calendarInteraction();
                        if(me.date_departure !== null) {
                            console.log('init with departure_date: ' + me.date_departure);
                            let active_date_el = $('.travel-date a[data-date_departure="' + me.date_departure + '"]');
                            if(active_date_el.length > 0) {
                                $(active_date_el).parent().addClass('active');
                                // jump to slide with active date
                                let id = parseInt($(active_date_el).closest('.tns-item').attr('id').replace('tns2-item', ''));
                                me.calendarSlider.goTo(id);
                                me.id_date = parseInt($(active_date_el).data('id_date'));
                                $('.booking-filter-item--date-range .booking-filter-field--text').html($(active_date_el).data('date-range'));
                                me.setPriceAndBookingBtn($(active_date_el).data('price_info'), $(active_date_el).data('booking_url'), $(active_date_el).data('id_offer'));
                                me.markTravelDateRange(active_date_el);
                                me.checkAvailability();
                            }else{
                                // @TODO
                                me.id_date = null;
                                me.date_departure = null;
                            }
                        }
                        if (show_calendar && !$('.booking-filter-item--date-range').hasClass('open') ) {
                            $('.booking-filter-item--date-range').addClass('open');
                        }
                    }

                }
            })
        }

        this.calendarInteraction = function() {
            if ( $('body').find('.booking-entrypoint-calendar-outer .calendar-item').length > 2 ) {
                this.calendarSlider = tns({
                    container: '.booking-entrypoint-calendar-outer .booking-entrypoint-calendar-inner',
                    items: 2,
                    slideBy: 1,
                    nav: false,
                    mouseDrag: true,
                    loop: false,
                    gutter: 30,
                    disable: true,
                    startIndex: this.sliderIndex,
                    responsive: {
                        768: {
                            disable: false
                        }
                    },
                    controls: true,
                    controlsContainer: '.booking-entrypoint-calendar-outer .slider-controls'
                });
            }

            let bookingEntryCalendarRenderTarget = $('#booking-entry-calendar');
            var travelDate = bookingEntryCalendarRenderTarget.find('.travel-date a');

            travelDate.on('mouseenter', (e) => {
                let me = this;
                if ( !$(this).parent().hasClass('active') ) {
                    me.markTravelDateRange(this);
                    $(this).bind('mouseout', function(e) {
                        if ( !$(this).parent().hasClass('active') ) {
                            me.unMarkTravelDateRange();
                        }
                    })
                }
            });
            travelDate.on('mouseout', function(e) {
                $(this).unbind('mouseout');
            });


            travelDate.on('click touch', (e) => {
                e.preventDefault();
                let me = this;
                me.unMarkTravelDateRange();
                me.id_date = parseInt($(this).data('id_date'));
                $('.booking-filter-item--date-range .booking-filter-field--text').html($(this).data('date-range'));
                me.setPriceAndBookingBtn($(this).data('price_info'), $(this).data('booking_url'), $(this).data('id_offer'));
                me.checkAvailability();
                bookingEntryCalendarRenderTarget.find('.travel-date.active').removeClass('active');
                me.markTravelDateRange(this);
                $(this).parent().addClass('active');
                if ( bookingEntryCalendarRenderTarget.find('.booking-entrypoint-calendar-inner').hasClass('tns-slider') ) {
                    me.sliderIndex = me.calendarSlider.getInfo().index;
                }
                e.stopPropagation();
            })
            $('.booking-calendar-close').on('click touch', function(e) {
                e.preventDefault();
                $(this).parents('.booking-filter-item--date-range').removeClass('open');
                e.stopPropagation();
            })
        }

        this.setPriceAndBookingBtn = function (price_info, booking_url, id_offer) {
            $('.booking-action').find('.price-box-discount').html(price_info);
            $('.booking-action').find('.booking-btn').attr('href', booking_url);
            $('.booking-action').find('.booking-btn').data('id-offer', id_offer);
        }

        this.markTravelDateRange = function(calendar_link_el) {
            $(calendar_link_el).parent().addClass('active-duration');
            var duration = parseInt($(calendar_link_el).data('duration'));
            var position = 0;
            $('#booking-entry-calendar').find('.calendar-item-day').not('.calendar-item-weekday').each(function() {
                if($(this).hasClass('active-duration') || position > 0) {
                    position++;
                }
                if (position > 0 && position !== duration) {
                    $(this).addClass('active-duration');
                }
                if (position === duration) {
                    $(this).addClass('active-duration active-duration-last');
                    return false;
                }
            });
        }

        this.unMarkTravelDateRange = function() {
            $('#booking-entry-calendar').find('.calendar-item-day').removeClass('active-duration active-duration-last');
        }

        this.plausibilityFilter = function() {
            var me = this;
            $('.booking-filter-radio--transport-type input[type="radio"]').each(function() {
                let filter = $(this).data('filter');
                if(filter.durations.indexOf(me.duration) === -1) {
                    console.log($(this).val() + ' is not valid for duration ' + me.duration);
                    $(this).parent().css('opacity', '0.5').addClass('disabled-by-filter');
                }else{
                    $(this).parent().css('opacity', '1').removeClass('disabled-by-filter');
                }
                // TODO
            });

            $('.booking-filter-radio--duration input[type="radio"]').each(function() {
                let filter = $(this).data('filter');
                if(filter.transport_types.indexOf(me.transport_type) === -1) {
                    console.log($(this).val() + ' is not valid for transport ' + me.transport_type);
                    $(this).parent().css('opacity', '0.5').addClass('disabled-by-filter');
                }else{
                    $(this).parent().css('opacity', '1').removeClass('disabled-by-filter');
                }
                // TODO
            });

            // TODO airport is not implemented yet

            this.unsetUnvalidFields();
        }

        this.unsetUnvalidFields = function() {
            $('.booking-filter-radio--duration .disabled-by-filter').find('input[type="radio"]:checked').each(function () {
                $(this).prop('checked', false);
                $('.booking-filter-radio--duration').not('.disabled-by-filter').find('input[type="radio"]:first').prop('checked', true).trigger('change');
            });
        }


        /**
          * @TODO
         */
        this.offerErrorHandling = function (state) {
            if (state === 'invalid') {
                // add error class
                $('.booking-filter-field--date-range').addClass('has-error');

                // change placeholder
                $('.booking-filter-field--date-range .booking-filter-field--text').text($('.booking-filter-field--date-range').data('placeholder'));

                // disable button
                $('.detail-booking-entrypoint .booking-btn').addClass('btn-disabled');
            } else {
                // remove error class
                $('.booking-filter-field--date-range').removeClass('has-error');

                // change back to valid date
                $('.booking-filter-field--date-range .booking-filter-field--text').text($('.booking-filter-field--daterange').val());

                // disable button
                $('.detail-booking-entrypoint .booking-btn').removeClass('btn-disabled');
            }
        }

        this.initDateList = function () {
            this.getPriceCalendar(false);
            if ( $('.booking-filter-item--dates .booking-offer-items').length > 0 && $('.booking-offer-item-label').length > 0 ) {
                var me = this;
                $('#booking-filter-item--dates').on('click touch', '.booking-offer-item-label', function(e) {
                    e.preventDefault();
                    let radioInput = $(this).find('input');
                    me.id_date = parseInt(radioInput.data('id_date'));
                    me.date_departure = radioInput.data('date_departure');
                    me.setPriceAndBookingBtn(radioInput.data('price_info'), radioInput.data('booking_url'), radioInput.data('id_offer'));
                    $('.booking-offer-items').find('.booking-offer-item-label').removeClass('is-active');
                    $('.booking-offer-items').find('input').prop('checked', false);
                    $('.booking-offer-items').find('input').removeAttr('checked');
                    $(this).addClass('is-active');
                    $(radioInput).prop('checked', true);
                    $(radioInput).attr('checked', 'checked');
                    me.checkAvailability();
                    e.stopPropagation();
                });

            }

        }

        this.checkAvailability = function (){
            $('.detail-booking-entrypoint .booking-btn').find('.loader').show();
            $('.detail-booking-entrypoint .booking-btn').find('svg').hide();
            $('.detail-booking-entrypoint .booking-btn').find('span').html('');
            $.ajax({
                url: ts_ajax_check_availibility_endpoint,
                type: 'POST',
                contentType: "application/json; charset=utf-8",
                data: JSON.stringify({'checks' : [{
                        'id_offer' : this.id_offer,
                        'quantity' : this.persons ? this.persons : 1,
                    }]}),
            }).done(function (response) {
                let data = response.data[0];
                $('.detail-booking-entrypoint .booking-btn').find('span').html(data.btn_msg);
                $('.detail-booking-entrypoint .booking-btn').attr('title', data.msg);
                $('.detail-booking-entrypoint .booking-btn').find('.loader').hide();
                $('.detail-booking-entrypoint .booking-btn').removeClass('green');
                $('.detail-booking-entrypoint .booking-btn').find('svg').show();
                $('.detail-booking-entrypoint .booking-btn').addClass(data.class);
                let href = new URL($('.detail-booking-entrypoint .booking-btn').attr('href'));
                href.searchParams.set('t', data.booking_type);
                $('.detail-booking-entrypoint .booking-btn').attr('href',  href.toString());
            });
        }

    };

    if($('.detail-booking-entrypoint').length > 0) {
        window.BookingEntrypoint = new TSBookingEntrypoint(CHEAPEST_PRICE);
        window.BookingEntrypoint.init();
    }
});
