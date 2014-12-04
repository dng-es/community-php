// JavaScript Document
jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();

	$("#formData").submit(function(evento){
		return sendForm("mensaje");
	});


	function sendForm(tipo){
		$(".alert-message").html("").css("display","none");
		var resultado_ok=true;


		if (jQuery.trim($("#name_list").val())=="") 
		{
			 $("#name-alert").html("Debes insertar algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
		}	
				
		return resultado_ok;		
	}
});