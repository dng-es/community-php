jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();

	$("#formData").submit(function(evento){
		var resultado_ok = true;   
		if (jQuery.trim($("#info_title").removeClass("input-alert").val()) == ""){
			$('#info_title').addClass("input-alert").attr("placeholder", $('#info_title').data("alert")).focus();
			resultado_ok = false;
		}

		if ($("#info_canal").val() == null){
			$("#formData").find("[data-id='info_canal']").addClass("input-alert");
			resultado_ok = false;
		}
		else $("#formData").find("[data-id='info_canal']").removeClass("input-alert");

		return resultado_ok;
	});
});