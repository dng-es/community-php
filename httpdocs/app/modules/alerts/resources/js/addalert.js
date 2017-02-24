// JavaScript Document
jQuery(document).ready(function(){
	$("#datetimepicker1, #datetimepicker2").datetimepicker({
		language: "es-ES",
		startDate: "2014/01/01"
	});

	//verificación datos del formulario
	$("#formAddAction").submit(function(evento){
		$(".alert-message").html("").css("display","none");
		var form_ok = true;

		if (jQuery.trim($("#text_alert").removeClass("input-alert").val()) == ""){
			$('#text_alert').addClass("input-alert").attr("placeholder", $('#text_alert').data("alert")).focus();
			form_ok = false;
		}

		if (jQuery.trim($("#date_ini").removeClass("input-alert").val()) == ""){
			$('#date_ini').addClass("input-alert").attr("placeholder", $('#date_ini').data("alert")).focus();
			form_ok = false;
		}

		if (jQuery.trim($("#date_fin").removeClass("input-alert").val()) == ""){
			$('#date_fin').addClass("input-alert").attr("placeholder", $('#date_fin').data("alert")).focus();
			form_ok = false;
		}

		return form_ok;
	});


	getDestinations("user");
	$("#type_alert").change(function(evento){
		getDestinations($(this).val());
	});

	function getDestinations(tipo){
		$("#destination_alert").load("app/modules/alerts/pages/alertsCmb.php?tipo=" + tipo, function(){

		});
	}
});