// JavaScript Document
jQuery(document).ready(function(){	
	$(".new-message").click(function(e){
		e.preventDefault();
		$("#nick-comentario").val($(this).data('n'));
		$("#new_mensaje").modal();
	});
});