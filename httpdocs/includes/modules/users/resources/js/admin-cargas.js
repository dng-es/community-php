// JavaScript Document
jQuery(document).ready(function(){	
	$('input[type=file]').bootstrapFileInput();

	$("#inputFile").click(function(evento){
	   $(".alert-message").html("").css("display","none");
	   
	   var resultado_ok=true;   
		if (jQuery.trim($("#nombre-fichero").val())=="") {
			 $("#fichero-alert").html("tienes que seleccionar un fichero.").fadeIn().css("display","block");
			 resultado_ok=false;
		}				
		if (resultado_ok==true) {
			$("#formImport").submit();
		}		
	});
});