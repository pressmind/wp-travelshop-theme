const wishlist = require("./lib/wishlist");
const search = require("./lib/search");
const user = require("./lib/userlogin");
let TSAjax = function (endpoint_url, $) {
    let _this = this;
    // IMPORT MODULES
    let basics = require('./lib/basic.js');
    let wishlist = require('./lib/wishlist.js');
    let visitedlist = require('./lib/visitedlist.js');
    let search = require('./lib/search.js');
    let user = require('./lib/userlogin.js');
    let autoCompleteInit = require('./lib/autocomplete.js');
    let checkAvailability = require('./lib/availability.js');
    let initPartnerParams = require('./lib/partnerparam.js');

    this.endpoint_url = endpoint_url;
    this.requests = new Array();

    // BASIC FUNCTIONS
    this.replaceUrlParam = basics.replaceUrlParam;
    this.updateQueryStringParam = basics.basicsupdateQueryStringParam;
    this.getAllUrlParams = basics.getAllUrlParams;
    this.oneByOneRequest = basics.oneByOneRequest;
    this.call = basics.call;
    this.theEasterDate = basics.theEasterDate;
    this.initBookingBtnClickHandler = basics.initBookingBtnClickHandler;

    // WISHLIST FUNCTIONS
    this.renderWishlist = wishlist.renderWishlist;
    this.wishlistEventListeners = wishlist.wishlistEventListeners;
    this.wishListInit = wishlist.wishListInit;
    this.wishlistRemoveElement = wishlist.wishlistRemoveElement;
    this.resultHandlerWishlist = wishlist.resultHandlerWishlist;

    // VISITEDLIST FUNCTIONS
    this.renderVisitedList = visitedlist.renderVisitedList;
    this.resultHandlerVisitedList = visitedlist.resultHandlerVisitedList;
    this.setViewedProduct = visitedlist.setViewedProduct;

    // SEARCH FUNCTIONS
    this.resultHandlerSearchBar = search.resultHandlerSearchBar;
    this.searchboxSwitch = search.searchboxSwitch;
    this.searchbox = search.searchbox;
    this.filter = search.filter;
    this.pagination = search.pagination;
    this.buildSearchQuery = search.buildSearchQuery;
    this.resultHandlerSearch = search.resultHandlerSearch;
    this.resultHandlerSearchBarStandalone = search.resultHandlerSearchBarStandalone;

    // AUTOCOMPLETE
    this.autoCompleteInit = autoCompleteInit;

    // AVAILABILITY
    this.checkAvailability = checkAvailability;

    // PARTNER PARAMS
    this.initPartnerParams = initPartnerParams;

    // USER ACCOUNT
    this.initLoginFunctionality = user.initLoginFunctionality;
    this.matchRelatedProducts = user.matchRelatedProducts;
    this.removeProductRelationInUserAccount = user.removeProductRelationInUserAccount;
    this.saveProductRelationInUserAccount = user.saveProductRelationInUserAccount;
    this.getProductRelationsInUserAccount = user.getProductRelationsInUserAccount;
    this.currentTimestampToDateString = user.currentTimestampToDateString;


    // Sets the spinner and removes the search result
    this.setSpinner = function (search_result) {
        $('.spinner').show();
        $(search_result).html('');
        $('.pagination').hide();
    }

    // Removes the spinner
    this.removeSpinner = function () {
        $('.spinner').hide();
        $('.pagination').show();
    }

    // Sets the button loader
    this.setButtonLoader = function (btn) {
        btn.find('svg:not(.always-show)').hide();
        btn.find('span:not(.btn-loader):not(.btn-loader-placeholder)').hide();
        btn.find('.loader').show();
    }

    // Removes the button loader
    this.removeButtonLoader = function (btn) {
        btn.find('svg:not(.always-show)').show();
        btn.find('span:not(.btn-loader):not(.btn-loader-placeholder)').show();
        btn.find('.loader').hide();
    }

    // Animate scroll to
    this.scrollTo = function (scrollto) {
        $('html, body').stop().animate({
            'scrollTop': $(scrollto).offset().top - $('header.affix').height()
        }, 150, 'swing');
    }

    this.init = ($) => {
        this.setViewedProduct($);
        this.initLoginFunctionality($);
        this.wishlistEventListeners($);
        this.wishListInit($);
        if(!window.location.href.includes('calendar')) {
            this.pagination($);
        }
        this.searchboxSwitch($);
        this.autoCompleteInit($);
        this.initBookingBtnClickHandler($);
        this.initPartnerParams($);
        this.searchbox($);
        this.filter($, this);
    }
};
module.exports = TSAjax;
