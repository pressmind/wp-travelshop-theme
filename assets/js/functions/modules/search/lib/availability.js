let _this, $ = require("../../../ts-functions");
const checkAvailability = function (id_offer, quantity, booking_btn){
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
module.exports = checkAvailability;
