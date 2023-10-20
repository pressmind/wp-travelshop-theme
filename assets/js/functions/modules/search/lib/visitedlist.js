let source = require("../../../ts-functions");
let _this = source._this;
let $ = source.$;
const resultHandlerVisitedList = function (data) {

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

const renderVisitedList = function() {

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
const setViewedProduct = function($) {
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
module.exports = {renderVisitedList, resultHandlerVisitedList, setViewedProduct};
