let source = require("../../../ts-functions");
let _this = source._this;
let $ = source.$;
const resultHandlerSearch = function (data, query_string, scrollto, total_result_span_id, $, _this) {

    _this.removeSpinner();

    for (let key in data.html) {
        if (key == 'search-result') {
            $('#' + key).html(data.html[key]).find('.content-block-travel-cols').fadeIn()
                .css({top:1000,position:'relative'})
                .animate({top:0}, 80, 'swing')
        }else{
            $('#' + key).html(data.html[key]);
        }

        if (key == 'search-filter') {
            new rSlider({
                target: '#js-range-slider',
                values: { min: parseInt($(".js-range-slider").attr('data-min')), max: parseInt($(".js-range-slider").attr('data-max'))},
                step: parseInt($(".js-range-slider").attr('data-step')),
                set: [parseInt($(".js-range-slider").attr('data-val-from')), parseInt($(".js-range-slider").attr('data-val-to'))],
                range: true,
                tooltip: true,
                scale: true,
                labels: false,
                disabled: $(".js-range-slider").attr('data-disable') == 'true'
            });
            let timeout;
            let timestamp = + new Date();
            if($(window).width() >= 768) {
                document.querySelector('#js-range-slider').addEventListener('change', (e) => {
                    if(((+ new Date()) - timestamp) <= 1000) {
                        clearTimeout(timeout);
                    }
                    timestamp = + new Date;
                    timeout = setTimeout(() => {
                        let form = $('#js-range-slider').closest('form');
                        let query_string = _this.buildSearchQuery(form, $);
                        _this.setSpinner('#pm-search-result');
                        _this.call(query_string, '#search-result', null, _this.resultHandlerSearch, null, $, _this);
                        e.preventDefault();
                    }, 1000);
                });
            }
        }
    }

    if (total_result_span_id != null) {
        let total_count_span = $(total_result_span_id);
        let str = '';
        if (data.count == 1) {
            str = data.count + ' ' + total_count_span.data('total-count-singular');
        } else if (data.count > 1 || data.count == 0) {
            str = data.count + ' ' + total_count_span.data('total-count-plural');
        } else {
            str = data.count + ' ' + total_count_span.data('total-count-default');
        }
        total_count_span.html(str.trim());
    }

    if (scrollto != null) {
        _this.scrollTo(scrollto);
    }

    _this.initCalendarRowClick();

    window.history.pushState(null, '', window.location.pathname + '?' + query_string);
    _this.dateRangePickerInit();
    _this.filter();
}

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
    let timeout;
    let timestamp = + new Date();
    if($(window).width() >= 768) {
        document.querySelector('#js-range-slider').addEventListener('change', (e) => {
            if(((+ new Date()) - timestamp) <= 1000) {
                clearTimeout(timeout);
            }
            timestamp = + new Date;
            timeout = setTimeout(() => {
                let form = $('#js-range-slider').closest('form');
                let query_string = _this.buildSearchQuery(form, $);
                _this.setSpinner('#pm-search-result');
                _this.call(query_string, '#search-result', null, _this.resultHandlerSearch, null, $, _this);
                e.preventDefault();
            }, 1000);
        });
    }
}
const resultHandlerSearchBarStandalone = function(data, query_string, scrollto, btn){

    _this.removeButtonLoader(btn);
    let total_count_span = btn.find('span.search-bar-total-count');
    let str = '';
    if (data.count == 1) {
        str = data.count + ' ' + total_count_span.data('total-count-singular');
    } else if (data.count > 1 || data.count == 0) {
        str = data.count + ' ' + total_count_span.data('total-count-plural');
    } else {
        str = data.count + ' ' + total_count_span.data('total-count-default');
    }
    total_count_span.html(str.trim());
}
const pagination = function ($) {

    $("#search-result").on('click', ".page-link", function (e) {
        var href = $(this).attr('href').split('?');
        var query_string = href[1];

        _this.scrollTo('#search-result');
        _this.setSpinner('#pm-search-result');
        _this.call(query_string, null, null, _this.resultHandlerSearch, null, $, _this);
        e.preventDefault();
    });

}
const buildSearchQuery = function (form, $) {

    let query = [];
    query.push('action=search');

    // the object type
    let id_object_type = $(form).find('input[name=pm-ot]').val();
    if (id_object_type && id_object_type != '') {
        query.push('pm-ot=' + id_object_type);
    }

    // categorytree checkboxes
    let selected = [];
    $(form).find('.category-tree input:checked').each(function () {

        let id_parent = $(this).attr('data-id-parent');
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        if (!selected[name]) {
            selected[name] = [];
        }

        let i = selected[name].indexOf(id_parent);
        if (i > -1) {
            // remove if parent is set
            selected[name].splice(i, 1);
        }

        i = selected[name].indexOf(id);
        if (i == -1) {
            // has no parent, add
            selected[name].push(id);
        }

    });
    let key;
    let delimiter = ',';
    for (key in selected) {
        if ($('input[name='+key+'-behavior]').val() == 'AND'){
            delimiter = '%2B';
        }else{
            delimiter = ',';
        }
        query.push('pm-c[' + key + ']=' + selected[key].join(delimiter));
    }

    // board_type checkboxes
    selected = [];
    $(form).find('.board-type input:checked').each(function () {
        selected.push($(this).attr('data-id'));
    });
    if(selected.length > 0){
        query.push('pm-bt=' + selected.join(','));
    }

    // transport_type checkboxes
    selected = [];
    $(form).find('.transport-type input:checked').each(function () {
        selected.push($(this).attr('data-id'));
    });
    if(selected.length > 0){
        query.push('pm-tr=' + selected.join(','));
    }

    // check and set price-range
    let price_range = $(form).find("input[name=pm-pr]").val();
    let price_mm_range = $(form).find("input[name=pm-pr]").data("min") + "-" + $(form).find("input[name=pm-pr]").data("max");
    if (price_range && price_mm_range != price_range && price_range != "") {
        query.push("pm-pr=" + price_range)
    }

    // check and set duration-range
    let duration_range = $(form).find('select[name=pm-du]').val();
    if (duration_range && duration_range != '') {
        query.push('pm-du=' + duration_range);
    }

    // check and set date-range
    let date_range = $(form).find('input[name=pm-dr]').attr('data-value');
    if (date_range && date_range != '') {
        query.push('pm-dr=' + date_range);
    }

    // check and set date-range
    let transport_types = $(form).find('input[name=pm-tt]').data('value');
    if (transport_types && transport_types != '') {
        query.push('pm-tt=' + transport_types);
    }

    // check and set search term
    let search_term = $(form).find('input[name=pm-t]').val();
    if (search_term && search_term != '') {
        query.push('pm-t=' + search_term);
    }

    // the view
    let view = $('.pm-switch-result-view .pm-switch-checkbox').prop('checked');
    if (view) {
        view = $('.pm-switch-result-view .pm-switch-checkbox').val();
    }

    let order = $(form).find('select[name=pm-o]');
    if (order && order != '') {
        if(order.find('option[data-view="Calendar1"]').is(':selected')) {
            view = 'Calendar1';
        }
        query.push('pm-o=' + order.val());
    }

    if (view) {
        query.push('view=' + view);
    }

    // Build the Query
    let query_string;
    query_string = query.join('&');

    return query_string;
}
const filter = ($, _this) => {

    // dont run default realtime ajax-functions on small viewport
    if ($(window).width() > 768) {
        $("#search-filter").off('change').on('change', ".list-filter-box input, .list-filter-box select", function (e) {
            let form = $(this).closest('form');
            // if the second level has no more selected items, we fall back to the parents value
            if($(this).closest('.form-check.has-second-level').find('input:checked').length == 0){
                $(this).closest('.form-check.has-second-level').find('input:disabled:first').attr("disabled", false).prop('checked', true);
            }
            let query_string = _this.buildSearchQuery(form, $);
            _this.setSpinner('#pm-search-result');
            _this.call(query_string, '#search-result', null, _this.resultHandlerSearch, null, $, _this);
            e.preventDefault();
        });
        $('.js-range-slider').on('mouseup', () => {
            let form = $(this).closest('form');
            let query_string = _this.buildSearchQuery(form, $);
            _this.setSpinner('#pm-search-result');
            _this.call(query_string, '#search-result', null, _this.resultHandlerSearch, null, $, _this);
            e.preventDefault();
        });
    }

    $("#search-filter").one('click', ".list-filter-box-submit", function (e) {
        let form = $(this).closest('form');
        // if the second level has no more selected items, we fall back to the parents value
        if($(this).closest('.form-check.has-second-level').find('input:checked').length == 0){
            $(this).closest('.form-check.has-second-level').find('input:disabled:first').attr("disabled", false).prop('checked', true);
        }
        let query_string = _this.buildSearchQuery(form, $);
        _this.setSpinner('#pm-search-result');
        _this.call(query_string, '#search-result', null, _this.resultHandlerSearch, null, $, _this);
        e.preventDefault();
    });

    $("#booking-filter").one('click change', "input", function (e) {
        let form = $(this).closest('form');
        // if the second level has no more selected items, we fall back to the parents value
        if($(this).closest('.form-check.has-second-level').find('input:checked').length == 0){
            $(this).closest('.form-check.has-second-level').find('input:disabled:first').attr("disabled", false).prop('checked', true);
        }
        e.preventDefault();
    });

}

