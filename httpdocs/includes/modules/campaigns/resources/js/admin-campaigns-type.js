jQuery(document).ready(function(){
	
	$("#formData").submit(function(evento){
	    $(".alert-message").css("display","none");
	    var resultado_ok=true;   
		//VALIDACIONES	
		
		if (jQuery.trim($("#name").val())=="") 
		{
			 $("#nombre-alert").fadeIn().css("display","block");
			 resultado_ok=false;
		}

		if (jQuery.trim($("#desc").val())=="") 
		{
			 $("#descripcion-alert").fadeIn().css("display","block");
			 resultado_ok=false;
		}					
		return resultado_ok;
	});
});