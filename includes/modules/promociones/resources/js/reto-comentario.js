// JavaScript Document
jQuery(document).ready(function(){
	$("#coment-form").submit(function(evento){
	   $("#alertas-reto").html("").css("display","none");
	   var resultado_ok=true;  
	   var mensaje_alerta=""; 
		if (jQuery.trim($('#texto-comentario').val())=="") 
		{
			 mensaje_alerta+="Debes insertar algo de texto en la respuesta. "
			 resultado_ok=false;
		}
//		if (document.getElementById('texto-comentario').value.length>1000)
//		{
//			 mensaje_alerta+="Ha superado el límite de caracteres. Máximo 1000 caracteres. "
//			 resultado_ok=false;
//		}		
		if (resultado_ok!==true) 
		{
			$("#alertas-reto").html(mensaje_alerta).fadeIn().css("display","block");
			return false;
		}		
	});
});

