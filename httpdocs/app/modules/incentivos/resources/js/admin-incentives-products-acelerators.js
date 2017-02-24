// JavaScript Document
jQuery(document).ready(function(){	
	$("#valor_acelerador").numeric();
	$("#datetimepicker1, #datetimepicker2").datetimepicker({
		language: "es-ES",
		startDate: "2014/01/01"
	});

	//verificación datos del formulario
	$("#formData").submit(function(evento){
		var form_ok = true;

		if (jQuery.trim($("#valor_acelerador").removeClass("input-alert").val()) == ""){
			$('#valor_acelerador').addClass("input-alert").attr("placeholder",$('#valor_acelerador').data("alert")).focus();
			form_ok = false;
		}

		if (jQuery.trim($("#date_ini").removeClass("input-alert").val()) == ""){
			$('#date_ini').addClass("input-alert").attr("placeholder",$('#date_ini').data("alert")).focus();
			form_ok = false;
		}

		if (jQuery.trim($("#date_fin").removeClass("input-alert").val()) == ""){
			$('#date_fin').addClass("input-alert").attr("placeholder",$('#date_fin').data("alert")).focus();
			form_ok = false;
		}
	
		return form_ok;
	});
});