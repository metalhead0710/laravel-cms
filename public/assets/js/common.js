;(function($, window, document, undefined) {

    "use strict";
    window.App = $.extend({

        Common: {

        },

        Page: {
            _common: function() {
                $('ul.menu a').filter(function() {
                    return this.href == window.location;
                }).closest('li').addClass('active');
                $("#mainMenu").on("click", "a", null, function () {
                    $("#mainMenu").collapse('hide');
                });
            }
        },
        Helpers: {}
    }, window.App);

})(jQuery, window, document);