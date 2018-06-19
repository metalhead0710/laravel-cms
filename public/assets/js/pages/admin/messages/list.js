!(function($) {
  'use strict';

  let Messages = {
    options: {
      newMsgUrl: null
    },

    //main function
    init: function(options, root) {
      this.root = $(root);
      //Mix passed options with default ones
      this.options = $.extend({}, this.options, options);

      this.checksBoxes = this.root.find('.ids');
      this.deleteMassive = this.root.find('.btn-group');
      this.deleteOne = this.root.find('.delete');
      this.markAsReadBtn = this.root.find('.mark-as-read');
      this.popup = this.root.find('#message-modal');
      this.badge = this.root.find('.badge-info');

      // Bind handlers
      this.bindHandlers();
    },
    bindHandlers: function() {
      this.checksBoxes.on('change', () => {
        let checksCount = $(":checkbox:checked").length;
        if (checksCount) {
          this.deleteMassive.show(50);
        } else {
          this.deleteMassive.hide(50);
        }
      });

      this.markAsReadBtn.click( (e) => {
        //let url = e.target.attributes.getNamedItem('data-url').value;
        let url = e.currentTarget.dataset.url;
        this.addLinkAndSubmit(url);
      });

      this.deleteOne.click( (e) => {
        let url = e.currentTarget.dataset.url;
        this.addLinkAndSubmit(url);
      });
      $('table td').on('click', (e) => {
        if (!$(e.target).closest('.ids').length) {
          const row = e.currentTarget.closest('tr'),
                id = row.dataset.id;
          this.getMessage(row, id);
        }
      });
      $('[data-toggle="tooltip"]').tooltip({
        'delay': { show: 3000, hide: 50 }
      });
    },
    addLinkAndSubmit: function(url) {
      $('.form-messages').attr("action", url);
      $(".form-messages").submit();
    },
    getMessage: function (row, id) {
      $.ajax({
        url: `/dominator/messages/view/${id}`,
        type: "get",
        success: (data) => {
          if(data == 0){
            $(".button-more").hide();
            console.log("Error");
          }else{
            this.showMessage(data);
            this.updateInfo(row);
          }
        }
      });
    },
    showMessage: function(data) {
      this.popup.modal('show');
      this.popup.find('.sendname').html(data.sendname);
      this.popup.find('.email').html(data.email);
      this.popup.find('.time').html(data.created_at);
      this.popup.find('.content').html(data.content);
    },
    updateInfo: function(row) {
      let counter = this.badge.html() -1;
      $(row).find('.badge').remove();
      if(counter > 0) {
        this.badge.html(counter);
      } else {
        this.badge.remove();
      }
      if (this.options.newMsgUrl) {
        row.remove();
      }
    }

  };

  App.Page.Messages = function(options, root) {
    root = root || $('body');
    root = $(root)[0];
    if (!$.data(root, '_Messages')) {
      $.data(root, '_Messages', Object.create(Messages).init(options, root));
    }
    return $.data(root, '_Messages');
  };
})(jQuery);

$(document).ready(function() {

});