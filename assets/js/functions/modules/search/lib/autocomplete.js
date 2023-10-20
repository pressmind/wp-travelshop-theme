let source = require("../../../ts-functions");
let _this = source._this;
let $ = source.$;
const autoCompleteInit = function ($){
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
module.exports = autoCompleteInit;
