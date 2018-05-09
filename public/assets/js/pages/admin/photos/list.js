!(function($) {
  'use strict';

  var Photos = {
    options: {},

    //main function
    init: function(options, root) {
      this.root = $(root);
      //Mix passed options with default ones
      this.options = $.extend({}, this.options, options);

      this.addPhotosBtn = $('.add-photos');
      // Bind handlers
      this.bindHandlers();
    },
    bindHandlers: function() {
      this.addPhotosBtn.on("click", function () {
        var id = $(this).data('id');
        $('.add-photo-form .photocat-id').attr('value', id);
      });
      $('input[type=file]').filestyle({
        text : 'Виберіть файл(и)',
        badge: true,
        buttonBefore : true,
        btnClass : 'btn-primary',
        htmlIcon : '<i class="fa fa-file-image-o"></i> '
      });
    }
  };

  App.Page.Photos = function(options, root) {
    root = root || $('body');
    root = $(root)[0];
    if (!$.data(root, '_Photos')) {
      $.data(root, '_Photos', Object.create(Photos).init(options, root));
    }
    return $.data(root, '_Photos');
  };
})(jQuery);