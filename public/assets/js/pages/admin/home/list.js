!(function($) {
  'use strict';

  var Dashboard = {
    options: {
      url: null,
      token: null
    },

    //main function
    init: function(options, root) {
      this.root = $(root);
      //Mix passed options with default ones
      this.options = $.extend({}, this.options, options);

      this.periodForm = this.root.find('#period');
      this.statsBlock = this.root.find('#stats');
      this.loading = this.root.find('.loading');

      // Bind handlers
      this.bindHandlers();
    },
    bindHandlers: function() {
      this.periodForm.on("change", () => {
        let startDate = this.periodForm.val();
        this.showLoad();
        this.sendRequest(startDate);
      });
      $('.date').datepicker({
        autoclose:true,
        endDate: '+0d',
        language: 'uk'
      });
      this.sendRequest();
    },
    sendRequest: function( date = null) {
      $.ajax({
        type: 'post',
        url: this.options.url,
        data: { period: date, _token: this.options.token},
        dataType: 'html',
        success: (responce) => {
          this.statsBlock.html(responce);
          this.hideLoad();
        },
        error: function() {
          alert("Сталася якась поєбень");
        }
      });
    },
    hideLoad: function() {
      this.loading.hide();
    },
    showLoad: function() {
      this.loading.show();
    }
  };

  App.Page.Dashboard = function(options, root) {
    root = root || $('body');
    root = $(root)[0];
    if (!$.data(root, '_Dashboard')) {
      $.data(root, '_Dashboard', Object.create(Dashboard).init(options, root));
    }
    return $.data(root, '_Dashboard');
  };
})(jQuery);

$(document).ready(function() {

});