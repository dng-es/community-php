// JavaScript Document
jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();

	$("#formData").submit(function(evento){
		var form_ok = true;
		if (jQuery.trim($("#recompensa_nombre").removeClass("input-alert").val()) == ""){
			form_ok = false;
			$("#recompensa_nombre").addClass("input-alert").attr("placeholder",$('#recompensa_nombre').data("alert")).focus();
		}

/*		if (jQuery.trim($("#recompensa_image").removeClass("input-alert").val()) == ""){
			form_ok = false;
			$("#recompensa_image").addClass("input-alert").attr("placeholder",$('#recompensa_image').data("alert")).focus();
		}*/

		return form_ok;
	});
});