// JavaScript Document
jQuery(document).ready(function(){	
	
	//verificación datos del formulario
	$("#formData").submit(function(evento){
	   
	   var resultado_ok=true;   

		if (jQuery.trim($("#producto-referencia").removeClass("input-alert").val())=="") {
			$('#producto-referencia').addClass("input-alert").attr("placeholder",$('#producto-referencia').data("alert")).focus();
			resultado_ok = false;
		} 

		if (jQuery.trim($("#producto-nombre").removeClass("input-alert").val())=="") {
			$('#producto-nombre').addClass("input-alert").attr("placeholder",$('#producto-nombre').data("alert")).focus();
			resultado_ok = false;
		}
	
	   return resultado_ok;
	});
});