jQuery(document).ready(function(){
	$(".numeric").numeric();

	$("#formData").submit(function(evento){
		var resultado_ok = true;

		if (jQuery.trim($("#titulo").removeClass("input-alert").val()) == ""){
			$('#titulo').addClass("input-alert").attr("placeholder", $('#titulo').data("alert")).focus();
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