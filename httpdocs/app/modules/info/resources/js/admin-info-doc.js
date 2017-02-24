jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();

	$("#formData").submit(function(evento){
		var form_ok = true;   
		if (jQuery.trim($("#info_title").removeClass("input-alert").val()) == ""){
			$('#info_title').addClass("input-alert").attr("placeholder", $('#info_title').data("alert")).focus();
			form_ok = false;
		}

		if ($("#info_canal").val() == null){
			$("#formData").find("[data-id='info_canal']").addClass("input-alert");
			form_ok = false;
		}
		else $("#formData").find("[data-id='info_canal']").removeClass("input-alert");

		return form_ok;
	});
});