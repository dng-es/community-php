// JavaScript Document
jQuery(document).ready(function(){	
	$('#nombre-video').bootstrapFileInput();
	$(".tooltip-top").tooltip({placement:"top"});

	$("#video-form").submit(function(evento){
	   $("#alertas-participa").html("").css("display","none");
	   
	   var resultado_ok=true; 
	   var texto_alerta="";  
		if (jQuery.trim($("#titulo-video").val())=="") 
		{
			 texto_alerta+="Debes intruducir un titulo del video. "; 
			 resultado_ok=false;
		}
		
		if (jQuery.trim($("#nombre-video").val())=="") 
		{
			 texto_alerta+="Debes insertar un video.";
			 resultado_ok=false;
		}
				
		if (resultado_ok!==true) 
		{			
			 $("#alertas-participa").html(texto_alerta).fadeIn().css("display","block");
			 return false;
		}	
	});

	$("#form-video-comment").submit(function(){
		$(".alert-message").css("display","none");
	   	var resultado_ok=true; 
		
		if (jQuery.trim($("#video-comentario").val())=="") 
		{
			 resultado_ok=false;
		}
				
		if (resultado_ok!==true) 
		{			
			 $("#video-comentario-alert").fadeIn().css("display","block");
			 return false;
		}	
	});
});