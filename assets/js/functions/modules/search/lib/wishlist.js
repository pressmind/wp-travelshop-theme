let source = require("../../../ts-functions");
let _this = source._this;
let $ = source.$;
const resultHandlerWishlist = function (data) {

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
const renderWishlist = function() {

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

const wishlistEventListeners = function ($) {

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

const wishListInit = function ($) {
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

const wishlistRemoveElement = function (array, elem) {
    array.some(function (item) {
        if (item.id_media_object == elem) {
            var index = array.indexOf(item);
            array.splice(index, 1);
        }
    });
}
module.exports = {renderWishlist, wishlistEventListeners, wishListInit, wishlistRemoveElement, resultHandlerWishlist};
