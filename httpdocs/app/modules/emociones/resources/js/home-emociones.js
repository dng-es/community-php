jQuery(document).ready(function(){

	$(".emociones-sel").click(function(){
		var destino = $(this).data("dest"),
		nombre_emocion = $(this).data("name");
		$("#id_emocion").val(destino);
		$("#name_emocion").val(nombre_emocion);
		$(".emociones-sel").removeClass("emociones-sel-active");
		$(this).addClass("emociones-sel-active");
	});

	$("#emocionesForm").submit(function(evento){
		$(".alert-message").html("").css("display", "none");
		var resultado_ok=true;
		if (jQuery.trim($('#id_emocion').val())==""){
			$("#emociones-alert").html("debes elegir una emoción.").fadeIn().css("display", "block");
			resultado_ok=false;
		}

		if (jQuery.trim($('#mi_emocion').val())==""){
			 $("#emociones-alert").html("debes explicar por qué te sientes así.").fadeIn().css("display", "block");
			 resultado_ok=false;
		}

		return resultado_ok;
	});
});