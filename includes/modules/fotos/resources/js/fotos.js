// JavaScript Document
jQuery(document).ready(function(){	
	$('#nombre-foto').bootstrapFileInput();

	$("#foto-submit").click(function(evento){
	   $("#alertas-participa").html("");
	   $("#alertas-participa").css("display","none");
	   
	   var resultado_ok=true;   
	   var texto_alerta="";
		if (jQuery.trim($("#titulo-foto").val())=="") 
		{
			 texto_alerta += "Debes intruducir un titulo de la foto. ";
			 resultado_ok=false;
		}
		
		if (jQuery.trim($("#nombre-foto").val())=="") 
		{
			 texto_alerta += "Debes insertar una foto.";
			 resultado_ok=false;
		}
				
		if (resultado_ok==true) 
		{
			$("#foto-form").submit();
		}
		else
		{			
			 $("#alertas-participa").html(texto_alerta);	 
			 $("#alertas-participa").fadeIn();
			 $("#alertas-participa").css("display","block");
		}		
	});
});

