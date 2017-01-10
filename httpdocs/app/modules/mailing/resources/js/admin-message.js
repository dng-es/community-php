// JavaScript Document
jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();

	$("#formData").submit(function(evento){
		$(".alert-message").html("").css("display", "none");
		var resultado_ok = true;

		if (jQuery.trim($("#nombre_message").val()) == ""){
			$("#nombre-alert").html("Debes insertar algo de texto.").fadeIn().css("display", "block");
			resultado_ok = false;
		}
		if (jQuery.trim($("#asunto_message").val()) == ""){
			$("#asunto-alert").html("Debes insertar algo de texto.").fadeIn().css("display", "block");
			resultado_ok = false;
		}	
		if (jQuery.trim($("#texto_message").val()) == ""){
			$("#texto-alert").html("Debes insertar algo de texto.").fadeIn().css("display", "block");
			resultado_ok = false;
		}
		if (jQuery.trim($("#template_message").val()) == ""){
			$("#template-alert").html("Debes seleccionar una plantilla.").fadeIn().css("display", "block");
			resultado_ok = false;
		}
		if (validateEmail($("#email_message").val()) == false){
			$("#email-alert").html("Debes insertar un email válido.").fadeIn().css("display", "block");
			resultado_ok = false;
		}
		if ($("#lista_tienda:checked").val() == "lista tienda" && $("#lista_tienda_sel").val() == ""){
			$("#tienda-alert").html("Debes seleccionar una tienda.").fadeIn().css("display", "block");
			resultado_ok = false;
		}
		if ($("#lista_tienda_tipo:checked").val() == "lista tienda tipo" && $("#lista_tienda_tipo_sel").val() == ""){
			$("#tienda-tipo-alert").html("Debes seleccionar una tipo de tienda.").fadeIn().css("display", "block");
			resultado_ok = false;
		}
		if ($("#lista_curso:checked").val() == "lista curso" && $("#lista_curso_sel").val() == ""){
			$("#curso-alert").html("Debes seleccionar un curso.").fadeIn().css("display", "block");
			resultado_ok = false;
		}	
		if ($("#lista_usuarios:checked").val() == "lista usuarios" && jQuery.trim($("#lista_users").val()) == ""){
			$("#lista-users-alert").html("Debes introducir algún usuario.").fadeIn().css("display", "block");
			resultado_ok = false;
		}

		return resultado_ok;
	});
});