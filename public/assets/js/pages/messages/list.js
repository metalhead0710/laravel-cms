$(document).ready(function() {
    $('.ids').on('change', function() {
        if (this.checked) {
            $('.btn-group').show(50);
        }
        if ($('.ids:checked').length == 0) {
            $('.btn-group').hide(50);
        }
    });
    $(".mark-as-read").click(function(){
        var url = $(this).data('url');
        addLinkAndSubmit(url);
    });
    $(".delete").click(function(){
        var url = $(this).data('url');
        addLinkAndSubmit(url);
    });
    var addLinkAndSubmit = function(url) {
        $('.form-messages').attr("action", url);
        $(".form-messages").submit();
    }
    $('table td').on('click', function(e) {
        if (!$(e.target).closest('.ids').length) {
        var id = $(this).closest('tr').data('id');
        $.ajax({
            url: "/admin/messages/view/"+id,
            type: "get",
            success: function(data){
                if(data == 0){
                    $(".button-more").hide();
                    console.log("Error");
                }else{
                    $('#message-modal').modal('show');
                    $('#message-modal .sendname').html(data.sendname);
                    $('#message-modal .email').html(data.email);
                    $('#message-modal .time').html(data.created_at);
                    $('#message-modal .content').html(data.content);
                }
            }
        });
        }
    });
    $('[data-toggle="tooltip"]').tooltip({
        'delay': { show: 3000, hide: 50 }
    });
});