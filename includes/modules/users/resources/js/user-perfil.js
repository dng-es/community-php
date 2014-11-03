// JavaScript Document
jQuery(document).ready(function(){	
	$('input[type=file]').bootstrapFileInput();

	
	//verificación datos del formulario
	$("#confirm-form").submit(function(evento){
	   $(".alert-message").html("").css("display","none");
	   
	   var resultado_ok=true;   
	   if (validateEmail($("#user-email").val())==false) 
	   {
			 $("#user-email-alert").html("Debes introducir un email válido.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }
	   if (jQuery.trim($("#user-nick").val())=="") 
	   {
			 $("#user-nick-alert").html("Debes intruducir algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }
	   if (jQuery.trim($("#user-nombre").val())=="") 
	   {
			 $("#user-nombre-alert").html("Debes intruducir algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }
	   if (jQuery.trim($("#user-apellidos").val())=="") 
	   {
			 $("#user-apellidos-alert").html("Debes intruducir algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }	   
	   if ($("#user-date").val()!="" && esFechaValida($("#user-date").val())==false) 
	   {
			 $("#user-date-alert").html("Debes intruducir una fecha valida. Formato aaaa-mm-dd.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }
	   if (jQuery.trim($("#user-pass").val())=="") 
	   {
			 $("#user-pass-alert").html("Debes intruducir algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }
	   if (jQuery.trim($("#user-repass").val())=="") 
	   {
			 $("#user-repass-alert").html("Debes intruducir algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }	
	   if (jQuery.trim($("#user-repass").val())!=jQuery.trim($("#user-pass").val())) 
	   {
			 $("#user-repass-alert").html("Las contrase&ntilde;as no coinciden.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }  	   		
/*	   if (jQuery.trim($("#user-comentarios").val())=="") 
	   {
			 $("#user-comentarios-alert").html("Debes intruducir algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }*/	
	   return resultado_ok;
	});


	//verificación formulario sucursal
	$("#form-sucursal").submit(function(evento){
	   $(".alert-message").html("").css("display","none");
	   
	   var resultado_ok=true;   

	   if (jQuery.trim($("#sucursal_name").val())=="") 
	   {
			 $("#sucursal-name-alert").html("Debes intruducir algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }
	   if (jQuery.trim($("#sucursal_direccion").val())=="") 
	   {
			 $("#sucursal-direccion-alert").html("Debes intruducir algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }
	   return resultado_ok;
	});
});