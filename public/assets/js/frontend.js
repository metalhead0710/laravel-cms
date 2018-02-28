
    var url = window.location;
    var element = $('ul.menu a').filter(function() {
        return this.href == url;
    }).closest('li').addClass('active');

