// JavaScript Document
jQuery(document).ready(function(){
	$("#puntos").numeric();
	$("#datetimepicker1, #datetimepicker2").datetimepicker({
		language: "es-ES",
		startDate: "2014/01/01"
	});

	//verificación datos del formulario
	$("#formData").submit(function(evento){
		var resultado_ok=true;

		if (jQuery.trim($("#puntos").removeClass("input-alert").val())==""){
			$('#puntos').addClass("input-alert").attr("placeholder",$('#puntos').data("alert")).focus();
			resultado_ok = false;
		}

		if (jQuery.trim($("#date_ini").removeClass("input-alert").val())==""){
			$('#date_ini').addClass("input-alert").attr("placeholder",$('#date_ini').data("alert")).focus();
			resultado_ok = false;
		}

		if ($("#canal_puntos").val() == null){
			$("#formData").find("[data-id='canal_puntos']").addClass("input-alert");
			resultado_ok = false;
		}
		else $("#formData").find("[data-id='canal_puntos']").removeClass("input-alert");

		if (jQuery.trim($("#date_fin").removeClass("input-alert").val())==""){
			$('#date_fin').addClass("input-alert").attr("placeholder",$('#date_fin').data("alert")).focus();
			resultado_ok = false;
		}
	
		return resultado_ok;
	});
});