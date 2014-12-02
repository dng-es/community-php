// JavaScript Document
jQuery(document).ready(function(){
	$(".numeric").numeric();
	
	$("#SubmitData").click(function(evento){
	   $(".alert-message").css("display","none");
	   var resultado_ok=true;   
		if (jQuery.trim($('#texto_destacado').val())=="") {		 
			 $("#texto-destacado-alert").fadeIn().css("display","block");
			 resultado_ok=false;
		}
		if (isNaN($("#id_destacado").val())) {
			 $("#id-destacado-alert").fadeIn().css("display","block");
			 resultado_ok=false;
		}
		if (jQuery.trim($('#id_destacado').val())=="") {		 
			 $("#id-destacado-alert").fadeIn().css("display","block");
			 resultado_ok=false;
		}				
		if (resultado_ok==true) {
			$("#formData").submit();
		}		
	});
});