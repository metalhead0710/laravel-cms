$(function() {
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
    })
});
