// JavaScript Document
jQuery(document).ready(function(){	
	$("#valor_objetivo").numeric();

	//verificación datos del formulario
	$("#formData").submit(function(evento){
	   
	   var resultado_ok=true;   

		if (jQuery.trim($("#valor_objetivo").removeClass("input-alert").val())=="") {
			$('#valor_objetivo').addClass("input-alert").attr("placeholder",$('#valor_objetivo').data("alert")).focus();
			resultado_ok = false;
		}		
	
	   return resultado_ok;
	});
});