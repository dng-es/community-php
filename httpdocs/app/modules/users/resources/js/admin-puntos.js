// JavaScript Document
jQuery(document).ready(function(){
	$("#num_puntos").numeric();
	
	$("#formData").submit(function(){
		$(".alert-message").html("").css("display","none");
		var form_ok = true;
		if (jQuery.trim($("#id_usuario").removeClass("input-alert").val()) == ""){
			$('#id_usuario').addClass("input-alert").attr("placeholder", $('#id_usuario').data("alert")).focus();
			form_ok = false;
		}

		if (isNaN(jQuery.trim($("#num_puntos").removeClass("input-alert").val()))){
			$('#num_puntos').addClass("input-alert").attr("placeholder", $('#num_puntos').data("alert")).focus();
			form_ok = false;
		}

		if (jQuery.trim($("#num_puntos").removeClass("input-alert").val()) == ""){
			$('#num_puntos').addClass("input-alert").attr("placeholder", $('#num_puntos').data("alert")).focus();
			form_ok = false;
		}	
		
		if (jQuery.trim($("#motivo_puntos").removeClass("input-alert").val()) == ""){
			$('#motivo_puntos').addClass("input-alert").attr("placeholder", $('#motivo_puntos').data("alert")).focus();
			form_ok = false;
		}	

		if (form_ok == true){
			var username = $("#id_usuario").val()
				puntos = $("#num_puntos").val(),
				motivo_puntos = $("#motivo_puntos").val();
			$("#resultado-puntos").css("display","none")
									.load("app/modules/users/pages/admin-puntos-ajax.php", {id_usuario: username, num: puntos, motivo: motivo_puntos})
									.fadeIn()
									.css("display","block");
		}

		return false;
	}).iconsalerts();

	$('input[type=file]').bootstrapFileInput();

	$("#inputFile").click(function(evento){
		$(".alert-message").html("").css("display","none");
		var form_ok = true;
		if (jQuery.trim($("#nombre-fichero").val()) == ""){
			$("#fichero-alert").html("tienes que seleccionar un fichero.").fadeIn().css("display","block");
			form_ok = false;
		}
		if (form_ok == true){
			$("#formImport").submit();
		}
	});
});