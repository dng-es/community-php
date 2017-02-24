jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();

	$("#formData").submit(function(evento){
		var form_ok = true;

		if (jQuery.trim($("#nombre").removeClass("input-alert").val()) == ""){
			$('#nombre').addClass("input-alert").attr("placeholder", $('#nombre').data("alert")).focus();
			form_ok = false;
		}

		if ($("#canal").val() == null){
			$("#formData").find("[data-id='canal']").addClass("input-alert");
			form_ok = false;
		}
		else $("#formData").find("[data-id='canal']").removeClass("input-alert");
			
		return form_ok;
	});	
});