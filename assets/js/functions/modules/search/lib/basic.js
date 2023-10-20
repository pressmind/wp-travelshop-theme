let _this, $ = require("../../../ts-functions");
const call = function (query_string, scrollto, total_result_span_id, callback, target, $, _this) {
    this.oneByOneRequest();
    this.requests.push($.ajax({
        url: this.endpoint_url + '?' + query_string,
        method: 'GET',
        data: null
    }).done(function (data) {
        callback(data, query_string, scrollto, total_result_span_id, $, _this);
    }));
}
const getAllUrlParams = function(url) {

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
const oneByOneRequest = function (){
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
const replaceUrlParam = function(url, paramName, paramValue)
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
const updateQueryStringParam = function(key, value) {
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
const theEasterDate = function (Y) {
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
const initBookingBtnClickHandler = function ($){
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
module.exports = {replaceUrlParam, updateQueryStringParam, getAllUrlParams, oneByOneRequest, call, theEasterDate, initBookingBtnClickHandler};
