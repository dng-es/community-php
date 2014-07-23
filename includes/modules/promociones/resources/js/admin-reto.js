// JavaScript Document
jQuery(document).ready(function(){	
	$('input[type=file]').bootstrapFileInput();

	$("#video-submit").click(function(evento){	   
	   $(".alert-message").html("").css("display","none");
	   
	   var resultado_ok=true;   
		if (jQuery.trim($("#titulo-fichero").val())=="") 
		{
			 $("#titulo-video-alert").html("Debes intruducir un titulo.")
			 						 .fadeIn()
			 						 .css("display","block");
			 resultado_ok=false;
		}
		
		if (jQuery.trim($("#nombre-fichero").val())=="") 
		{
			 $("#fichero-video-alert").html("Debes insertar un archivo.")
			 						  .fadeIn()
			 						  .css("display","block");
			 resultado_ok=false;
		}
				
		if (resultado_ok==true) 
		{
			$("#video-form").submit();
		}			
	});
	
	$("#formData").submit(function(evento){
	   $(".alert-message").html("");
	   $(".alert-message").css("display","none");
	   
	   var resultado_ok=true;   

	   if (jQuery.trim($("#nombre-reto").val())=="") 
	   {
			 $("#nombre-reto-alert").html("Debes intruducir el nombre del reto.")
			 						.fadeIn()
			 						.css("display","block");
			 resultado_ok=false;
	   }
	   
	   if (jQuery.trim($("#date-comentarios").val())=="") 
	   {
			 $("#date-comentarios-alert").html("Debes intruducir una fecha.")
			 							 .fadeIn()
			 							 .css("display","block");
			 resultado_ok=false;
	   }
	   
	   if (jQuery.trim($("#date-fin-comentarios").val())=="") 
	   {
			 $("#date-fin-comentarios-alert").html("Debes intruducir una fecha.")
			 								 .fadeIn()
			 								 .css("display","block");
			 resultado_ok=false;
	   }
	   
	   return resultado_ok;
	});
});

