// JavaScript Document
jQuery(document).ready(function(){
	$("#formData").submit(function(evento){  
	   $(".alert-message").html("").css("display","none");	   	   
	   
	   var form_ok=true;   
		if (jQuery.trim($("#username").val())=="") 
		{
			form_ok=false;
			$("#user-alert").html("Debes insertar algo de texto.")
			 				 .fadeIn()
			 				 .css("display","block");
		}
		if (jQuery.trim($("#user_password").val())=="") 
		{
			form_ok=false;
			$("#pass-alert").html("Debes insertar algo de texto.")
			 				 .fadeIn()
			 				 .css("display","block");
		}
		if (jQuery.trim($("#perfil_user").val())=="") 
		{
			form_ok=false;
			$("#perfil-alert").html("Debes seleccionar un perfil.")
			 				   .fadeIn()
			 				   .css("display","block");
		}
		
		if (jQuery.trim($("#canal_user").val())=="" && ($("#perfil_user").val()=="usuario" || $("#perfil_user").val()=='responsable' )) 
		{
			form_ok=false;
			$("#canal-alert").html("Debes seleccionar un canal.")
			 				  .fadeIn()
			 				  .css("display","block");
		}
		if (jQuery.trim($("#territorial_user").val())=="") 
		{
			form_ok=false;
			$("#territorial-alert").html("Debes insertar algo de texto.")
			 						.fadeIn()
			 						.css("display","block");
		}
		if (jQuery.trim($("#empresa_user").val())=="") 
		{
			form_ok=false;
			$("#empresa-alert").html("Debes seleccionar un centro.")
			 				   .fadeIn()
			 				   .css("display","block");
		}	
		if (jQuery.trim($("#name_user").val())=="") {
			form_ok=false;
			$("#nombre-alert").html("Debes insertar algo de texto.")
			 				   .fadeIn()
			 				   .css("display","block");
		}	
		if (validateEmail($("#email_user").val())==false){
			form_ok=false;
			$("#email-alert").html("Debes introducir un email válido.")
			 				  .fadeIn()
			 				  .css("display","block");
	    }
		valor_var=$("#confirmed_user").val();
		if (valor_var!="0" && valor_var!="1"){
			form_ok=false;
			$("#confirmado-alert").html("Debes insertar 1 o 0.")
			 					   .fadeIn()
			 					   .css("display","block");
		}
		valor_var=$("#registered_user").val();
		if (valor_var!="0" && valor_var!="1"){
			form_ok=false;
			$("#registrado-alert").html("Debes insertar 1 o 0.")
			 					   .fadeIn()
			 					   .css("display","block");
		}	
		valor_var=$("#disabled_user").val();
		if (valor_var!="0" && valor_var!="1"){
			form_ok=false;
			$("#disabled-alert").html("Debes insertar 1 o 0.")
			 					 .fadeIn()
			 					 .css("display","block");
		}
		
		return form_ok;		
	});
});




