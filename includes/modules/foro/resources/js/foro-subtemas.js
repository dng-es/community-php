// JavaScript Document
jQuery(document).ready(function(){	
	$("#tema-form").submit(function(evento){
		$("#alertas-mensajes").css("display","none");
	   
		var resultado_ok=true;   
		if ($('#nombre-tema').val()==""){
			 resultado_ok=false;
		}
		if ($('#texto-descripcion').val()==""){
			 resultado_ok=false;
		}
		
		if (resultado_ok!=true){
			 $("#alertas-mensajes").fadeIn().css("display","block");
			 return false;
		}		
	});
});