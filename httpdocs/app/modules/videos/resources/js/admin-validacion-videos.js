jQuery(document).ready(function(){
	$(".abrir-modal").click(function(event){
		event.preventDefault()
		$(this).next("div .modal").modal();
	});

	$(".trigger-validar").click(function(event){
		event.preventDefault();
		var id_file = $(this).attr("data-id"),
			tags = $("#tipo_video_" + id_file).val(),
			u = $(this).attr("data-u"),
			f = $(this).attr("data-f");

		Confirma('¿Seguro que deseas validar el vídeo?', 'admin-validacion-videos?act=video_ok&id=' + id_file + '&f='+ f +'&u='+ u +"&tags=" + tags);

	});
	
});