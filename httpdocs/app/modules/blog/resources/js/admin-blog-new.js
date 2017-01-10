jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();

	$("#formData").submit(function(evento){
		var resultado_ok = true;

		if (jQuery.trim($("#nombre").removeClass("input-alert").val()) == ""){
			$('#nombre').addClass("input-alert").attr("placeholder", $('#nombre').data("alert")).focus();
			resultado_ok = false;
		}

		if ($("#canal").val() == null){
			$("#formData").find("[data-id='canal']").addClass("input-alert");
			resultado_ok = false;
		}
		else $("#formData").find("[data-id='canal']").removeClass("input-alert");
			
		return resultado_ok;
	});	
});