!(function ($) {
    "use strict";

    var Home = {

        options: {
            test: null
        },

        //main function
        init: function (options, root) {

            this.root = $(root);
            //Mix passed options with default ones
            this.options = $.extend({}, this.options, options);
            this.navMain = $("#mainMenu");

            this.header1 = $('h1');
            this.header4 = $('h4');
            this.parentBlock = $('.parent-block');
            this.tiles = $('.tiles');
            // Bind handlers
            this.bindHandlers();
            this.makeTestClass(this.options.test);
        },

        bindHandlers: function () {
            this.header1.slideDown(1500);
            this.header4.slideDown(1500);
            this.parentBlock.show(1500);
            this.tiles.on( 'mouseenter click', '[data-toggle="tab"]', function () {
                $(this).tab('show');
            });
        },
        makeTestClass: function (className) {
            this.root.addClass(className);
        }
    };

    App.Page.Home = function (options, root) {
        root = root || $("body");

        root = $(root)[0];
        if (!$.data(root, "_Home")) {
            $.data(root, "_Home", Object.create(Home).init(options, root));
        }
        return $.data(root, "_Home");
    };
})(jQuery);