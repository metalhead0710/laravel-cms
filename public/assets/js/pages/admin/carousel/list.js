!(function($) {
  'use strict';

  let Carousel = {
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
      this.sortPopup = this.root.find('.sort-popup');

      // Bind handlers
      this.bindHandlers();
    },

    bindHandlers: function() {
      $('.banner-list').sortable({
        helper: this.fixHelperModified,
        stop: (e, ui) => {
          this.updateIndex(e, ui);
          this.showSaveButton();
        }
      }).disableSelection();

      this.saveOrderButton.on('click', (e) => {
        let data = this.collectSortState();
        this.sortOut(data, this.options.url, this.options.token);
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
      let vals = [],
          value = {};
      $('.banner-list li').each(function() {
        let id = $(this).data('id'),
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
      $.ajax({
        type: 'post',
        url: url,
        data: {ids: data, _token: token},
        dataType: 'json',
        success: () => {
          this.getFlashMsg(true);
          this.hideSaveButton();
        },
        error: () => {
          this.getFlashMsg(false);
        }
      });
    },
    getFlashMsg: function(res) {
      let data = {};
      $.ajax({
        type: 'get',
        url: `/dominator/getPopupMsg/${res}`,
        data: data,
        dataType: 'html',
        success: (data) => {
          this.sortPopup.html(data);
          this.sortPopup.fadeTo(1000, 500).slideUp(500, () => {
            this.sortPopup.slideUp(500);
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