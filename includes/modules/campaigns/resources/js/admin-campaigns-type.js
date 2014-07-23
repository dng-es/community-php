jQuery(document).ready(function(){
	
	$("#formData").submit(function(evento){
	    $(".alert-message").html("").css("display","none");
	    var resultado_ok=true;   
		//VALIDACIONES	
		
		if (jQuery.trim($("#name").val())=="") 
		{
			 $("#nombre-alert").html("Debes insertar algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
		}

		if (jQuery.trim($("#desc").val())=="") 
		{
			 $("#descripcion-alert").html("Debes insertar algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
		}					
		return resultado_ok;
	});
});