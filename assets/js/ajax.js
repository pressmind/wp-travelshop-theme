jQuery(function ($) {

    TSAjax = function (endpoint_url) {

        var _this = this;
        this.endpoint_url = endpoint_url;
        this.requests = new Array();


        this.call = function (query_string, scrollto, total_result_span_id, callback, target) {
            this.oneByOneRequest();
            this.requests.push($.ajax({
                url: this.endpoint_url + '?' + query_string,
                method: 'GET',
                data: null
            }).done(function (data) {
                callback(data, query_string, scrollto, total_result_span_id, target);
            }));
        }

        this.oneByOneRequest = function (){
            for (let i = 0; i < this.requests.length; i++) {
                if(i > 1) {
                    this.requests.forEach((it,ind) => {
                        if(ind < i) {
                            it.abort();
                        }
                    });
                }
            }
        }

        this.setSpinner = function (search_result) {
            $('.spinner').show();
            $(search_result).html('');
            $('.pagination').hide();
        }

        this.removeSpinner = function () {
            $('.spinner').hide();
            $('.pagination').show();
        }

        this.setButtonLoader = function (btn) {
            btn.find('svg:not(.always-show)').hide();
            btn.find('span:not(.btn-loader):not(.btn-loader-placeholder)').hide();
            btn.find('.loader').show();
        }

        this.removeButtonLoader = function (btn) {
            btn.find('svg:not(.always-show)').show();
            btn.find('span:not(.btn-loader):not(.btn-loader-placeholder)').show();
            btn.find('.loader').hide();
        }

        // Explicitly save/update a url parameter using HTML5's replaceState().
        this.updateQueryStringParam = function(key, value) {
            let baseUrl = [location.protocol, '//', location.host, location.pathname].join('');
            let urlQueryString = document.location.search;
            var newParam = key + '=' + value,
                params = '?' + newParam;

            // If the "search" string exists, then build params from it
            if (urlQueryString) {
                let keyRegex = new RegExp('([\?&])' + key + '[^&]*');
                // If param exists already, update it
                if (urlQueryString.match(keyRegex) !== null) {
                    params = urlQueryString.replace(keyRegex, "$1" + newParam);
                } else { // Otherwise, add it to end of query string
                    params = urlQueryString + '&' + newParam;
                }
            }
            window.history.replaceState({}, "", baseUrl + params);
        }

        this.getAllUrlParams = function(url) {

            // get query string from url (optional) or window
            var queryString = url ? url.split('?')[1] : window.location.search.slice(1);

            // we'll store the parameters here
            var obj = {};

            // if query string exists
            if (queryString) {

                // stuff after # is not part of query string, so get rid of it
                queryString = queryString.split('#')[0];

                // split our query string into its component parts
                var arr = queryString.split('&');

                for (var i = 0; i < arr.length; i++) {
                    // separate the keys and the values
                    var a = arr[i].split('=');

                    // set parameter name and value (use 'true' if empty)
                    var paramName = a[0];
                    var paramValue = typeof (a[1]) === undefined ? true : a[1];

                    // (optional) keep case consistent
                    if(false) {
                        paramName = String(paramName).toLowerCase();
                        (typeof paramValue === 'string' && paramName.length >= 1) ? paramValue = String(paramValue).toLowerCase() : '';
                    }

                    // if the paramName ends with square brackets, e.g. colors[] or colors[2]
                    if (paramName.match(/\[(\d+)?\]$/)) {

                        // create key if it doesn't exist
                        var key = paramName.replace(/\[(\d+)?\]/, '');
                        if (!obj[key]) obj[key] = [];

                        // if it's an indexed array e.g. colors[2]
                        if (paramName.match(/\[\d+\]$/)) {
                            // get the index value and add the entry at the appropriate position
                            var index = /\[(\d+)\]/.exec(paramName)[1];
                            obj[key][index] = paramValue;
                        } else {
                            // otherwise add the value to the end of the array
                            obj[key].push(paramValue);
                        }
                    } else {
                        // we're dealing with a string
                        if (!obj[paramName]) {
                            // if it doesn't exist, create property
                            obj[paramName] = paramValue;
                        } else if (obj[paramName] && typeof obj[paramName] === 'string') {
                            // if property does exist and it's a string, convert it to an array
                            obj[paramName] = [obj[paramName]];
                            obj[paramName].push(paramValue);
                        } else {
                            // otherwise add the property
                            obj[paramName].push(paramValue);
                        }
                    }
                }
            }

            return obj;
        }

        this.replaceUrlParam = function(url, paramName, paramValue)
        {
            if (paramValue == null) {
                paramValue = '';
            }
            var pattern = new RegExp('\\b('+paramName+'=).*?(&|#|$)');
            if (url.search(pattern)>=0) {
                return url.replace(pattern,'$1' + paramValue + '$2');
            }
            url = url.replace(/[?#]$/,'');
            return url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue;
        }

        this.resultHandlerWishlist = function (data) {

            // set the wishlist
            for (var key in data.html) {
                $('#' + key).html(data.html[key]);
            }

            // sync results to localstorage (if object are deleted from server)
            let relatedList = JSON.parse(window.localStorage.getItem('relatedList'));
            let wishlist  = relatedList?.filter(x => x?.type == 'marked');
            let visitedlist  = relatedList?.filter(x => x?.type == 'viewed');
            if (!jQuery.isEmptyObject(wishlist)) {
                $(wishlist).each(function (key, item) {
                    var is_valid = false;
                    $(data.ids).each(function (key, id) {
                        if (item.id_media_object == id) {
                            is_valid = true;
                        }
                    });
                    if (!is_valid) {
                        console.log(' not valid remove ' + item.id_media_object);
                        _this.wishlistRemoveElement(wishlist, item.id_media_object);
                    }
                });
                $('.wishlist-count').text(wishlist?.length);
                relatedList = wishlist.concat(visitedlist);
                window.localStorage.setItem('relatedList', JSON.stringify(relatedList));
            }

        }

        this.resultHandlerSearch = function (data, query_string, scrollto, total_result_span_id) {

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
                                let query_string = _this.buildSearchQuery(form);
                                _this.setSpinner('#pm-search-result');
                                _this.call(query_string, '#search-result', null, _this.resultHandlerSearch);
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

        if ($('.js-range-slider').length > 0) {
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
                        let query_string = _this.buildSearchQuery(form);
                        _this.setSpinner('#pm-search-result');
                        _this.call(query_string, '#search-result', null, _this.resultHandlerSearch);
                        e.preventDefault();
                    }, 1000);
                });
            }
        }

        this.scrollTo = function (scrollto) {
            $('html, body').stop().animate({
                'scrollTop': $(scrollto).offset().top - $('header.affix').height()
            }, 150, 'swing');
        }

        this.resultHandlerSearchBarStandalone = function(data, query_string, scrollto, btn){

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

        this.renderWishlist = function() {

            let relatedList = JSON.parse(window.localStorage.getItem('relatedList'));
            let wishlist  = relatedList?.filter(x => x?.type == 'marked');
            let visitedlist  = relatedList?.filter(x => x?.type == 'viewed');
            if (wishlist !== null && typeof wishlist != 'undefined' && wishlist?.length !== 0) {
                let query_string = 'action=wishlist&view=Teaser2&pm-id=';
                $('.wishlist-count').text(wishlist?.length);
                $('.wishlist-toggler').addClass('animate');
                setTimeout(function () {
                    $('.wishlist-toggler').removeClass('animate');
                }, 1250);
                wishlist.forEach(function (item, key) {
                    if (key !== wishlist?.length - 1) {
                        query_string += item['id_media_object'] + ',';
                    } else {
                        query_string += item['id_media_object'];
                    }
                });
                _this.call(query_string, null, null, _this.resultHandlerWishlist);
            } else {
                _this.wishlistEventListeners();
                $('.wishlist-count').text(0);
                $('.wishlist-items').html(`<p>Keine Reisen auf der Merkliste</p>`);
            }
        }

        this.wishlistEventListeners = function () {

            if ($('#search-result').length > 0) {
                // Create an observer instance linked to the callback function
                var observer = new MutationObserver(function () {
                    _this.wishListInit();
                });

                observer.observe(document.getElementById('search-result'), {attributes: true, childList: true});
            }
            if ($('.add-to-wishlist').length > 0) {
                $('body').on('click', '.add-to-wishlist', function (e) {
                    let relatedList = JSON.parse(window.localStorage.getItem('relatedList'));
                    let wishlist  = relatedList?.filter(x => x?.type == 'marked');
                    let visitedlist  = relatedList?.filter(x => x?.type == 'viewed');
                    if (jQuery.isEmptyObject(wishlist)) {
                        wishlist = [];
                    }
                    if (wishlist.some(wi => wi.id_media_object == $(e.target).data('pm-id'))) {
                        _this.removeProductRelationInUserAccount(wishlist.find(wi => wi['id_media_object'] == $(e.target).data('pm-id'))?.id).then(() => {
                            _this.wishlistRemoveElement(wishlist, $(e.target).data('pm-id'));
                            relatedList = wishlist.concat(visitedlist);
                            window.localStorage.setItem('relatedList', JSON.stringify(relatedList));
                            _this.renderWishlist();
                            $(e.target).removeClass('active');
                        });
                    } else {
                        _this.saveProductRelationInUserAccount('marked', $(e.target).data('pm-id'), + new Date()).then((createdObj) => {
                            wishlist.push({
                                'id_media_object': $(e.target).data('pm-id'),
                                'type': 'marked',
                                'created': + new Date(),
                                'id': createdObj?.id
                            });
                            relatedList = wishlist.concat(visitedlist);
                            window.localStorage.setItem('relatedList', JSON.stringify(relatedList));
                            _this.renderWishlist();
                            $(e.target).addClass('active');
                        });
                    }
                });
            }
        }

        this.wishListInit = function () {
            $('.dropdown-menu-wishlist').click((e) => {
                if(!$(e.target).is('a')) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                if($(e.target).hasClass('remove-from-wishlist')) {
                    let relatedList = JSON.parse(window.localStorage.getItem('relatedList'));
                    let wishlist  = relatedList?.filter(x => x?.type == 'marked');
                    let visitedlist  = relatedList?.filter(x => x?.type == 'viewed');
                    if (!jQuery.isEmptyObject(wishlist)) {
                        if (wishlist.some(wi => wi.id_media_object == $(e.target).data('pm-id'))) {
                            _this.removeProductRelationInUserAccount(wishlist.find(wi => wi.id_media_object == $(e.target).data('pm-id') && wi.type == 'marked')?.id);
                            _this.wishlistRemoveElement(wishlist, $(e.target).data('pm-id'));
                            // $('.wishlist-heart').removeClass('active');
                            $('.add-to-wishlist').each(function (key, item) {
                                if ($(item).data('pm-id') == $(e.target).data('pm-id')) {
                                    $(item).removeClass('active');
                                }
                            });
                        }
                    }
                    relatedList = wishlist.concat(visitedlist);
                    window.localStorage.setItem('relatedList', JSON.stringify(relatedList));
                    _this.renderWishlist();
                }
            });
            let relatedList = JSON.parse(window.localStorage.getItem('relatedList'));
            let wishlist  = relatedList?.filter(x => x?.type == 'marked');
            let visitedlist  = relatedList?.filter(x => x?.type == 'viewed');
            if (!jQuery.isEmptyObject(wishlist)) {
                $('.add-to-wishlist').each(function (key, item) {
                    if (wishlist.some(wi => wi['id_media_object'] == $(item).data('pm-id'))) {
                        $(item).addClass('active');
                    }
                });
            }
            function setTabVisited() {
                $('.dropdown-menu-visited-toggle').addClass('active');
                $('.dropdown-menu-wishlist-toggle').removeClass('active');
                $('.wishlist-items').removeClass('active');
                $('.visited-items').addClass('active');
                window.localStorage.setItem('currentFavTab', JSON.stringify('visited'));
            }
            function setTabWishlist() {
                $('.dropdown-menu-wishlist-toggle').addClass('active');
                $('.dropdown-menu-visited-toggle').removeClass('active');
                $('.wishlist-items').addClass('active');
                $('.visited-items').removeClass('active');
                window.localStorage.setItem('currentFavTab', JSON.stringify('wishlist'));
            }
            let currentFavTab = JSON.parse(window.localStorage.getItem('currentFavTab'));
            if (!jQuery.isEmptyObject(currentFavTab)) {
                if(currentFavTab == 'wishlist') { setTabWishlist(); }
                if(currentFavTab == 'visited') { setTabVisited(); }
            }
            $('.dropdown-menu-wishlist-toggle').click(() => setTabWishlist());
            $('.dropdown-menu-visited-toggle').click(() => setTabVisited());
        }

        this.wishlistRemoveElement = function (array, elem) {
            array.some(function (item) {
                if (item.id_media_object == elem) {
                    var index = array.indexOf(item);
                    array.splice(index, 1);
                }
            });
        }

        this.resultHandlerVisitedList = function (data) {

            // set the visitedList
            for (var key in data.html) {
                $('#' + key).html(data.html[key]);
            }

            // sync results to localstorage (if object are deleted from server)
            let relatedList = JSON.parse(window.localStorage.getItem('relatedList'));
            let wishlist  = relatedList?.filter(x => x?.type == 'marked');
            let visitedlist  = relatedList?.filter(x => x?.type == 'viewed');
            if (!jQuery.isEmptyObject(visitedlist)) {
                $(visitedlist).each(function (key, item) {
                    var is_valid = false;
                    $(data.ids).each(function (key, id) {
                        if (item.id_media_object == id) {
                            is_valid = true;
                        }
                    });
                    if (!is_valid) {
                        console.log('not valid remove ' + item.id);
                        visitedlist.some(function (it) {
                            if (it.id_media_object == item.id_media_object) {
                                var index = visitedlist.indexOf(it);
                                visitedlist.splice(index, 1);
                            }
                        });
                    }
                });
                relatedList = wishlist.concat(visitedlist);
                window.localStorage.setItem('relatedList', JSON.stringify(relatedList));
            }
        }

        this.renderVisitedList = function() {

            let relatedList = JSON.parse(window.localStorage.getItem('relatedList'));
            let wishlist  = relatedList?.filter(x => x?.type == 'marked');
            let visitedlist  = relatedList?.filter(x => x?.type == 'viewed');
            if (visitedlist !== null && typeof visitedlist != 'undefined' && visitedlist.length !== 0) {
                let query_string = 'action=visitedList&pm-o=list&view=Teaser7';
                let idString = '&pm-id=';
                let timeString = '&pm-time=';
                visitedlist.sort((a,b) => { return a.created + b.created }).forEach(function (item, key) {
                    if (key !== visitedlist.length - 1) {
                        idString += item.id_media_object + ',';
                        timeString += item.created + ',';
                    } else {
                        idString += item.id_media_object;
                        timeString += item.created;
                    }
                });
                query_string = query_string + idString + timeString;
                _this.call(query_string, null, null, _this.resultHandlerVisitedList);
            }
        }

        this.pagination = function () {

            $("#search-result").on('click', ".page-link", function (e) {
                var href = $(this).attr('href').split('?');
                var query_string = href[1];

                _this.scrollTo('#search-result');
                _this.setSpinner('#pm-search-result');
                _this.call(query_string, null, null, _this.resultHandlerSearch);
                e.preventDefault();
            });

        }

        this.buildSearchQuery = function (form, action = 'search') {

            let query = [];
            query.push('action='+action);

            // the object type
            let id_object_type = $(form).find('input[name=pm-ot]').val();
            if (id_object_type && id_object_type != '') {
                query.push('pm-ot=' + id_object_type);
            }

            // categorytree checkboxes
            let selected = [];
            $(form).find('.category-tree-field-items input:checked').each(function () {

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
                if(order.val()){
                    query.push('pm-o=' + order.val());
                }
            }

            if (view) {
                query.push('view=' + view);
            }

            // Build the Query
            let query_string;
            query_string = query.join('&');

            return query_string;
        }

        this.filter = function () {

            // dont run default realtime ajax-functions on small viewport
            if ($(window).width() > 768) {
                $("#search-filter").off('change').on('change', ".list-filter-box input, .list-filter-box select", function (e) {
                    let form = $(this).closest('form');
                    // if the second level has no more selected items, we fall back to the parents value
                    if($(this).closest('.form-check.has-second-level').find('input:checked').length == 0){
                        $(this).closest('.form-check.has-second-level').find('input:disabled:first').attr("disabled", false).prop('checked', true);
                    }
                    let query_string = _this.buildSearchQuery(form);
                    _this.setSpinner('#pm-search-result');
                    _this.call(query_string, '#search-result', null, _this.resultHandlerSearch);
                    e.preventDefault();
                });
                $('.js-range-slider').on('mouseup', () => {
                    let form = $(this).closest('form');
                    let query_string = _this.buildSearchQuery(form);
                    _this.setSpinner('#pm-search-result');
                    _this.call(query_string, '#search-result', null, _this.resultHandlerSearch);
                    e.preventDefault();
                });
            }

            $("#search-filter").one('click', ".list-filter-box-submit", function (e) {
                let form = $(this).closest('form');
                // if the second level has no more selected items, we fall back to the parents value
                if($(this).closest('.form-check.has-second-level').find('input:checked').length == 0){
                    $(this).closest('.form-check.has-second-level').find('input:disabled:first').attr("disabled", false).prop('checked', true);
                }
                let query_string = _this.buildSearchQuery(form);
                _this.setSpinner('#pm-search-result');
                _this.call(query_string, '#search-result', null, _this.resultHandlerSearch);
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

        this.searchbox = function () {

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
                let query_string = _this.buildSearchQuery(form);

                let button = $(form).find('a.btn');
                let href = button.attr('href').split('?');
                button.attr('href', href[0] + '?' + query_string);

                // if we're on the same page, let fire the search and set the search results
                let current_location = window.location.href.split('?');
                if (current_location[0] == href[0]) {
                    _this.setSpinner('#pm-search-result');
                    _this.call(query_string, null, $('.search-bar-total-count'), _this.resultHandlerSearch);
                } else {
                    _this.setButtonLoader(button);
                    // in this case we have placed a search box on a site without a direct result output
                    _this.call(query_string, null, button, _this.resultHandlerSearchBarStandalone);
                }

                e.preventDefault();
            });

        }

        this.searchboxSwitch = function (){
            $(".search-wrapper--tabs_btn").on('click', function (e) {
                $(this).parents().find(".search-wrapper--tabs_btn").removeClass('is-active');
                $(this).addClass('is-active');
                let query_string = 'action=searchbar&pm-tab='+$(this).data('pm-tab') + '&pm-box='+$(this).data('pm-box');
                _this.call(query_string, null, null, _this.resultHandlerSearchBar);
            });
        }

        this.resultHandlerSearchBar = function(data){
            for (var key in data.html) {
                $('#' + key).replaceWith(data.html[key]);
            }
            _this.searchbox();
            _this.autoCompleteInit();
            _this.dateRangePickerInit();
            _this.initCategoryTreeSearchBarFields();
        }

        this.autoCompleteInit = function (){
            if ($('.auto-complete').length > 0) {
                var autoCompleteContainerClass = 'autocomplete-suggestions';

                // -- submit form on return?
                $('.auto-complete').keypress(function(e) {
                    if ( e.which == 10 || e.which == 13 ) {
                        $(this).parents('form').submit();
                    }
                });

                $('.auto-complete').keyup((e) => {
                    if(e.keyCode == 8 && $.trim(e.target.value).length < 3) {
                        $(e.target).autocomplete('disable');
                        $(e.target).parent().find('.string-search-clear').hide();
                        $(e.target).parent().find('.lds-dual-ring').hide();

                        // -- replace result content with stored placeholder
                        if ( $(e.target).hasClass('auto-complete-overlay') ) {
                            var targetResultReset = $(e.target).parents('.search-box-field--fulltext').find('.string-search-overlay-results');
                            var thisPlaceholder = $(e.target).parents('.search-box-field--fulltext').find('.search-field-input--fulltext').data('search-placeholder');


                            if ( targetResultReset.length > 0 ) {
                                targetResultReset.html($('#searchStorage_' + thisPlaceholder).first().html());
                            }
                        }
                    } else {
                        $(e.target).autocomplete('enable');
                    }

                    // get value and set it to overlay "fake" input
                    if ( $(e.target).hasClass('auto-complete-overlay') ) {
                        var thisSearchValue = $(e.target).val();

                        $(e.target).parents('.search-box-field--fulltext').find('.string-search-trigger').val(thisSearchValue);
                    }
                });
                $('.auto-complete').each(function(e) {
                    if ( $(this).hasClass('auto-complete-overlay') ) {
                        autoCompleteContainerClass = 'autocomplate-suggestions-overlay ' + $(this).data('containerclass');
                    } else {
                        autoCompleteContainerClass = 'autocomplete-suggestions';
                    }

                    $(this).autocomplete({
                        serviceUrl: '/wp-content/themes/travelshop/pm-ajax-endpoint.php?action=autocomplete',
                        type: 'GET',
                        dataType: 'json',
                        paramName: 'pm-t',
                        deferRequestBy: 0,
                        containerClass: autoCompleteContainerClass,
                        minChars: 3,
                        width: 'flex',
                        groupBy: 'category',
                        preventBadQueries: false,
                        tabDisabled: true,
                        preserveInput: true,
                        formatResult: function (suggestion, currentValue){
                            var re = new RegExp(`${currentValue}`, 'gi');
                            let img = typeof suggestion.img != 'undefined' ? '<div class="suggestion-featured-image"><img src="' + suggestion.img + '" /></div>' : '';
                            let price = typeof suggestion.price != 'undefined' ? '<div class="suggestion-price"><small>schon ab</small><br /><strong>' + suggestion.price + '</strong></div>' : '';
                            let arrow = suggestion.type != 'media_object' ? '<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="/wp-content/themes/travelshop/assets/img/phosphor-sprite.svg#arrow-up-right"></use></svg>' : '';
                            return '<div class="string-search-suggestion">' +
                                '<div class="suggestion-left">' +
                                img +
                                '<div class="suggestion-string">' + suggestion.value?.replace(re, '<strong>$&</strong>') + '</div>' +
                                '</div>' +
                                price +
                                arrow +
                                '</div>';
                        },
                        onSelect: function (suggestion) {
                            if (suggestion.data.type == 'link') {
                                document.location.href = suggestion.data.url;
                            } else if (suggestion.data.type == 'search') {
                                var url = $(this).parents('form').attr('action');
                                url += '?' + suggestion.data.search_request;
                                document.location.href = url;
                            }
                        },
                        onSearchStart: function () {
                            $(this).parent().find('.lds-dual-ring').show();
                            $(this).parent().find('.string-search-clear').hide();
                            $(this).parent().find('.string-search-clear').hide();
                        },
                        onSearchComplete: function() {
                            $(this).parent().find('.lds-dual-ring').hide();
                            $(this).parent().find('.string-search-clear').show().click(() => {
                                $(this).val('');
                                $(this).parent().find('.string-search-clear').hide();
                            });
                            if($(this).autocomplete().disabled) {
                                $(this).parent().find('.string-search-clear').hide();
                            }

                            if ( $(this).hasClass('auto-complete-overlay') ) {
                                var targetResultDraw = $(this).parents('.search-box-field--fulltext').find('.string-search-overlay-results');
                                var thisInputContainerClass = $(this).data('containerclass');

                                if ( targetResultDraw.length > 0 ) {
                                    var storeResultHtml = $('.' + thisInputContainerClass).html();

                                    targetResultDraw.html(storeResultHtml);
                                }
                            }
                        }
                    })

                });
            }
        }

        this.priceRangeSliderInit = function() {
            if($('.js-range-slider').length > 0) {
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
                            let query_string = _this.buildSearchQuery(form);
                            _this.setSpinner('#pm-search-result');
                            _this.call(query_string, '#search-result', null, _this.resultHandlerSearch);
                            e.preventDefault();
                        }, 1000);
                    });
                }
            }
        }

        _this.picker = [];

        this.dateRangePickerInit = function() {

            if ($('[data-type="daterange"]').length > 0) {

                let easterDate = _this.theEasterDate(dayjs().year());
                if(easterDate.isBefore(dayjs())){
                    easterDate = _this.theEasterDate(dayjs().add(1, 'year').year());
                }

                let pfingstenDate = _this.theEasterDate(dayjs().year()).add(49, 'days');
                if(pfingstenDate.isBefore(dayjs())){
                    pfingstenDate = _this.theEasterDate(dayjs().add(1, 'year').year()).add(49, 'days');
                }

                let rosenmontagDate = _this.theEasterDate(dayjs().year()).subtract(48, 'days');
                if(rosenmontagDate.isBefore(dayjs())){
                    rosenmontagDate = _this.theEasterDate(dayjs().add(1, 'year').year()).subtract(48, 'days');
                }

                $('[data-type="daterange"]').each((index, item) => {
                    _this.picker[index] = $(item).unbind().daterangepicker({
                        "parentEl": $('#booking-filter').length ? '#booking-filter': 'body',
                        "opens": $('#booking-filter').length ? 'left' : 'right',
                        "ranges": {
                            'Heute': [dayjs(), dayjs()],
                            'Abreise in 30 Tagen': [dayjs().add(30, 'days'), dayjs().add(30, 'days').add(1, 'month')],
                            'Abreise in 60 Tagen': [dayjs().add(60, 'days'), dayjs().add(60, 'days').add(1, 'month')],
                            'in diesem Monat': [dayjs().startOf('month'), dayjs().endOf('month')],
                            'über Rosenmontag': [rosenmontagDate.subtract(7, 'days'), rosenmontagDate],
                            'über Ostern': [easterDate.subtract(7, 'days'), easterDate],
                            'über Pfingsten': [pfingstenDate.subtract(7, 'days'), pfingstenDate],
                            'über Weihnachten': [dayjs().month(11).date(15), dayjs().month(11).date(24)],
                            'über Silvester': [dayjs().month(11).date(25), dayjs().month(11).date(31)],
                            'im nächsten Monat': [dayjs().add(1, 'month').startOf('month'), dayjs().add(1, 'month').endOf('month')],
                        },
                        "changeMonth": false,
                        "changeYear": false,
                        "showWeekNumbers": false,
                        "autoUpdateInput": false,
                        "alwaysShowCalendars": true,
                        "showDropdowns": true,
                        "minDate": $('[data-type="daterange"]').data('mindate'),
                        "maxDate": $('[data-type="daterange"]').data('maxdate'),
                        "maxYear": parseInt(dayjs($('[data-type="daterange"]').data('maxdate'), 'DD.MM.YYYY').format("YYYY")),
                        "minYear": parseInt(dayjs($('[data-type="daterange"]').data('mindate'), 'DD.MM.YYYY').format("YYYY")),
                        "showCustomRangeLabel": false,
                        "linkedCalendars": true,
                        isCustomDate: function(date) {
                            if($('[data-type="daterange"]').data('departures').indexOf(date.format('YYYY-MM-DD')) >= 0){
                                return 'has_departures';
                            }
                        },
                        // "autoApply": true,
                        "locale": {
                            "format": "DD.MM.YYYY",
                            "separator": " - ",
                            "applyLabel": "Auswahl übernehmen",
                            "fromLabel": "Von",
                            "toLabel": "Bis",
                            "customRangeLabel": "Custom",
                            "weekLabel": "W",
                            "daysOfWeek": [
                                "So",
                                "Mo",
                                "Di",
                                "Mi",
                                "Do",
                                "Fr",
                                "Sa"
                            ],
                            "monthNames": [
                                "Januar",
                                "Februar",
                                "März",
                                "April",
                                "Mai",
                                "Juni",
                                "Juli",
                                "August",
                                "September",
                                "Oktober",
                                "November",
                                "Dezember"
                            ],
                            "firstDay": 1,
                            "buttonClasses": "btn btn-outline-secondary btn-block",
                            "applyButtonClasses": "btn btn-outline-secondary btn-block",
                            "cancelClass": "datepicker-clear",
                            "cancelLabel": '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>'
                        },
                        /*
                        "startDate": dayjs().startOf('hour'),
                        "endDate": dayjs().startOf('hour').add(64, 'hour')
                        */
                    }, function (start, end, label) {
                        $('.modal-body-outer').scrollTop(0);
                    });

                    $(item).off('apply.daterangepicker').on('apply.daterangepicker', function (ev, picker) {
                        $('[data-type="daterange"]').val(picker.startDate.format('DD.MM.') + ' - ' + picker.endDate.format('DD.MM.YY'));
                        $('[data-type="daterange"]').attr('data-value', picker.startDate.format('YYYYMMDD') + '-' + picker.endDate.format('YYYYMMDD'));
                        _this.dpquery = '&pm-dr=' + String(picker.startDate.format('YYYYMMDD') + '-' + picker.endDate.format('YYYYMMDD'));
                        if($(ev.target).data('ajax') == '1') {
                            $('[data-type="daterange"]').each((ind, it) => {
                                ind == 0 ? $(it).trigger('change') : null;
                            });
                        } else {
                            _this.loadOffers(ev, 'filter', '&pm-dr=' + picker.startDate.format('YYYYMMDD') + '-' + picker.endDate.format('YYYYMMDD'));
                            if ($(ev.target).val() != '') {
                                $(ev.target).siblings('.datepicker-clear').show();
                                $(ev.target).siblings('.datepicker-icon').hide();
                            } else {
                                $(ev.target).siblings('.datepicker-clear').hide();
                                $(ev.target).siblings('.datepicker-icon').show();
                            }
                        }
                        _this.selectedOfferID = null;
                        _this.firstCancel = true;
                    });

                    _this.firstCancel = true;
                    $(item).off('cancel.daterangepicker').on('cancel.daterangepicker', function (ev, picker) {
                        _this.firstCancel ? $('[data-type="daterange"]').each((ind, it) => {
                            _this.dpquery = '&pm-dr=';
                            $('[data-type="daterange"]').val('');
                            $('[data-type="daterange"]').attr('data-value', '');
                            $('[data-type="daterange"]').trigger('change');
                            picker.leftCalendar.month = dayjs($(ev.target).data('mindate'), 'DD.MM.YYYY');
                            picker.rightCalendar.month = dayjs($(ev.target).data('maxdate'), 'DD.MM.YYYY');
                            if(_this.firstCancel == false) { return false; }
                            _this.firstCancel = false;
                        }) : '';
                    });
                });

                // -- show/hide clear button in datepicker
                $('[data-type="daterange"]').on('change', function (e) {
                    if ($(this).val() != '') {
                        $(e.target).siblings('.datepicker-clear').show();
                        $(e.target).siblings('.datepicker-icon').hide();
                    } else {
                        $(e.target).siblings('.datepicker-clear').hide();
                        $(e.target).siblings('.datepicker-icon').show();
                    }
                });

                document.addEventListener("DOMContentLoaded", function (event) {
                    $('.travelshop-datepicker-input').one('click', function () {
                        $('.daterangepicker select').prettyDropdown({
                            height: 30
                        });
                    });
                    $('.monthselect').one('change', function () {
                        $('.daterangepicker select').prettyDropdown({
                            height: 30
                        });
                    });
                });

            }
        }

        /**
         * based on this magic date (easter sunday), it's possible to calculate some special dates:
         *
         * offset to german feiertag from the easterdate
         * - Weiberfastnacht	-52
         * - Rosenmontag	-48
         * - Fastnachtsdienstag	-47
         * - Aschermittwoch	-46
         * - Gründonnerstag	-3
         * - Karfreitag	-2
         * - Ostersonntag	0
         * - Ostermontag	+1
         * - Christi Himmelfahrt	+39
         * - Pfingstsonntag	+49
         * - Pfingstmontag	+50
         * - Fronleichnam	+60
         *
         * @param Y Year YYYY
         * @returns dayjs
         */
        this.theEasterDate = function (Y) {
            var C = Math.floor(Y/100);
            var N = Y - 19*Math.floor(Y/19);
            var K = Math.floor((C - 17)/25);
            var I = C - Math.floor(C/4) - Math.floor((C - K)/3) + 19*N + 15;
            I = I - 30*Math.floor((I/30));
            I = I - Math.floor(I/28)*(1 - Math.floor(I/28)*Math.floor(29/(I + 1))*Math.floor((21 - N)/11));
            var J = Y + Math.floor(Y/4) + I + 2 - C + Math.floor(C/4);
            J = J - 7*Math.floor(J/7);
            var L = I - J;
            var M = 3 + Math.floor((L + 40)/44);
            var D = L + 28 - 31*Math.floor(M/4);

            return dayjs().month(M - 1).date(D).year(Y);
        }


        /**
         * Adds the multi item select feature to the the default bootstrap dropdown box
         */
        this.initCategoryTreeSearchBarFields = function(){

            if ($('.dropdown-menu-select').length > 0) {

                // -- prevent dropdown close when clicked inside
                $('.dropdown-menu-select').on('click', function (e) {

                    // -- little hook
                    // -- backdrop checker
                    if ( $(e.target).css('container-name') === 'backdrop' ) {
                        $(e.target).parent().find('button[data-type="close-popup"]').trigger('click');
                    }

                    e.stopPropagation();
                });

                $('.dropdown-menu-select .filter-prompt').on('click', function (e) {
                    e.preventDefault();

                    $(e.target).parents('.dropdown').find('.dropdown-menu-select').removeClass('show');

                    e.stopPropagation();
                })

                // -- make dropdown span-checkboxes clickable
                $('.multi-level-checkboxes .form-check span').on('click', function (e) {
                    if ($(e.target).siblings('input').is(':checked')) {
                        $(e.target).siblings('input').prop('checked', false).trigger('change');
                    } else {
                        $(e.target).parent().find('input').prop('checked', true).trigger('change');
                    }
                });

                // -- create label text on input change, put it into span
                $('.dropdown-menu-select').find('input').on('click change', function (e) {
                    $(e.target).parent().siblings().find('.form-check-input').prop('checked', false);
                    setTimeout( () => {
                        var placeHolderTag = $(e.target).parents('.dropdown').find('.selected-options'),
                            placeHolderDefaultText = placeHolderTag.data('placeholder'),
                            placeHolderGetText = placeHolderTag.text(),
                            placeHolderOptionsText = '',
                            that = $(this);

                        if (placeHolderGetText != placeHolderDefaultText) {
                            placeHolderOptionsText = placeHolderGetText;
                        }

                        var thatValue = that.parent().find('> label').text();
                        thatValue = $.trim(thatValue);

                        var allBoxes = $(this).parent().parent().find('input');
                        var allEmpty = true;

                        $(allBoxes).each(function (key, input) {
                            if (input.checked) {
                                allEmpty = false;
                            }
                        });

                        // function to hide/show the clear-button
                        if (!allEmpty) {
                            $(this).parent().parent().parent().parent().find('.dropdown-clear').show();
                            $(this).parent().parent().parent().parent().find('.dropdown-icon').hide();
                        } else {
                            $(this).parent().parent().parent().parent().find('.dropdown-clear').hide();
                            $(this).parent().parent().parent().parent().find('.dropdown-icon').show();
                        }

                        if (that.prop('checked') === true) {
                            if(that.attr('type') == 'radio') {
                                placeHolderOptionsText = thatValue;
                            } else {
                                if (placeHolderOptionsText != '' && !placeHolderOptionsText.includes(thatValue)) {
                                    placeHolderOptionsText = /*placeHolderOptionsText + ', ' +*/ thatValue;
                                } else {
                                    if(!placeHolderOptionsText.includes(thatValue)) {
                                        placeHolderOptionsText = thatValue;
                                    }
                                }
                            }
                        } else {
                            if (placeHolderGetText.indexOf(',') != -1) {
                                if (placeHolderGetText.indexOf(thatValue) == 0) {
                                    placeHolderOptionsText = placeHolderOptionsText.replace(thatValue + ', ', '');
                                } else {
                                    placeHolderOptionsText = placeHolderOptionsText.replace(', ' + thatValue, '');
                                }
                            } else {
                                if (allEmpty) {
                                    placeHolderOptionsText = $.trim(placeHolderDefaultText);
                                } else {
                                    placeHolderOptionsText = placeHolderOptionsText;
                                }
                            }
                        }

                        placeHolderTag.text(placeHolderOptionsText);
                    }, 250);
                });

                $('.dropdown-clear').on('click', function (e) {
                    e.stopPropagation();
                    var placeHolderTag = $(e.target).parent().parent().find('.selected-options');
                    var dropdown = $(e.target).parent().parent().parent().find('.dropdown-menu');
                    var allBoxes = $(dropdown).find('input');
                    var fired = false;
                    $(allBoxes).each(function (key, input) {
                        if (input.checked && !fired) {
                            $(allBoxes).prop('checked', false);
                            $(input).trigger('change');
                            fired = true;
                        }
                    });

                    $(placeHolderTag).empty().text('bitte wählen');

                    $(e.target).hide();
                });

                // Init on load
                $('.dropdown-menu-select input:checked').trigger('change');

            }
        }

        this.initCalendarRowClick = function(){
            if ( $('.product-calendar-group-items').length > 0 ) {
                $('.product-calendar-group-items').on('click', '.product-calendar-group-item', function(e) {
                    e.preventDefault();
                    let row_id = $(this).data('row-id');

                    if ( $(this).hasClass('is-active') ) { // close
                        $(this).removeClass('is-active');
                        $('.product-calendar-group-item--product[data-row-id="'+row_id+'"]').removeClass('is-open');

                    } else { // open & load product
                        let pm_id = $(this).data('pm-id');
                        let pm_dr = $(this).data('pm-dr');
                        $('.product-calendar-group-item').removeClass('is-active');
                        $('.product-calendar-group-item--product').removeClass('is-open');
                        $(this).addClass('is-active');
                        let query_string = 'action=pm-view&view=Teaser3&pm-id='+pm_id+'&pm-dr='+pm_dr;
                        _this.call(query_string, null, null, _this.calendarRowClickResultHandler, '.product-calendar-group-item--product[data-row-id="'+row_id+'"]');
                        $('.product-calendar-group-item--product[data-row-id="'+row_id+'"]').addClass('is-open');
                    }
                    e.stopPropagation();
                })
            }
        }

        this.calendarRowClickResultHandler = function (data, query_string, scrollto, total_result_span_id, target){
            $(target).html(data.html);
            _this.wishlistEventListeners();
            _this.wishListInit();
        }

        this.checkAvailability = function (id_offer, quantity, booking_btn){
            this.requests.push($.ajax({
                url: ts_ajax_check_availibility_endpoint,
                type: 'POST',
                contentType: "application/json; charset=utf-8",
                data: JSON.stringify({'checks' : [{
                        'id_offer' : id_offer,
                        'quantity' : quantity
                    }]}),
            }).done(function (response) {
                let data = response.data[0];
                $(booking_btn).find('span').html(data.btn_msg);
                $(booking_btn).attr('title', data.msg);
                $(booking_btn).find('.loader').hide();
                $(booking_btn).removeClass('green');
                $(booking_btn).find('svg').show();
                $(booking_btn).addClass(data.class);
                if(data.bookable === true && data.booking_type != 'request'){
                    let href = new URL($(booking_btn).attr('href'));
                    if(href.searchParams.get('t') != 'request'){
                        href.searchParams.set('t', data.booking_type);
                    }
                    location.href = href.toString();
                } else if(data.bookable === true) {
                    $(booking_btn).click(() => {location.href = $(booking_btn).attr('href') + '&t='+data.booking_type});
                }
            }));
        }

        _this.lastScroll = 0;
        _this.dpquery = '&pm-dr=';
        this.initOfferListeners = function() {
            _this.initBookingBtnClickHandler();
            // Fire Infnity when User scrolls to bottom
            if($('.modal-body-outer').length) {
                _this.fired = false;
                $('.modal-body-outer').scroll(function() {
                    _this.nowScroll = $(this).scrollTop();
                    if (_this.nowScroll > _this.lastScroll) {
                        if (_this.nowScroll >= $('#offer-section').outerHeight() - $(this).outerHeight() && !_this.fired) {
                            _this.loadOffers(null, 'infinity', _this.dpquery);
                        }
                    }
                    _this.lastScroll = _this.nowScroll;
                });
            }
            $('.clear-filter').unbind().on('click', (e) => {
                $('.modal-loader').css('display', 'flex');
                $('.datepicker-clear').trigger('click');
                $('input:checked').prop('checked', false).trigger('change');
                $('input[name=pm-dr]').val('').trigger('change');
            });
            // -----------------------
            // --- Detail Booking Filter Input Select
            // -----------------------
            if($('.filter-form').length || $('.filter-form-mobile').length) {
                $('.filter-form, .filter-form-mobile').find('input').on('change', (e) => {
                    $('.modal-loader').css('display', 'flex');
                    if($(e.target).data('type') != 'daterange') {
                        let queryParam = $(e.target).attr('filter-param');
                        let selectedValues = '';
                        $(e.target).parent().parent().find('input:checked').each((key, item) => {
                            if($(item).attr('filter-param') == queryParam) {
                                if(!selectedValues.includes($(item).val())) {
                                    selectedValues += $(item).val() + ($('.' + e.target.form.classList[0] + ' input[filter-param="' + $(item).attr('filter-param') + '"]:checked').length > key + 1 ? ',' : '');
                                }
                            }
                        });
                        if(selectedValues.length != 0) {
                            $(e.target).parent().parent().parent().parent().find('.dropdown-clear').show();
                            $(e.target).parent().parent().parent().parent().find('.dropdown-icon').hide();
                        } else {
                            $(e.target).parent().parent().parent().parent().find('.dropdown-clear').hide();
                            $(e.target).parent().parent().parent().parent().find('.dropdown-icon').show();
                        }
                        $('.transport_1_airport_name').hide();
                        if($('.' + e.target.form.classList[0] + ' input[value="Flug"]:checked').length || $('.' + e.target.form.classList[0] + ' input[name="transport_type"]:checked').length == 0) {
                            $('.transport_1_airport_name').show();
                        } else {
                            if($('.' + e.target.form.classList[0] + ' input[filter-type="transport_1_airport_name"]:checked').length != 0) {
                                $('.' + e.target.form.classList[0] + ' input[filter-type="transport_1_airport_name"]').prop( "checked", false ).change();
                            }
                        }
                        _this.updateQueryStringParam($(e.target).attr('filter-param'), selectedValues);
                    } else {
                        if($(e.target).val().length > 1) {
                            _this.dpquery = '&pm-dr=' + String(_this.picker[0].startDate.format('YYYYMMDD') + '-' + _this.picker[0].endDate.format('YYYYMMDD'));
                        }
                    }
                    _this.loadOffers(e, 'filter', _this.dpquery);
                    $('.modal-body-outer').animate({
                        scrollTop: 0
                    }, 0);
                    setTimeout(() => {
                        $('.modal-loader').css('display', 'none');
                    }, 400);
                });
            }
        }

        // ------------------------------
        // -- content modal
        // ------------------------------

        this.initModals = function() {
            if ($('.modal-wrapper').length > 0) {
                $('a[data-modal="true"]').on('click', function (e) {
                    console.log('Modal open');
                    e.preventDefault();
                    let modalId = $(e.target).data('modal-id');
                    // -- show modal
                    $('body').find('#modal-id-post-' + modalId).addClass('is-open');
                    if($(e.target).hasClass('booking-btn') || $(e.target).hasClass('stretched-link')) {
                        $('.modal-loader').css('display', 'flex');
                        setTimeout(() => {
                            modalId != 'bofilters' ? _this.loadFilters() : '';
                            setTimeout(() => {
                                _this.loadOffers(e);
                            }, 200);
                        }, 500);
                    }
                    let target = document.querySelector('.is-open .modal-body-outer');
                    bodyScrollLock.disableBodyScroll(target);
                    e.stopPropagation();
                })

                $('.modal-close, .modal-close-btn').on('click', function (e) {
                    e.preventDefault();
                    let target = document.querySelector('.is-open .modal-body-outer');
                    $(e.target).closest('.is-open').removeClass('is-open');
                    bodyScrollLock.enableBodyScroll;
                    e.stopPropagation();
                })

                $(document).on('keyup', function (e) {
                    if (e.which == 27) $('.modal-close').click(); // esc
                });
            }
        }

        this.loadFilters = function() {
            _this.infinityActive = true;
            $('.modal-loader').css('display', 'flex');
            const URLParams = _this.getAllUrlParams();
            let querystring = '';
            Object.entries(URLParams).forEach(entry => {
                const [key, value] = entry;
                querystring += '&' + key + '=' + value;
            });
            _this.call('action=bookingoffersfilter&pm-id=' + moid + querystring, '#booking-filter', null, function(data2) {
                for (var key2 in data2.html) {
                    $('#' + key2).html(data2.html[key2]);
                    _this.initModals();
                    _this.initFilterMethods();
                }
            });
        }

        this.initFilterMethods = function() {
            $('.filter-form, .filter-form-mobile').find('input').trigger('change');
            _this.initCategoryTreeSearchBarFields();
            _this.dateRangePickerInit();
        }

        this.loadOffers = function(e, type, query) {
            if($('.detail-page-v2-container').length) {
                if(_this.infinityActive | type != 'infinity') {
                    $('.modal-loader').css('display', 'flex');
                }
                const URLParams = _this.getAllUrlParams();
                let querystring = '';
                Object.entries(URLParams).forEach(entry => {
                    const [key, value] = entry;
                    if(key != 'pm-dr') {
                        querystring += '&' + key + '=' + value;
                    }
                });
                if(type != 'infinity' && !_this.offersLoaded) {
                    let selectedOfferID;
                    typeof $(e.target).data('anchor') != 'undefined' ? selectedOfferID = $(e.target).data('anchor') : selectedOfferID = undefined;
                    _this.call('action=bookingoffers&pm-oid=' + selectedOfferID + '&pm-id=' + moid + querystring + String(typeof query != 'undefined' ? query : ''), null, '#booking-offers', function(data) {
                        for (var key in data.html) {
                            $('#' + key).html(data.html[key]);
                            $('#offers-filter-total').text(data.total == 15 ? 'Über 15' : data.total);
                            _this.initOfferListeners();
                            _this.items = data.total;
                            _this.loaded = data.total;
                            _this.infinityActive = true;
                            setTimeout(() => {
                                $('.modal-loader').css('display', 'none');
                            }, 400);
                            if($(e.target).data('anchor')) {
                                $('.modal-body-outer').scrollTop(0);
                                $('.booking-row').removeClass('checked');
                                $( 'div[data-id-offer="' + $(e.target).data('anchor') + '"].booking-row' ).addClass('checked');
                                setTimeout(function() {
                                    if($( 'a[data-id-offer="' + $(e.target).data('anchor') + '"]' ).length) {
                                        $('.modal-body-outer').animate({
                                            scrollTop: $( 'a[data-id-offer="' + $(e.target).data('anchor') + '"]' ).offset().top - ( $('.modal-body-outer').offset().top + ($(window).width() < 768 ? 325 : 325) )
                                        }, 0);
                                    }
                                }, 0);
                            }
                        }
                    });
                } else {
                    _this.fired = true;
                    _this.call('action=bookingoffers&type=infinity&pm-id=' + moid + querystring + '&pm-l=' + _this.loaded + ',' + _this.items + (typeof query != 'undefined' ? query : ''),  null, '#offer-section', function(data) {
                        for (var key in data.html) {
                            if(data.total != 0) {
                                _this.loaded = _this.loaded + _this.items;
                            } else {
                                _this.infinityActive = false;
                            }
                            $('#' + key).append(data.html[key]);
                            $( 'div[data-id-offer="' + _this.offerID + '"].booking-row' ).addClass('checked');
                            _this.initOfferListeners();
                            setTimeout(() => {
                                $('.modal-loader').css('display', 'none');
                                _this.fired = false;
                            }, 400);
                        }
                    });
                }
            }
        }

        this.initBookingBtnClickHandler = function (){
            if ($('.booking-btn').length > 0) {
                $('.booking-btn').not('.detail-booking-entrypoint .booking-btn').on('click', function (e) {
                    if($(this).data('modal') === true){
                        return true;
                    }
                    e.stopPropagation();
                    e.preventDefault();
                    $(this).find('.loader').show();
                    $(this).find('svg').hide();
                    $(this).find('span').html('');
                    _this.checkAvailability($(this).data('id-offer'), 1, $(e.target));
                });
            }
        }

        this.initPartnerParams = function () {
            let getUrlParameter = function getUrlParameter(sParam) {
                var sPageURL = window.location.search.substring(1),
                    sURLVariables = sPageURL.split('&'),
                    sParameterName,
                    i;

                for (i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split('=');

                    if (sParameterName[0] === sParam) {
                        return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                    }
                }
                return false;
            };
            if(getUrlParameter(partnerParam)) {
                localStorage.setItem('partnerParam', getUrlParameter(partnerParam));
                localStorage.setItem('partnerTimestamp', + new Date());
            }
            if(localStorage.getItem('partnerParam') && localStorage.getItem('partnerTimestamp')) {
                if(localStorage.getItem('partnerTimestamp') >= (+ new Date() - (partnerTimeout * 86400000) )) {
                    $('.booking-btn').each((index, item) => {
                        let href = $(item).attr('href')
                        $(item).attr('href', href + '&ida=' + localStorage.getItem('partnerParam'));
                    });
                }

            }
        }

        // ====================================
        // USER/AGENCY LOGIN FUNCTIONALITY START
        // ====================================
        this.currentTimestampToDateString = function(timestamp) {
            const currentDate = new Date(timestamp);
            const currentDayOfMonth = String(currentDate.getDate()).padStart(2, '0');
            const currentMonth = String(currentDate.getMonth() + 1).padStart(2, '0'); // Be careful! January is 0, not 1
            const currentYear = currentDate.getFullYear();
            const currentHour = String(currentDate.getHours()).padStart(2, '0');
            const currentMinute = String(currentDate.getMinutes()).padStart(2, '0');
            const currentSeconds = String(currentDate.getSeconds()).padStart(2, '0');
            return currentYear + '-' + currentMonth + '-' + currentDayOfMonth + ' ' + currentHour + ':' + currentMinute + ':' + currentSeconds;
        }
        this.saveProductRelationInUserAccount = function(type, id, timestamp) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: IBEURL + '/api/external/createUserProductRelation',
                    method: 'POST',
                    data: {
                        id_media_object: id,
                        type: type,
                        created: _this.currentTimestampToDateString(timestamp)
                    },
                    xhrFields: {withCredentials: true},
                    crossDomain: true
                }).done(function (productRelationsData) {
                    resolve(productRelationsData.data);
                    if(productRelationsData.success) {}
                });
            });
        }
        this.removeProductRelationInUserAccount = function(id) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: IBEURL + '/api/external/deleteUserProductRelation',
                    method: 'POST',
                    data: {
                        id: id
                    },
                    xhrFields: {withCredentials: true},
                    crossDomain: true
                }).done(function (productRelationsData) {
                    resolve();
                });
            });
        }
        this.getProductRelationsInUserAccount = function () {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: IBEURL + '/api/external/getUserProductRelation',
                    method: 'GET',
                    xhrFields: {withCredentials: true},
                    crossDomain: true
                }).done(function (productRelationsData) {
                    if(productRelationsData.message = 'success' && productRelationsData.data.length > 0) {
                        resolve(productRelationsData.data);
                    } else {
                        resolve([]);
                    }
                });
            });
        }
        this.matchRelatedProducts = function() {
            _this.getProductRelationsInUserAccount().then((userAccountRelatedProducts) => {
                let relatedList = JSON.parse(window.localStorage.getItem('relatedList'));
                if(jQuery.isEmptyObject(relatedList)) {
                    relatedList = [];
                }
                let pushItemsToAcc = async () => {
                    return new Promise((resolve, reject) => {
                        if(relatedList.length == 0 || typeof relatedList == 'undefined') {
                            resolve();
                        } else {
                            let lastIndex = relatedList.reduce((a,b,c) => { if(userAccountRelatedProducts.some(x => x.id_media_object == b.id_media_object && x.type == b.type)) { a = c; return c; } else { return a; }}, 0);
                            if(userAccountRelatedProducts.reduce((a,b,c) => { if(relatedList.some(x => x.id_media_object == b.id_media_object)) { return a + (c + 1); }}, 0) != 0 || userAccountRelatedProducts.length == 0) {
                                let allResolved = false;
                                relatedList?.forEach((it, ind) => {
                                    if(userAccountRelatedProducts.filter(x => x.id_media_object == it?.id_media_object && x.type == it?.type).length == 0) {
                                        setTimeout(() => {
                                            _this.saveProductRelationInUserAccount(it.type, it.id_media_object, it.created).then((newIt) => {
                                                relatedList[ind].id = newIt.id;
                                                if(ind == lastIndex || typeof lastIndex == 'undefined') {
                                                    resolve();
                                                }
                                            });
                                        }, ind * 250);
                                    } else {
                                        if(ind == lastIndex || typeof lastIndex == 'undefined') {
                                            resolve();
                                        }
                                    }
                                });
                            } else {
                                resolve();
                            }
                        }
                    });
                }
                pushItemsToAcc().then(() => {
                    let rel = [];
                    userAccountRelatedProducts.sort((a,b) => {
                        return b.created - a.created
                    });
                    userAccountRelatedProducts = userAccountRelatedProducts.filter((a,ix) => { if(typeof rel[a.id_media_object] == 'undefined') { rel[a.id_media_object] = []; rel[a.id_media_object][a.type] = true; ; return a; } else { if(typeof rel[a.id_media_object][a.type] == 'undefined') { rel[a.id_media_object][a.type] = true; return a; } else { setTimeout(() => {_this.removeProductRelationInUserAccount(a.id)}, ix * 250); return false; } } });
                    userAccountRelatedProducts?.forEach(async (it2, ind2) => {
                        if(relatedList.filter(x => (x.id_media_object == it2.id_media_object && x.type == it2.type )).length == 0) {
                            await relatedList.push({
                                'id_media_object': it2.id_media_object,
                                'type': it2.type,
                                'created': + new Date(it2.created.date),
                                'id': it2.id
                            });
                        }
                    });
                    let visitedlist  = relatedList?.filter(x => x?.type == 'viewed');
                    let wishlist  = relatedList?.filter(x => x?.type == 'marked');
                    visitedlist.sort((a,b) => {
                        return b.created - a.created
                    });
                    visitedlist = visitedlist.slice(0, 10);
                    relatedList = wishlist.concat(visitedlist);
                    window.localStorage.setItem('relatedList', JSON.stringify(relatedList));
                    _this.renderVisitedList();
                    _this.renderWishlist();
                });
            });
        }
        this.initLoginFunctionality = function() {
            if($('.user-login').length) {
                const params = _this.getAllUrlParams();
                const redirectURL = _this.replaceUrlParam($('.login-link').attr('href'), 'redirect', btoa(location.protocol + '//' + location.host + location.pathname));
                $('.login-link').attr('href', redirectURL);

                $('.user-login .lds-dual-ring').show();
                $('.user-login .icon').hide();
                $('.loginstatus').hide();

                function renderUserData(user) {
                    if (user != null) {
                        $('.login-link').attr('href', '#profil');
                        $('.user-login .userdata .userdata-email').text(user.email_address);
                        $('.user-login .label').hide();
                        $('.login-link').unbind().click((e) => {
                            e.preventDefault();
                            $('.userdata').toggleClass('active')
                        });
                        $('.user-login').addClass('logged-in');
                        $('body').addClass('logged-in');
                        $('.user-login').removeClass('logged-out');
                        $('body').removeClass('logged-out');
                        $('.loginstatus').show();
                        $('.user-login .lds-dual-ring').hide();
                        $('.user-login .icon').show();
                    }
                }

                $.ajax({
                    url: IBEURL + '/api/external/getUserData',
                    method: 'GET',
                    xhrFields: {withCredentials: true},
                    crossDomain: true
                }).done(function (data) {
                    if (data.success) {
                        _this.matchRelatedProducts();
                        renderUserData(data.data.user);
                        // Login as Wordpress Agency User
                        if(data.data.user.is_agency) {
                            console.log('Agency logged in, login into Wordpress...');
                            $.get('/wp-content/themes/travelshop/functions/agency-login.php', function(data){
                               let response = JSON.parse(data);
                               console.log(response);
                            });
                        }
                    } else {
                        _this.renderVisitedList();
                        _this.renderWishlist();
                        $('.loginstatus').show();
                        $('.user-login .lds-dual-ring').hide();
                        $('.user-login .icon').show();
                    }
                });

                $('.logout-link').unbind().click((e) => {
                    $.ajax({
                        url: IBEURL + '/api/external/logout',
                        method: 'GET',
                        xhrFields: {withCredentials: true},
                        crossDomain: true
                    }).done(function (data) {
                        if (data.success) {
                            $('.login-link').unbind().attr('href', redirectURL);
                            if (window.innerWidth >= 1200) {
                                $('.user-login .label').show();
                            }
                            $('.user-login .userdata').removeClass('active');
                            $('.user-login').removeClass('logged-in');
                            $('body').removeClass('logged-in');
                            $('.user-login').addClass('logged-out');
                            $('body').addClass('logged-out');
                            $('.user-login').removeClass('pushTopXL');
                            $('.wishlist').removeClass('pushTopXL');
                            $('.user-login .lds-dual-ring').hide();
                            $('.user-login .icon').show();
                            $('.loginstatus').show();
                        }
                    });
                });
            }
        }
        // ====================================
        // USER/AGENCY LOGIN FUNCTIONALITY END
        // ====================================

        this.setViewedProduct = function() {
            if($('body').hasClass('pm-detail-page') && typeof currentMOID != 'undefined') {
                let relatedList = JSON.parse(window.localStorage.getItem('relatedList'));
                let wishlist  = relatedList?.filter(x => x?.type == 'marked');
                let visitedlist  = relatedList?.filter(x => x?.type == 'viewed');
                if (jQuery.isEmptyObject(visitedlist)) { visitedlist = []; }
                if (jQuery.isEmptyObject(wishlist)) { wishlist = []; }
                visitedlist = visitedlist.filter((a) => a.id_media_object != currentMOID);
                visitedlist.unshift({
                    id_media_object: currentMOID,
                    type: 'viewed',
                    created: + new Date()
                });
                visitedlist = visitedlist.slice(0, 10);
                relatedList = wishlist.concat(visitedlist);
                window.localStorage.setItem('relatedList', JSON.stringify(relatedList));
            }
        }

        this.setViewedProduct = function() {
            if($('body').hasClass('pm-detail-page') && typeof currentMOID != 'undefined') {
                let relatedList = JSON.parse(window.localStorage.getItem('relatedList'));
                let wishlist  = relatedList?.filter(x => x?.type == 'marked');
                let visitedlist  = relatedList?.filter(x => x?.type == 'viewed');
                if (jQuery.isEmptyObject(visitedlist)) { visitedlist = []; }
                if (jQuery.isEmptyObject(wishlist)) { wishlist = []; }
                visitedlist = visitedlist.filter((a) => a.id_media_object != currentMOID);
                let now = + new Date();
                visitedlist.unshift({
                    id_media_object: currentMOID,
                    type: 'viewed',
                    created: now
                });
                visitedlist = visitedlist.slice(0, 10);
                relatedList = wishlist.concat(visitedlist);
                _this.saveProductRelationInUserAccount('viewed', currentMOID, now);
                window.localStorage.setItem('relatedList', JSON.stringify(relatedList));
            }
        }

        this.init = function(){
            _this.setViewedProduct();
            _this.initLoginFunctionality();
            _this.wishlistEventListeners();
            _this.wishListInit();
            if(!window.location.href.includes('calendar')) {
                _this.pagination();
            }
            _this.searchboxSwitch();
            _this.autoCompleteInit();
            // deprecated
            //_this.dateRangePickerInit();
            //_this.priceRangeSliderInit();
            _this.initCategoryTreeSearchBarFields();
            _this.initCalendarRowClick();
            _this.initBookingBtnClickHandler();
            _this.initPartnerParams();
            _this.initModals();
            _this.searchbox();
            _this.filter();
        }

    };

    var Search = new TSAjax('/wp-content/themes/travelshop/pm-ajax-endpoint.php');
    Search.init();
});