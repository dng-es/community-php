// JavaScript Document
jQuery(document).ready(function(){
	$("#coment-submit").click(function(evento){
		$("#texto-comentario-alert").html("").css("display", "none");
		var form_ok = true;
		if (jQuery.trim($('#texto-comentario').val()) == ""){
			$("#texto-comentario-alert").html("Debes insertar algo de texto en el comentario.").fadeIn().css("display", "block");
			form_ok = false;
		}
		if (document.getElementById('texto-comentario').value.length > 160){
			$("#texto-comentario-alert").html("Has superado el límite de caracteres. Máximo 160 caracteres.").fadeIn().css("display", "block");
			form_ok = false;
		}
		if (form_ok == true){
			$("#coment-form").submit();
		}
	});
});