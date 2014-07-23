// JavaScript Document
jQuery(document).ready(function(){
	$("#formData").submit(function(evento){
		$(".alert-message").html("").css("display","none");
		var resultado_ok=true;

		if (jQuery.trim($("#site-name").val())=="") 
		{
			 $("#site-name-alert").html("Debes insertar algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
		}
		if (jQuery.trim($("#site-url").val())=="") 
		{
			 $("#site-url-alert").html("Debes insertar algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
		}		
		if(validateEmail($("#email-contact").val())==false){
			$("#email-contact-alert").html("Debes insertar un email válido.").fadeIn().css("display","block");
			resultado_ok=false;
		}

		if(validateEmail($("#email-mailing").val())==false){
			$("#email-mailing-alert").html("Debes insertar un email válido.").fadeIn().css("display","block");
			resultado_ok=false;
		}
		return resultado_ok;
	});
});