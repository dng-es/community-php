// JavaScript Document
jQuery(document).ready(function(){
	$("#SubmitData").click(function(evento){
	   $(".alert-message").html("").css("display","none");
	   var resultado_ok=true;   
		if (jQuery.trim($('#texto_destacado').val())=="") {		 
			 $("#texto-destacado-alert").html("Debes insertar algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
		}
		if (isNaN($("#id_destacado").val())) {
			 $("#id-destacado-alert").html("Debes insertar un n&uacute;mero.").fadeIn().css("display","block");
			 resultado_ok=false;
		}
		if (jQuery.trim($('#id_destacado').val())=="") {		 
			 $("#id-destacado-alert").html("Debes insertar un n&uacute;mero.").fadeIn().css("display","block");
			 resultado_ok=false;
		}				
		if (resultado_ok==true) {
			$("#formData").submit();
		}		
	});
});