// JavaScript Document
jQuery(document).ready(function(){	
	$("#tema-form").submit(function(evento){
	   $("#alertas-mensajes").html("").css("display","none");
	   
	   var resultado_ok=true;   
	   var texto_alerta="";  
		if ($('#nombre-tema').val()==""){
			 texto_alerta += "Inserta el nombre del tema. ";
			 resultado_ok=false;
		}
		if ($('#texto-descripcion').val()==""){
			 texto_alerta += "Inserta la descripción del tema.";
			 resultado_ok=false;
		}
		
		if (resultado_ok!=true){
			 $("#alertas-mensajes").html(texto_alerta).fadeIn().css("display","block");
			 return false;
		}		
	});
});