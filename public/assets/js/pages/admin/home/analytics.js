!(function($) {
  'use strict';

  var Analytics = {
    options: {
      colors: null,
      browsers: null,
      countries: null,
      pageViews: null,
      topRefferers: null,
      users: null,
    },

    //main function
    init: function(options, root) {
      this.root = $(root);
      //Mix passed options with default ones
      this.options = $.extend({}, this.options, options);
      this.setColors(this.options.browsers);
      this.setColors(this.options.topRefferers);
      this.setColors(this.options.users);
      this.setColors(this.options.countries);
      this.ctxRefferers = document.getElementById('refferers').getContext('2d');
      this.configRefferers = {
        type: 'doughnut',
        data: {
          datasets: [{
            data: this.options.topRefferers.map(function(topRefferers) {
              return topRefferers.pageViews;
            }),
            backgroundColor: this.options.topRefferers.map(function(topRefferers) {
              var self = this;
              return topRefferers.color;
            })
          }],
          labels: this.options.topRefferers.map(function(topRefferers) {
            return topRefferers.url;
          })
        },
        options: {
          responsive: true
        }
      };
      this.ctxBrowsers = document.getElementById('pie').getContext('2d');
      this.configBrowsers = {
        type: 'pie',
        data: {
          datasets: [{
            data: this.options.browsers.map(function(browsers) {
              return browsers.sessions;
            }),
            backgroundColor: this.options.browsers.map(function(browsers) {
              return browsers.color;
            })
          }],
          labels: this.options.browsers.map(function(browsers) {
            return browsers.browser;
          })
        },
        options: {
          responsive: true
        }
      };

      this.ctxCountries = document.getElementById('countries').getContext('2d');
      this.configCountries = {
        type: 'pie',
        data: {
          datasets: [{
            data: this.options.countries.map(function(countries) {
              return parseInt(countries[1]);
            }),
            backgroundColor: this.options.countries.map(function(countries) {
              return countries.color;
            })
          }],
          labels: this.options.countries.map(function(countries) {
            return countries[0];
          })
        },
        options: {
          responsive: true
        }
      };

      this.ctxVisitors = document.getElementById('visitors').getContext('2d');
      this.configVisitors = {
        type: 'bar',
        data: {
          datasets: [{
            label: 'Кількість користувачів',
            data: this.options.pageViews.map(function(pageViews) {
              return pageViews.visitors;
            }),
            backgroundColor: '#FF9EB3',
            borderColor: '#FF6384',
            borderWidth: 1
          },{
            label: 'Кількість переглядів',
            data: this.options.pageViews.map(function(pageViews) {
              return pageViews.pageViews;
            }),
            backgroundColor: '#82CDFF',
            borderColor: '#36A2EB',
            borderWidth: 1
          }
          ],
          labels: this.options.pageViews.map(function(pageViews) {
            var date = new Date(pageViews.date.date);
            var options = {
              year: "numeric", month: "short",
              day: "numeric"
            }
            return date.toLocaleDateString("uk-UK", options);
          })
        },
        options: {
          responsive: true,
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero:true
              }
            }]
          }
        }
      };

      this.ctxUsers = document.getElementById('users').getContext('2d');
      this.configUsers = {
        type: 'horizontalBar',
        data: {
          datasets: [{
            label: 'Одиночні візити',
            data: this.options.users.map(function(users) {
              return parseInt(users[1]);
            }),
            backgroundColor: this.options.users.map(function(users) {
              return users.color;
            }),
            borderWidth: 1
          }],
          labels: ['Одиночні', 'Повторні']
        },
        options: {
          tooltips: {
            enabled: false
          },
          responsive: true,
          legend: false,
          scales: {
            xAxes: [{
              ticks: {
                beginAtZero:true
              }
            }]
          }
        }
      };
      // Bind handlers
      this.bindHandlers();
    },
    bindHandlers: function() {
      var self = this;

      this.pie = new Chart(self.ctxBrowsers, self.configBrowsers);
      this.countiesPie = new Chart(self.ctxCountries, self.configCountries);
      this.pageViews = new Chart(self.ctxVisitors, self.configVisitors);
      this.referers = new Chart(self.ctxRefferers, self.configRefferers);
      this.usr = new Chart(self.ctxUsers, self.configUsers);

    },

    getRandomColor: function() {
      let letters = '0123456789ABCDEF',
          color = '#';
      for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
      return color;
    },
    setColors: function(array) {
      for(var i = 0; i < array.length; i++){
        array[i].color = this.options.colors[i];
      }
    }

  };

  App.Page.Analytics = function(options, root) {
    root = root || $('body');
    root = $(root)[0];
    if (!$.data(root, '_Analytics')) {
      $.data(root, '_Analytics', Object.create(Analytics).init(options, root));
    }
    return $.data(root, '_Analytics');
  };
})(jQuery);

$(document).ready(function() {

});