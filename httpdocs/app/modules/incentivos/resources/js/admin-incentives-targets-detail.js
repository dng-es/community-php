// JavaScript Document
jQuery(document).ready(function(){
	$("#valor_objetivo").numeric();

	//verificación datos del formulario
	$("#formData").submit(function(evento){
		var form_ok = true;
		if (jQuery.trim($("#valor_objetivo").removeClass("input-alert").val()) == ""){
			$('#valor_objetivo').addClass("input-alert").attr("placeholder", $('#valor_objetivo').data("alert")).focus();
			form_ok = false;
		}
		return form_ok;
	});
});