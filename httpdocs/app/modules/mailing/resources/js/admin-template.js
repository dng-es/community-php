jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();
	
	$("#formData").submit(function(evento){
		$(".alert-message").html("").css("display", "none");
		var resultado_ok = true;
		
		if (jQuery.trim($("#template_name").val()) == ""){
			 $("#nombre-alert").html("Debes insertar algo de texto.").fadeIn().css("display", "block");
			 resultado_ok = false;
		}
		return resultado_ok;
	});
});