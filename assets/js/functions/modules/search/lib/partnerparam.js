let source = require("../../../ts-functions");
let _this = source._this;
let $ = source.$;
const initPartnerParams = function () {
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
module.exports = initPartnerParams;
