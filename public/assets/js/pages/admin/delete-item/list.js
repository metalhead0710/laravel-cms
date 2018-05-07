!(function($) {
  'use strict';

  var Delete = {
    options: {},

    //main function
    init: function(options, root) {
      this.root = $(root);
      //Mix passed options with default ones
      this.options = $.extend({}, this.options, options);

      this.deleteBtn = $('.delete');
      // Bind handlers
      this.bindHandlers();
    },
    bindHandlers: function() {
      this.deleteBtn.on('click', function() {
        var link = $(this).closest('a.delete');
        var url = link.data('link');
        $('.delete-confirm').attr('href', url);
      });
    }
  };

  App.Page.Delete = function(options, root) {
    root = root || $('body');
    root = $(root)[0];
    if (!$.data(root, '_Delete')) {
      $.data(root, '_Delete', Object.create(Delete).init(options, root));
    }
    return $.data(root, '_Delete');
  };
})(jQuery);