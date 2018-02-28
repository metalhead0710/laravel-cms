$(function() {
    var url=document.location.href;
    $.each($('.sidebar-menu a'),function(){
        if(this.href==url) {
            $(this).closest("li").addClass("active");
            $(this).closest('.treeview').addClass('active');
            $(this).closest('.treeview').addClass('menu-open');
            $(this).closest('.treeview-menu').show();
        }
    });
});