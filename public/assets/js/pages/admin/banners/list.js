!(function($) {
  'use strict';

  var Carousel = {
    options: {
      url: null,
      token: null
    },

    //main function
    init: function(options, root) {
      this.root = $(root);
      //Mix passed options with default ones
      this.options = $.extend({}, this.options, options);

      this.saveOrderButton = $('.save-order');
      this.bannerItem = $('.banner-list li');
      this.deleteBtn = $('.delete');

      // Bind handlers
      this.bindHandlers();
    },

    bindHandlers: function() {
      var self = this;
      $('input[type=file]').filestyle({
        text: 'Виберіть файл',
        badge: true,
        buttonBefore: true,
        btnClass: 'btn-primary',
        htmlIcon: '<i class="fa fa-file-image-o"></i> '
      });

      this.deleteBtn.on('click', function() {
        var link = $(this).closest('a.delete');
        var url = link.data('link');
        $('.delete-confirm').attr('href', url);
      });

      $('.banner-list').sortable({
        helper: this.fixHelperModified,
        stop: function(e, ui) {
          self.updateIndex(e, ui);
          self.showSaveButton();
        }
      }).disableSelection();
      this.saveOrderButton.on('click', function(e) {
        var data = self.collectSortState();
        self.sortOut(data, self.options.url, self.options.token);
        e.preventDefault();
      });
    },
    showSaveButton: function() {
      this.saveOrderButton.show();
    },
    hideSaveButton: function() {
      this.saveOrderButton.hide();
    },
    collectSortState: function() {
      var vals = [],
          value = {};
      $('.banner-list li').each(function() {
        var id = $(this).data('id'),
            sort = $(this).data('sort');
        value = {
          id: id,
          sort: sort
        };
        vals.push(value);
      });
      return vals;
    },
    fixHelperModified: function(e, ul) {
      var $originals = ul.children();
      var $helper = ul.clone();
      $helper.children().each(function(index) {
        $(this).width($originals.eq(index).width());
      });
      return $helper;
    },
    updateIndex: function(e, ui) {
      $('.banner-list li').each(function(i) {
        $(this).attr('data-sort', i + 1);
      });
    },
    sortOut: function(data, url, token) {
      var self = this;
      $.ajax({
        type: 'post',
        url: url,
        data: {ids: data, _token: token},
        dataType: 'json',
        success: function() {
          self.getFlashMsg(1);
          self.hideSaveButton();
        },
        error: function() {
          self.getFlashMsg(0);
        }
      });
    },
    getFlashMsg: function(res) {
      var self = this,
          data = {};
      $.ajax({
        type: 'get',
        url: '/dominator/getPopupMsg/' + res,
        data: data,
        dataType: 'html',
        success: function(data) {
          $('.sort-popup').html(data);
          $('.sort-popup').fadeTo(1000, 500).slideUp(500, function(){
            $('.sort-popup').slideUp(500);
          });
        },
        error: function() {
          console.log("Сталася фігня... соррі.");
        }
      });
    }
  };

  App.Page.Carousel = function(options, root) {
    root = root || $('body');
    root = $(root)[0];
    if (!$.data(root, '_Carousel')) {
      $.data(root, '_Carousel', Object.create(Carousel).init(options, root));
    }
    return $.data(root, '_Carousel');
  };
})(jQuery);