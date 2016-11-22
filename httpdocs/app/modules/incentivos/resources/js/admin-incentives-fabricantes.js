// JavaScript Document
jQuery(document).ready(function(){	
	
	//verificación datos del formulario
	$("#formData").submit(function(evento){
	   
	   var resultado_ok=true;   

	   if (jQuery.trim($("#fabricante-nombre").removeClass("input-alert").val())=="") {
			$('#fabricante-nombre').addClass("input-alert").attr("placeholder",$('#fabricante-nombre').data("alert")).focus();
			resultado_ok = false;
	   } 	   		
	
	   return resultado_ok;
	});
});