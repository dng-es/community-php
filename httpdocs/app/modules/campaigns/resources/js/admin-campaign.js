jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();

	$("#formData").submit(function(evento){
		var form_ok = true;

		if (jQuery.trim($("#name_campaign").removeClass("input-alert").val()) == ""){
			$('#name_campaign').addClass("input-alert").attr("placeholder", $('#name_campaign').data("alert")).focus();
			form_ok = false;
		}

		if (jQuery.trim($("#desc_campaign").removeClass("input-alert").val()) == ""){
			$('#desc_campaign').addClass("input-alert").attr("placeholder", $('#desc_campaign').data("alert")).focus();
			form_ok = false;
		}

		if ($("#canal_campaign").val() == null){
			$("#formData").find("[data-id='canal_campaign']").addClass("input-alert");
			form_ok = false;
		}
		else $("#formData").find("[data-id='canal_campaign']").removeClass("input-alert");

		return form_ok;
	});
});