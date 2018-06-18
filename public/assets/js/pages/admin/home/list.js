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

      // Bind handlers
      this.bindHandlers();
    },
    bindHandlers: function() {
      var self = this;

      $('#period').on("change", function () {
        var startDate = $("#period").val();
        self.showLoad();
        self.sendRequest(startDate);
      });
      $('.date').datepicker({
        autoclose:true,
        endDate: '+0d',
        language: 'uk'
      });
      this.sendRequest();
    },
    sendRequest: function( date = null) {
      var self = this;
      $.ajax({
        type: 'post',
        url: this.options.url,
        data: { period: date, _token: this.options.token},
        dataType: 'html',
        success: function(responce) {
          $('#stats').html(responce);
          self.hideLoad();
        },
        error: function() {
          alert("Сталася якась поєбень");
        }
      });
    },
    hideLoad: function() {
      $('.loading').hide();
    },
    showLoad: function() {
      $('.loading').show();
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