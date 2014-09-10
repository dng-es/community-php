jQuery(document).ready(function(){
	$(".abrir-modal").click(function(event) {
		event.preventDefault()
		var srcimage = $(this).attr("data-img");
		$("#modal-images .modal-body img").attr("src","docs/fotos/" + srcimage)
		$("#modal-images").modal();
	});
});