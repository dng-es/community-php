jQuery(document).ready(function(){
	$('#cp2').colorpicker();

	$("#formData").submit(function(evento){
		$(".alert-message").html("").css("display","none");
		var form_ok = true;

		if (jQuery.trim($("#name_type").removeClass("input-alert").val()) == ""){
			$('#name_type').addClass("input-alert").attr("placeholder", $('#name_type').data("alert")).focus();
			form_ok = false;
		}

		if (jQuery.trim($("#color_type").removeClass("input-alert").val()) == ""){
			$('#color_type').addClass("input-alert").attr("placeholder", $('#color_type').data("alert")).focus();
			form_ok = false;
		}		

		if ($("#perfiles_type").val() == null){
			$("#formData").find("[data-id='perfiles_type']").addClass("input-alert");
			form_ok = false;
		}
		else $("#formData").find("[data-id='perfiles_type']").removeClass("input-alert");

		return form_ok;
	});
})