jQuery(document).ready(function(){
	CargarComentarios($("#id_file").val());

	function CargarComentarios(id){
		$("#respuestas-textos").load("app/modules/fotos/pages/gallery_process.php?idf=" + id);
	}

	$("#form-comentario-fotos").submit(function(event) {
		/* Validaciones */
		$(".alert-message").html("").css("display","none");

		var form_ok = true;   
		if (jQuery.trim($("#respuesta-texto").val()) == ""){
			$("#respuesta-alert").html("Debes intruducir algo de texto.")
							.fadeIn()
							.css("display","block");
			form_ok = false;
		}

		if (form_ok){
			$.ajax({
				type: 'POST',
				url: 'app/modules/fotos/pages/gallery_process.php',
				data: $('#form-comentario-fotos').serialize(),
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					$('#respuestas-result').html("Comentario insertado").show();
					var idf = $("#id_file").val();
					$("#respuesta-texto").val("");
					CargarComentarios(idf);
				}
			})
		}

		return false;
	});

	$(".modal-img-container img").click(function(event){
		var ruta = $(this).attr("src"),
			titulo = $(this).attr("title"),
			id_file = $(this).attr("data-id"),
			fecha = $(this).attr("data-fecha"),
			nick = $(this).attr("data-nick"),
			votaciones = $(this).attr("data-votaciones");

		$("#modal-img-main").attr("src",ruta);
		$("#modal-img-main").attr("title",titulo);
		$("#modal-img-main").closest("a").attr("href",ruta);
		$("#image-titulo").html(titulo);
		$("#image-fecha").html(fecha);
		$("#image-nick").html(nick);
		$("#image-id").html(id_file);
		$("#image-votaciones").html(votaciones);
		$(".trigger-votar").attr({"data-id":id_file}).html(" " + votaciones);
		$(".alert-votacion").html("");
		$("#id_file").val(id_file);

		$("#respuestas-result").css("display","none");
		CargarComentarios(id_file);

	});

	$(".trigger-votar").click(function(event){
		event.preventDefault();
		var id = $(this).attr("data-id"),
			contador = parseInt($(".trigger-votar").html());

		$.ajax({
			type: "POST",
			url: "app/modules/fotos/pages/gallery_process.php",
			data: {"idv": id},
			success: function(data) {
				var msg = "error";
				
				if (data == 1){
					msg = "Votación realizada con éxito.";
					$(".trigger-votar").html(" " + (contador + 1));
					$("#img-mini"+id).attr("data-votaciones", (contador + 1));
				}
				else if (data == 2){
					msg = "Ya has votado esta foto.";
				}
				else if (data == 3){
					msg = "No puedes votar tus propias fotos.";
				}

				$(".alert-votacion").html(msg);
			}
		});
	});
});