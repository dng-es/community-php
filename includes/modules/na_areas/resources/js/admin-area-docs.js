jQuery(document).ready(function(){	
	$("#inputFile").click(function(evento){
	   $(".alert-message").html("").css("display","none");
	   
	   var resultado_ok=true;   
		// if (jQuery.trim($("#nombre-fichero").val())=="") 
		// {
		// 	 $("#fichero-alert").html("tienes que seleaccionar un fichero.").fadeIn().css("display","block");
		// 	 resultado_ok=false;
		// }				
		if (resultado_ok==true) 
		{
			$("#formImport").submit();
		}		
	});
});