!(function($) {
  'use strict';

  var CommonIndexFunctions = {
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
        let link = $(this).closest('a.delete'),
            url = link.data('link');
        $('.delete-confirm').attr('href', url);
      });
      $('input[type=file]').filestyle({
        text : 'Виберіть файл',
        badge: true,
        buttonBefore : true,
        btnClass : 'btn-primary',
        htmlIcon : '<i class="fa fa-file-image-o"></i> '
      });
    }
  };

  App.Page.CommonIndexFunctions = function(options, root) {
    root = root || $('body');
    root = $(root)[0];
    if (!$.data(root, '_CommonIndexFunctions')) {
      $.data(root, '_CommonIndexFunctions', Object.create(CommonIndexFunctions).init(options, root));
    }
    return $.data(root, '_CommonIndexFunctions');
  };
})(jQuery);