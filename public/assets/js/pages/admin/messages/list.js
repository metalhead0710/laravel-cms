!(function($) {
  'use strict';

  var Messages = {
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
      var self = this;
      $('.ids').on('change', function() {
        if (this.checked) {
          $('.btn-group').show(50);
        }
        if ($('.ids:checked').length == 0) {
          $('.btn-group').hide(50);
        }
      });
      $(".mark-as-read").click(function(){
        var url = $(this).data('url');
        self.addLinkAndSubmit(url);
      });
      $(".delete").click(function(){
        var url = $(this).data('url');
        self.addLinkAndSubmit(url);
      });
      $('table td').on('click', function(e) {
        if (!$(e.target).closest('.ids').length) {
          var row = $(this).closest('tr'),
              id = row.data('id');
          $.ajax({
            url: "/dominator/messages/view/"+id,
            type: "get",
            success: function(data){
              if(data == 0){
                $(".button-more").hide();
                console.log("Error");
              }else{
                $('#message-modal').modal('show');
                $('#message-modal .sendname').html(data.sendname);
                $('#message-modal .email').html(data.email);
                $('#message-modal .time').html(data.created_at);
                $('#message-modal .content').html(data.content);
                var counter = $('.badge-info').html() -1;
                if(counter > 0) {
                  $('.badge-info').html(counter);
                } else {
                  $('.badge-info').remove();
                }
                row.remove();
              }
            }
          });
        }
      });
      $('[data-toggle="tooltip"]').tooltip({
        'delay': { show: 3000, hide: 50 }
      });
    },
    addLinkAndSubmit: function(url) {
      $('.form-messages').attr("action", url);
      $(".form-messages").submit();
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