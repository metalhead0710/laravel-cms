!(function($) {
  'use strict';

  const Socials = {
    options: {
      url: null
    },

    //main function
    init: function(options, root) {
      this.root = $(root);
      //Mix passed options with default ones
      this.options = $.extend({}, this.options, options);
      //this.deleteLink = $('a.delete');
      this.editSocial  = $('.edit-social');
      this.editSocialForm = this.root.find('#edit-social-form');
      this.editSocialModal = this.root.find('#edit-modal');

      // Bind handlers
      this.bindHandlers();
    },
    bindHandlers: function() {
      this.editSocial.on('click', (e) => {
        let row = e.currentTarget.closest('tr'),
            id = row.dataset.id;
        this.getSocial(id);
        e.preventDefault();
      });

      this.editSocialModal.on('hidden.bs.modal', () => {
        this.clearPopup();
      });
    },
    getSocial: function(id) {
      let data = {};
      $.ajax({
        type: 'get',
        url: this.options.url + '/' + id,
        success: (data) => {
          this.showModal(data);
        },
        error: function() {
          console.log('not zbs');
        }
      });
    },
    showModal: function (data) {
      this.editSocialForm.find('.id').attr('value', data.id);
      this.editSocialForm.find('.name').attr('value', data.name);
      this.editSocialForm.find('.url').attr('value', data.url);
      this.editSocialModal.find('.icon').attr('src', '/' + data.thumb);
      this.editSocialModal.find('.icon').show();
      this.editSocialModal.modal('show');
    },
    clearPopup: function() {
      this.editSocialForm.find('.id').attr('value', '');
      this.editSocialForm.find('.name').attr('value', '');
      this.editSocialForm.find('.url').attr('value', '');
      this.editSocialModal.find('.icon').attr('src', '');
      this.editSocialModal.find('.icon').hide();
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