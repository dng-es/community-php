// JavaScript Document
jQuery(document).ready(function(){
	$("#formData").submit(function(evento){
		$(".alert-message").css("display","none");
		var resultado_ok=true;

		if (jQuery.trim($("#site-name").val())=="") 
		{
			 $("#site-name-alert").fadeIn().css("display","block");
			 resultado_ok=false;
		}
		if (jQuery.trim($("#site-url").val())=="") 
		{
			 $("#site-url-alert").fadeIn().css("display","block");
			 resultado_ok=false;
		}		
		if(validateEmail($("#email-contact").val())==false){
			$("#email-contact-alert").fadeIn().css("display","block");
			resultado_ok=false;
		}

		if(validateEmail($("#email-mailing").val())==false){
			$("#email-mailing-alert").fadeIn().css("display","block");
			resultado_ok=false;
		}
		return resultado_ok;
	});
});