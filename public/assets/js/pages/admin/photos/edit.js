!(function($) {
  'use strict';

  var PhotoList = {
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
      this.photoItem = $('.box-item');

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
      $('.box-item').hover(function() {
        var id = $(this).data("id");
        $('div[data-id='+id+'] div').slideDown(200);
      });
      $('.box-item').mouseleave(function() {
        var id = $(this).data("id");
        $('div[data-id='+id+'] div').slideUp(200);
      });
      $('.delete-link').on("click", function () {
        var	url = $(this).data("deletelink");
        $('.delete-one').attr("href", url);
      });
      $('.forma :checkbox').change(function() {
        if (this.checked) {
          $('.submit-btn').show(50);
        }
      });
      $(".submit-btn").click(function(){
        $(".forma").submit();
      });

      $('.box').sortable({
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
      $('.box-item').each(function() {
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
      $('.box-item').each(function(i) {
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
          alert('Відсортовано!');
          self.hideSaveButton();
        },
        error: function() {
          alert('Помилка сервера. Спробуйте папіжже');
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