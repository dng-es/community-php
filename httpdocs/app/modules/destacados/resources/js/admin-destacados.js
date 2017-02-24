// JavaScript Document
jQuery(document).ready(function(){
	$(".numeric").numeric();
	
	$("#formData").submit(function(evento){
		var form_ok = true;
		
		if (jQuery.trim($("#texto_destacado").removeClass("input-alert").val()) == ""){
			$('#texto_destacado').addClass("input-alert").attr("placeholder", $('#texto_destacado').data("alert")).focus();
			form_ok = false;
		}

		if (isNaN(jQuery.trim($("#id_destacado").removeClass("input-alert").val()))){
			$('#id_destacado').addClass("input-alert").attr("placeholder", $('#id_destacado').data("alert")).focus();
			form_ok = false;
		}

		if (jQuery.trim($("#id_destacado").removeClass("input-alert").val()) == ""){
			$('#id_destacado').addClass("input-alert").attr("placeholder", $('#id_destacado').data("alert")).focus();
			form_ok = false;
		}			
		
		return form_ok;
	});
});