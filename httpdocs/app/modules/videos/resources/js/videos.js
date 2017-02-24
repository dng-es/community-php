// JavaScript Document
jQuery(document).ready(function(){
	$('#nombre-video').bootstrapFileInput();
	$(".tooltip-bottom").tooltip({placement:"bottom"});

	$("#video-form").submit(function(evento){
		$("#alertas-participa").css("display", "none");

		var form_ok = true;
		if (jQuery.trim($("#titulo-video").val()) == ""){
			form_ok = false;
		}

		if (jQuery.trim($("#nombre-video").val()) == ""){
			form_ok = false;
		}

		if (form_ok !== true){
			$("#alertas-participa").fadeIn().css("display", "block");
		}
		else $("#cargando").show();
		
		return form_ok;

	});

	$("#form-video-comment").submit(function(){
		$(".alert-message").css("display", "none");
		var form_ok = true; 

		if (jQuery.trim($("#video-comentario").val()) == ""){
			form_ok = false;
		}

		if (form_ok !== true){
			$("#video-comentario-alert").fadeIn().css("display", "block");
			return false;
		}
	});
});