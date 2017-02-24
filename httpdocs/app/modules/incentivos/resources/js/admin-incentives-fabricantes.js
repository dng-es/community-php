// JavaScript Document
jQuery(document).ready(function(){
	//verificación datos del formulario
	$("#formData").submit(function(evento){
		var form_ok = true;
		if (jQuery.trim($("#fabricante-nombre").removeClass("input-alert").val())==""){
			$('#fabricante-nombre').addClass("input-alert").attr("placeholder",$('#fabricante-nombre').data("alert")).focus();
			form_ok = false;
		}
		return form_ok;
	});
});