!(function($) {
  'use strict';

  var Socials = {
    options: {
      url: null
    },

    //main function
    init: function(options, root) {
      this.root = $(root);
      //Mix passed options with default ones
      this.options = $.extend({}, this.options, options);
      this.deleteLink = $('a.delete');
      this.editSocial  = $('.edit-social');

      // Bind handlers
      this.bindHandlers();
    },
    bindHandlers: function() {
      var self = this;
      $('input[type=file]').filestyle({
        text : 'Виберіть файл(и)',
        badge: true,
        buttonBefore : true,
        btnClass : 'btn-primary',
        htmlIcon : '<i class="fa fa-file-image-o"></i> '
      });

      this.deleteLink.on("click", function () {
        var	url = $(this).data("link");
        $('.delete-confirm').attr("href", url);
      });

      this.editSocial.on('click', function(e) {
        var row = $(this).closest('tr'),
            id = row.data('id');
        self.getSocial(id);
        e.preventDefault();
      });

      $('#edit-modal').on('hidden.bs.modal', function() {
        $('#edit-social-form .id').attr('value', '');
        $('#edit-social-form .name').attr('value', '');
        $('#edit-social-form .url').attr('value', '');
        $('#edit-modal .icon').attr('src', '');
        $('#edit-modal .icon').hide();
      });
    },
    getSocial: function(id) {
      var data = {};
      $.ajax({
        type: 'get',
        url: this.options.url + '/' + id,
        success: function(data) {
          $('#edit-social-form .id').attr('value', data.id);
          $('#edit-social-form .name').attr('value', data.name);
          $('#edit-social-form .url').attr('value', data.url);
          $('#edit-modal .icon').attr('src', '/' + data.thumb);
          $('#edit-modal .icon').show();
          $('#edit-modal').modal('show');
        },
        error: function() {
          console.log('not zbs');
        }
      });
    }
  };

  App.Page.Socials = function(options, root) {
    root = root || $('body');
    root = $(root)[0];
    if (!$.data(root, '_Socials')) {
      $.data(root, '_Socials', Object.create(Socials).init(options, root));
    }
    return $.data(root, '_Socials');
  };
})(jQuery);