jQuery(function ($) {
    let openClass = 'is-open';

    /**
     * Daterange picker
     */
    let datePickerWrapper = '.travelshop-datepicker';
    let datePickerTrigger = '.travelshop-datepicker-input';
    let datePickerCalendarWrapper = '#daterange-calendar';
    let datePickerCalendarOverlay = '.daterange-overlay';
    let datePickerCalendarBackdrop = '.daterange-overlay-backdrop';
    let datePickerCalendarDayItem = '.day-item-interactive';
    let datePickerRangeActiveClassName = 'day-item-active';
    let datePickerRangeStartClassName = 'day-item-start';
    let datePickerCurrentClassName = 'day-item-current';
    let datePickerRangeBetweenClassName = 'day-item-between';
    let datePickerRangeEndClassName = 'day-item-end';
    let datePickerOverlayClose = '.daterange-overlay-close';
    let datePickerOverlayPrompt = '.daterange-overlay-prompt';
    let datePickerServiceUrl = '/wp-content/themes/travelshop/pm-ajax-endpoint.php?action=dateRangePicker';
    let calendarSlider;
    let calendarSliderIndex = 0;
    let calendarSliderIndexTemp = null;
    let calendarSelectorIndex = 0;
    let calendarStoreLastSelected = 0;
    let selectedDateStartStr = null;
    let selectedDateStartNumeric = null;
    let selectedDateEndStr = null;
    let selectedDateEndNumeric = null;
    let datePickerCalendarInput = '.travelshop-datepicker-input-hidden';
    let datePickerButtonString = '.selected-options-date';
    let datePickerResetButton = '.daterange-overlay-reset';
    let datePickerClear = '.datepicker-clear';
    let datePickerRenderDelay = 0;

    function datePickerInit() {

        if ( $(document).find(datePickerCalendarWrapper).hasClass('initialized') ) {
            return;
        }

        if ( $(document).find(datePickerCalendarWrapper).length > 0 ) {

            $(document).find(datePickerCalendarWrapper).addClass('initialized');

            $(document).find(datePickerTrigger).on('click touch', function(e) {
                e.preventDefault();

                datePickerOpen($(this));

                // Render Calendar
                datePickerRender($(this), $(document).find(datePickerCalendarWrapper));

                e.stopPropagation();
            });

            $(document).find(datePickerOverlayClose).on('click touch', function(e) {
                e.preventDefault();

                datePickerClose($(this));

                e.stopPropagation();
            });

            $(document).find(datePickerCalendarBackdrop).on('click touch', function(e) {
                e.preventDefault();

                datePickerClose($(this));

                e.stopPropagation();
            });

            $(document).find(datePickerOverlayPrompt).on('click touch', function(e) {
                e.preventDefault();

                datePickerClose($(this));

                submitFilter();

                e.stopPropagation();
            });

            $(document).find(datePickerClear).on('click touch', function(e) {
                e.preventDefault();

                datePickerReset();

                e.stopPropagation();
            });

            $(document).find(datePickerResetButton).on('click touch', function(e) {
                e.preventDefault();

                datePickerReset();

                e.stopPropagation();
            });
        }
    }

    function datePickerReset() {
        $(document).find(datePickerTrigger).attr('data-value', '');
        $(document).find(datePickerCalendarInput).attr('data-value', '');
        $(document).find(datePickerCalendarInput).attr('value', '');
        $(document).find(datePickerButtonString).text($(document).find(datePickerButtonString).data('default'));
        $(document).find(datePickerClear).hide();

        $(document).find('.duration-range-wrapper .form-check-input--reset').trigger('click');
        $(document).find(datePickerCalendarInput).trigger('change');

        // reset classes inner datepicker
        $(document).find('.' + datePickerRangeBetweenClassName).removeClass(datePickerRangeBetweenClassName);
        $(document).find('.' + datePickerRangeStartClassName).removeClass(datePickerRangeStartClassName);
        $(document).find('.' + datePickerRangeEndClassName).removeClass(datePickerRangeEndClassName);
        $(document).find('.' + datePickerRangeActiveClassName).removeClass(datePickerRangeActiveClassName);
        $(document).find('.' + datePickerCurrentClassName).addClass(datePickerRangeActiveClassName);

        if ( $(document).find('.daterange-calendar-items-inner').hasClass('tns-slider') ) {
            calendarSlider.goTo(0);
        }
    }

    function datePickerRender(_this, renderTarget) {
        var thisDatePickerTrigger = _this;
        var thisDatePickerWrapper = thisDatePickerTrigger.closest(datePickerWrapper);
        var thisDatePickerTarget = renderTarget;

        // -- collect data
        var calendarReqeust = {
            'value': thisDatePickerTrigger.data('value'),
            'departures': thisDatePickerTrigger.data('departures'),
            'minDate': thisDatePickerTrigger.data('mindate'),
            'maxDate': thisDatePickerTrigger.data('maxdate'),
            'minYear': thisDatePickerTrigger.data('minyear'),
            'maxYear': thisDatePickerTrigger.data('maxyear')
        };

        // -- ajax
        if ( !renderTarget.hasClass('calendar-rendered') ) {
            $.ajax({
                url: datePickerServiceUrl,
                data: calendarReqeust,
                type: 'POST',
                dataType: 'html',
                beforeSend: function(xhr) {
                    renderTarget.addClass('is-loading');
                },
                success: function(data) {
                    setTimeout(function() {
                        renderTarget.html(data);
                        renderTarget.removeClass('is-loading');
                        renderTarget.addClass('calendar-rendered');

                        CalendarSliderInit();
                        datePickerFunctionality();
                    }, datePickerRenderDelay);

                }
            });
        }
    }

    function CalendarSliderInit() {
        var sliderWrapper = '.daterange-calendar-items';
        var sliderContainer = sliderWrapper + ' .daterange-calendar-items-inner';
        var sliderItems = '.calendar-item';

        if ( $('body').find(sliderWrapper + ' ' + sliderItems).length > 2 ) {

            calendarSlider = tns({
                container: sliderContainer,
                items: 2,
                slideBy: 1,
                nav: false,
                mouseDrag: true,
                loop: false,
                gutter: 24,
                disable: true,
                startIndex: calendarSliderIndex,
                responsive: {
                    992: {
                        disable: false,
                        items: 2,
                        slideBy: 1,
                    }
                },
                controls: true,
                controlsContainer: sliderWrapper + ' .slider-controls'
            });

            calendarSlider.events.on('indexChanged', function(){
                calendarSliderIndexTemp = calendarSlider.getInfo().index;

                if ( calendarSliderIndexTemp !== calendarSliderIndex ) {
                    calendarSliderIndex = calendarSliderIndexTemp;
                }

                if ( calendarSliderIndex !== calendarSliderIndexTemp && calendarSliderIndexTemp !== null ) {
                    calendarSliderIndex = calendarSliderIndexTemp;
                }
            })
        }
    }

    function datePickerFunctionality() {
        var thisDayItem = $(document).find(datePickerCalendarDayItem);

        thisDayItem.on('click touch', function(e) {

            var _thisItem = $(this);
            var _thisItemValue = $(this).data('date-numeric');

            if ( calendarSelectorIndex === 0 ) {
                thisDayItem.removeClass(datePickerRangeActiveClassName);
                thisDayItem.removeClass(datePickerRangeEndClassName);
                thisDayItem.removeClass(datePickerRangeStartClassName);
                thisDayItem.removeClass(datePickerRangeBetweenClassName);

                _thisItem.addClass(datePickerRangeActiveClassName);
                _thisItem.addClass(datePickerRangeStartClassName);

                selectedDateStartStr = _thisItem.data('date');
                selectedDateStartNumeric = _thisItem.data('date-numeric');

                selectedDateEndStr = null;
                selectedDateEndNumeric = null;

                calendarStoreLastSelected = _thisItemValue;

                calendarSelectorIndex++;
            } else if ( calendarSelectorIndex === 1 ) {

                if ( calendarStoreLastSelected <= _thisItemValue ) {
                    _thisItem.addClass(datePickerRangeActiveClassName);
                    _thisItem.addClass(datePickerRangeEndClassName);

                    calendarStoreLastSelected = _thisItemValue;

                    selectedDateEndStr = _thisItem.data('date');
                    selectedDateEndNumeric = _thisItem.data('date-numeric');

                    calendarSelectorIndex = 0;
                } else {
                    thisDayItem.removeClass(datePickerRangeActiveClassName);
                    thisDayItem.removeClass(datePickerRangeEndClassName);
                    thisDayItem.removeClass(datePickerRangeStartClassName);
                    thisDayItem.removeClass(datePickerRangeBetweenClassName);

                    _thisItem.addClass(datePickerRangeActiveClassName);
                    _thisItem.addClass(datePickerRangeStartClassName);

                    selectedDateStartStr = _thisItem.data('date');
                    selectedDateStartNumeric = _thisItem.data('date-numeric');

                    selectedDateEndStr = null;
                    selectedDateEndNumeric = null;

                    calendarStoreLastSelected = _thisItemValue;

                    calendarSelectorIndex = 1;
                }
            }


            if ( selectedDateStartNumeric !== null && selectedDateEndNumeric !== null ) {
                thisDayItem.filter(function() {
                    if (
                        parseInt($(this).data('date-numeric')) >= selectedDateStartNumeric &&
                        parseInt($(this).data('date-numeric')) <= selectedDateEndNumeric
                    ) {
                        return $(this);
                    }
                }).addClass(datePickerRangeBetweenClassName);

                // set value
                $(document).find(datePickerTrigger).attr('data-value', selectedDateStartNumeric + '-' + selectedDateEndNumeric);
                $(document).find(datePickerCalendarInput).attr('data-value', selectedDateStartNumeric + '-' + selectedDateEndNumeric);

                // readable duration range
                var thisStartDateObj = selectedDateStartStr.split('-');
                var thisEndDateObj = selectedDateEndStr.split('-');
                var thisDurationString = '';

                if ( thisEndDateObj[0] === thisStartDateObj[0] ) {
                    thisDurationString += thisStartDateObj[2] + '.' + thisStartDateObj[1] + '.';
                } else {
                    thisDurationString += thisStartDateObj[2] + '.' + thisStartDateObj[1] + '.' + thisStartDateObj[0];
                }

                thisDurationString += ' - ' + thisEndDateObj[2] + '.' + thisEndDateObj[1] + '.' + thisEndDateObj[0];

                $(document).find(datePickerCalendarInput).attr('value', thisDurationString);
                $(document).find(datePickerButtonString).text(thisDurationString);

                $(document).find(datePickerClear).show();

            } else {
                $(document).find(datePickerTrigger).attr('data-value', '');
                $(document).find(datePickerCalendarInput).attr('data-value', '');
                $(document).find(datePickerCalendarInput).attr('value', '');
                $(document).find(datePickerButtonString).text($(document).find(datePickerButtonString).data('default'));
                $(document).find(datePickerClear).hide();
            }

            $(document).find(datePickerCalendarInput).trigger('change');

        });
    }

    function datePickerOpen(_this) {
        var thisDatePickerTrigger = _this;
        var thisDatePickerWrapper = thisDatePickerTrigger.closest(datePickerWrapper);

        thisDatePickerWrapper.addClass(openClass);
        thisDatePickerWrapper.find(datePickerCalendarOverlay).addClass(openClass);
        thisDatePickerWrapper.find(datePickerCalendarBackdrop).addClass(openClass);
    }

    function datePickerClose(_this) {
        var thisDatePickerTrigger = _this;
        var thisDatePickerWrapper = thisDatePickerTrigger.closest(datePickerWrapper);

        thisDatePickerWrapper.removeClass(openClass);
        thisDatePickerWrapper.find(datePickerCalendarOverlay).removeClass(openClass);
        thisDatePickerWrapper.find(datePickerCalendarBackdrop).removeClass(openClass);
    }

    datePickerInit();

    /**
     * Search Dauer
     */
    function searchDauerSelectFunction() {

        let searchDauer = $('body').find('.duration-range-wrapper');
        let searchDauerSelect = $('body').find('.form-control-select-dauer');
        let searchDauerButton = $('body').find('button.travelshop-datepicker-input');

        if ( searchDauer.hasClass('initialized') ) {
            return;
        }

        searchDauer.addClass('initialized');

        if ( searchDauer.length > 0 ) {
            var searchInput = searchDauer.find('input');
            var searchLabel = searchDauer.find('label');
            var searchCheck = searchDauer.find('.form-check');
            var searchPlaceholder = searchDauerButton.parents('.search-box-field').find('.selected-options-duration');

            searchInput.unbind();
            searchLabel.unbind();
            searchCheck.unbind();

            searchCheck.on('click', function(e){
                e.preventDefault();

                // -- reset value
                searchDauer.find('input').prop('checked', false);

                // -- set checked
                $(this).find('input').prop('checked', true);

                // -- get value
                var thisValue = $(this).find('input').attr('id');

                if ( thisValue === 'reset' ) {
                    searchDauerSelect.find('option[value=""]').prop('selected', true);

                    $(document).find(datePickerClear).hide();
                } else {
                    thisValue = thisValue.replace('duration-', '');
                    searchDauerSelect.find('option[value="'+thisValue+'"]').prop('selected', true);
                    $(document).find(datePickerClear).show();
                }

                // -- trigger change
                searchDauerSelect.trigger('change');

                // -- set value in dropdown
                searchPlaceholder.text($(this).find('label').text().trim());

                e.stopPropagation();
            });
        }
    }

    searchDauerSelectFunction();

});