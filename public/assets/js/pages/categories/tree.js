$(function () {
	function toggleIcon(e) 
	{
	    $(e.target)
	        .prev('.panel-heading')
	        .find(".more-less")
	        .toggleClass('fa-plus fa-minus');
	}
	
	$('.panel-group').on('hidden.bs.collapse', toggleIcon);
	$('.panel-group').on('shown.bs.collapse', toggleIcon);
	
	$('.add-parent').on('click', function(){
		var parentId = $(this).closest("a.add-parent").data("parent-id") || 0;
        $('.parent-id-modal').attr("value", parentId);
	});
	$('.update').on('click', function(){
		var id = $(this).closest("a.update").data("id");
		var category = $(this).closest('a.update').data('name');
        $('.id-modal').attr("value", id);
        $('.category-name').attr("value", category);
	});	
	$('.delete').on("click", function () {
        var id = $(this).closest("a.delete").data("id");
		$('.id-modal').attr("value", id);
    });		
});