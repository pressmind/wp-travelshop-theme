let TSAjax = require('./modules/search/search.js');
let Search;
let _this;
let $ = jQuery;
jQuery(function ($) {
    Search = new TSAjax('/wp-content/themes/travelshop/pm-ajax-endpoint.php', $);
    Search.init($);
    _this = Search;
    module.exports = {_this, $};
});
