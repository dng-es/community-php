// JavaScript Document
jQuery(document).ready(function(){	
	$("#tema-form").submit(function(evento){
		var resultado_ok = true;   
		if (jQuery.trim($('#nombre-tema').removeClass("input-alert").val())==""){
			$('#nombre-tema').addClass("input-alert").attr("placeholder",$('#nombre-tema').prop("title")).focus();
			resultado_ok = false;
		}
		if (jQuery.trim($('#texto-descripcion').removeClass("input-alert").val())==""){
			$('#texto-descripcion').addClass("input-alert").attr("placeholder",$('#texto-descripcion').prop("title")).focus();
			resultado_ok = false;
		}
		
		return resultado_ok;
	});
});