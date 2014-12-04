jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();
	
	$("#formData").submit(function(evento){
	    $(".alert-message").css("display","none");
	    var resultado_ok=true;   
		//VALIDACIONES	
		
		if (jQuery.trim($("#name_campaign").val())=="") {
			 $("#nombre-alert").fadeIn().css("display","block");
			 resultado_ok=false;
		}	

		if (jQuery.trim($("#desc_campaign").val())=="") {
			 $("#descripcion-alert").fadeIn().css("display","block");
			 resultado_ok=false;
		}					
		return resultado_ok;
	});
});