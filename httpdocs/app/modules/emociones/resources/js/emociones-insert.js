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
		var form_ok = true;
		$('#mi_emocion').tooltip("destroy");

		if (jQuery.trim($('#mi_emocion').val())==""){
			//$("#emociones-alert").html($('#mi_emocion').data("alert")).fadeIn().css("display", "block");
			$('#mi_emocion').tooltip({"html":true,"placement":"top", "container": "body","title": $('#mi_emocion').data("alert")}).focus();
			form_ok = false;
		}

		if (jQuery.trim($('#id_emocion').val())==""){
			//$("#emociones-alert").html($('#id_emocion').data("alert")).fadeIn().css("display", "block");
			$('#mi_emocion').tooltip({"html":true,"placement":"top", "container": "body","title": $('#id_emocion').data("alert")}).focus();
			form_ok = false;
		}

		return form_ok;
	});
});