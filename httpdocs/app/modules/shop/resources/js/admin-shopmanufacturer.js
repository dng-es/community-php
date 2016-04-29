jQuery(document).ready(function(){
	$("#formData").submit(function(evento){
		var resultado_ok = true;

		if (jQuery.trim($("#name_manufacturer").removeClass("input-alert").val())=="") {
				$('#name_manufacturer').addClass("input-alert").attr("placeholder",$('#name_manufacturer').data("alert")).focus();
			resultado_ok=false;
		}

		return resultado_ok;
	});
});