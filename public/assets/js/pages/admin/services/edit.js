!(function($) {
  'use strict';

  var Service = {
    options: {},

    //main function
    init: function(options, root) {
      this.root = $(root);
      //Mix passed options with default ones
      this.options = $.extend({}, this.options, options);

      // Bind handlers
      this.bindHandlers();
    },
    bindHandlers: function() {
      $('input[type=file]').filestyle({
        text: 'Виберіть файл',
        badge: true,
        buttonBefore: true,
        btnClass: 'btn-primary',
        htmlIcon: '<i class="fa fa-file-image-o"></i> '
      });
      editAreaLoader.init({
        id: 'customCss',
        syntax: 'css',
        start_highlight: true,
        min_height: 250
      });
      editAreaLoader.init({
        id: 'customJs',
        syntax: 'js',
        start_highlight: true,
        min_height: 250
      });
      CKEDITOR.replace('content');
    }
  };

  App.Page.Service = function(options, root) {
    root = root || $('body');
    root = $(root)[0];
    if (!$.data(root, '_Service')) {
      $.data(root, '_Service', Object.create(Service).init(options, root));
    }
    return $.data(root, '_Service');
  };
})(jQuery);