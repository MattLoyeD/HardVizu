
$base_url = $('input[name="base_url"]').val();

$(document)
.on('click','.btn-zone .remove',function(e){
	e.preventDefault();
	$.post($base_url+'index.php?f'+$(this).data('path'));
	$(this).closest('thumbs').fadeOut(300);
})
; 

$('.thumb_list').masonry({
    itemSelector: '.thumbs',
    columnWidth: 200
});
