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
			tags = $("#tipo_foto_" + id_file).val();

		document.location.href = 'admin-albumes-new?idf=' + id_file + '&id=' + id_album + '&tags=' + tags;
	});
	
	$("#form-album").submit(function(event){
		var resultado_ok = true;
		if ($("#canal_album").removeClass("input-alert").val() == null){
			$("#form-album").find("[data-id='canal_album']").addClass("input-alert");
			resultado_ok = false;
		}	
		return resultado_ok;
	});
});