const searchbox = function ($) {

    /**
     * This Event checks if a input field is modified and building the query string.
     * The query string is added to the form > a.btn > href
     * If the search box is on the same site as the search result, than the ajax search query is fired
     */
    $('#main-search').on('change', '.search-box input, .search-box select', function (e) {

        if($(e.target).parent().hasClass('has-second-level')) {
            $(e.target).is(':checked') ? $(e.target).parent().addClass('active') : $(e.target).parent().removeClass('active');
        }

        let form = $('#main-search');
        // build the query string and set him on the search button
        let query_string = _this.buildSearchQuery(form, $);

        let button = $(form).find('a.btn');
        let href = button.attr('href').split('?');
        button.attr('href', href[0] + '?' + query_string);

        // if we're on the same page, let fire the search and set the search results
        let current_location = window.location.href.split('?');
        if (current_location[0] == href[0]) {
            _this.setSpinner('#pm-search-result');
            _this.call(query_string, null, $('.search-bar-total-count'), _this.resultHandlerSearch, null, $, _this);
        } else {
            _this.setButtonLoader(button);
            // in this case we have placed a search box on a site without a direct result output
            _this.call(query_string, null, button, _this.resultHandlerSearchBarStandalone, null, $, _this);
        }

        e.preventDefault();
    });

}

const searchboxSwitch = function ($){
    $(".search-wrapper--tabs_btn").on('click', function (e) {
        $(this).parents().find(".search-wrapper--tabs_btn").removeClass('is-active');
        $(this).addClass('is-active');
        let query_string = 'action=searchbar&pm-tab='+$(this).data('pm-tab') + '&pm-box='+$(this).data('pm-box');
        _this.call(query_string, null, null, _this.resultHandlerSearchBar, null, $, _this);
    });
}

const resultHandlerSearchBar = function(data){
    for (var key in data.html) {
        $('#' + key).replaceWith(data.html[key]);
    }
    _this.searchbox();
    _this.autoCompleteInit();
    _this.dateRangePickerInit();
    _this.initCategoryTreeSearchBarFields();
}
module.exports = {resultHandlerSearchBar, searchboxSwitch, searchbox, filter, pagination, buildSearchQuery, resultHandlerSearch, resultHandlerSearchBarStandalone};
