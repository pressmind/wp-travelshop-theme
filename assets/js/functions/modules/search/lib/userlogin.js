let source = require("../../../ts-functions");
let _this = source._this;
let $ = source.$;
// ====================================
// USER/AGENCY LOGIN FUNCTIONALITY START
// ====================================
const currentTimestampToDateString = function(timestamp) {
    const currentDate = new Date(timestamp);
    const currentDayOfMonth = String(currentDate.getDate()).padStart(2, '0');
    const currentMonth = String(currentDate.getMonth() + 1).padStart(2, '0'); // Be careful! January is 0, not 1
    const currentYear = currentDate.getFullYear();
    const currentHour = String(currentDate.getHours()).padStart(2, '0');
    const currentMinute = String(currentDate.getMinutes()).padStart(2, '0');
    const currentSeconds = String(currentDate.getSeconds()).padStart(2, '0');
    return currentYear + '-' + currentMonth + '-' + currentDayOfMonth + ' ' + currentHour + ':' + currentMinute + ':' + currentSeconds;
}
const saveProductRelationInUserAccount = function(type, id, timestamp) {
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
const removeProductRelationInUserAccount = function(id) {
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
const getProductRelationsInUserAccount = function () {
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
const matchRelatedProducts = function() {
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
const initLoginFunctionality = function($) {
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
module.exports = {initLoginFunctionality, matchRelatedProducts, removeProductRelationInUserAccount, saveProductRelationInUserAccount, getProductRelationsInUserAccount, currentTimestampToDateString};
