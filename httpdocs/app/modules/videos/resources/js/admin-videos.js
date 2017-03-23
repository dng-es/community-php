jQuery(document).ready(function(){
	$(".abrir-modal").click(function(event){
		event.preventDefault()
		var srcimage = $(this).attr("data-img");
		$("#modal-images .modal-body img").attr("src", "docs/fotos/" + srcimage)
		$("#modal-images").modal();
	});
	
	$(".trigger-tags").click(function(event){
		event.preventDefault();
		var id_file = $(this).attr("data-id"),
			id_album = $(this).attr("data-album"),
			pag = $(this).attr("data-pag"),
			tags = $("#tipo_video_" + id_file).val();
			destacado = $("#destacado_video_" + id_file).is(":checked") ? 1 : 0;

		document.location.href = 'admin-videos?idf=' + id_file + '&dest=' + destacado + '&tags=' + tags + '&pag=' + pag;
	});
});