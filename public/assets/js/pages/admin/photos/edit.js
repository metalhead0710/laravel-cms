!(function($) {
  'use strict';

  const PhotoList = {
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
      this.photoItem = this.root.find('.box-item');
      this.deleteLink = this.root.find('.delete-link');
      this.deleteMassive = this.root.find('.submit-btn')
      this.sortPopup = this.root.find('.sort-popup');
      this.deleteOne = this.root.find('.delete-one');
      this.form = this.root.find('.forma');
      this.sortableBox = this.root.find('.box');

      // Bind handlers
      this.bindHandlers();
    },
    bindHandlers: function() {
      $('input[type=file]').filestyle({
        text : 'Виберіть файл(и)',
        badge: true,
        buttonBefore : true,
        btnClass : 'btn-primary',
        htmlIcon : '<i class="fa fa-file-image-o"></i> '
      });

      this.photoItem.hover(function() {
        let id = $(this).data("id");
        $('div[data-id='+id+'] div').slideDown(200);
      });

      this.photoItem.mouseleave(function() {
        let id = $(this).data("id");
        $('div[data-id='+id+'] div').slideUp(200);
      });

      this.deleteLink.on("click", (e) => {
        let url = e.currentTarget.dataset.deletelink;
        this.deleteOne.attr("href", url);
      });

      this.form.find(':checkbox').change( () => {
        let checksCount = $(":checkbox:checked").length;
        if (checksCount) {
          this.deleteMassive.show(50);
        } else {
          this.deleteMassive.hide(50);
        }
      });

      this.deleteMassive.click( () => {
        this.form.submit();
      });

      this.sortableBox.sortable({
        helper: this.fixHelperModified,
        stop:  (e, ui) => {
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
      this.photoItem.each(function(elem) {
        // TODO: fix a bug with wrong values collected
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

    updateIndex: function() {
      $('.box-item').each(function(i) {
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
          // TODO: fix a bug with popup
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
        url: '/dominator/getPopupMsg/' + res,
        data: data,
        dataType: 'html',
        success: data => {
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

  App.Page.PhotoList = function(options, root) {
    root = root || $('body');
    root = $(root)[0];
    if (!$.data(root, '_PhotoList')) {
      $.data(root, '_PhotoList', Object.create(PhotoList).init(options, root));
    }
    return $.data(root, '_PhotoList');
  };
})(jQuery);