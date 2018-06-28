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
      this.banners = this.root.find('.banner-list li');
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
      let vals = [];
      for(let banner of this.banners) {
         let value = {
          id: banner.dataset.id,
          sort: banner.dataset.sort
        };
        vals.push(value);
      }

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
    updateIndex: function() {
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
        success: (responce) => {
          this.getFlashMsg(responce.res);
          this.hideSaveButton();
        },
        error: () => {
          this.getFlashMsg(0);
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
          this.sortPopup.show(300);
          setTimeout( () => {
            this.sortPopup.html('');
          } , 1500);

          /*this.sortPopup.fadeTo(1000, 500).slideUp(500, () => {
            this.sortPopup.slideUp(500);
          });*/
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