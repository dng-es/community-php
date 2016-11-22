jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();

	$("#datetimepicker1, #datetimepicker2").datetimepicker({
		language: "es-ES"
	});


	//verificación datos del formulario
	$("#formData").submit(function(evento){
		$(".alert-message").html("").css("display","none");
		var resultado_ok = true;

		if (jQuery.trim($("#nombre").removeClass("input-alert").val()) == ""){
			$('#nombre').addClass("input-alert").attr("placeholder", $('#nombre').data("alert")).focus();
			resultado_ok = false;
		}

		if (jQuery.trim($("#date_ini").removeClass("input-alert").val()) == ""){
			$('#date_ini').addClass("input-alert").attr("placeholder", $('#date_ini').data("alert")).focus();
			resultado_ok = false;
		}

		if (jQuery.trim($("#date_fin").removeClass("input-alert").val()) == ""){
			$('#date_fin').addClass("input-alert").attr("placeholder", $('#date_fin').data("alert")).focus();
			resultado_ok = false;
		}		

		return resultado_ok;
	});
});