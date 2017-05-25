jQuery(document).ready(function(){
	$(".numeric").numeric();

	$("#formData").submit(function(evento){
		var resultado_ok = true;

		if (jQuery.trim($("#name_guide").removeClass("input-alert").val()) == ""){
			$('#name_guide').addClass("input-alert").attr("placeholder", $('#name_guide').data("alert")).focus();
			resultado_ok = false;
		}
			
		return resultado_ok;
	});
});