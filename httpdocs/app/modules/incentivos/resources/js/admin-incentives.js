// JavaScript Document
jQuery(document).ready(function(){	
	$("#puntos_incentivo").numeric();
	$("#datetimepicker1, #datetimepicker2").datetimepicker({
		language: "es-ES",
		startDate: "2014/01/01"
	});

	//verificación datos del formulario
	$("#formData").submit(function(evento){
	   
		var resultado_ok=true;   

		if (jQuery.trim($("#puntos_incentivo").removeClass("input-alert").val())=="") {
			$('#puntos_incentivo').addClass("input-alert").attr("placeholder",$('#puntos_incentivo').data("alert")).focus();
			resultado_ok = false;
		} 

		if (jQuery.trim($("#date_ini").removeClass("input-alert").val())=="") {
			$('#date_ini').addClass("input-alert").attr("placeholder",$('#date_ini').data("alert")).focus();
			resultado_ok = false;
		}

		if (jQuery.trim($("#date_fin").removeClass("input-alert").val())=="") {
			$('#date_fin').addClass("input-alert").attr("placeholder",$('#date_fin').data("alert")).focus();
			resultado_ok = false;
		}		
	
	   return resultado_ok;
	});
});