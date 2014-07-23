jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();
	$("#SubmitData").click(function(evento){
	   $(".alert-message").html("").css("display","none");
	   var resultado_ok=true;   
		if (jQuery.trim($('#info_title').val())=="") 
		{		 
			 $("#title-alert").html("Debe insertar un titulo.").fadeIn().css("display","block");
			 resultado_ok=false;
		}	

		// if (jQuery.trim($('#info_file').val())=="") 
		// {		 
		// 	 $("#file-alert").html("Debe insertar un documento.").fadeIn().css("display","block");
		// 	 resultado_ok=false;
		// }				
		if (resultado_ok==true) 
		{
			$("#formData").submit();
		}		
	});
});