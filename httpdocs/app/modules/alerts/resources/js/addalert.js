// JavaScript Document
jQuery(document).ready(function(){
	$('.numeric').numeric();
	$('input[type=file]').bootstrapFileInput();

	$("#datetimepicker1, #datetimepicker2").datetimepicker({
		language: "es-ES",
		startDate: "2014/01/01"
	});

	$("#datetimepicker1").data("datetimepicker").setLocalDate(new Date ($("#date_ini").data("val")));
	$("#datetimepicker2").data("datetimepicker").setLocalDate(new Date ($("#date_fin").data("val")));

	$('#time_ini').timepicker({
		showMeridian: false,
		minuteStep: 30,
		defaultTime: $("#time_ini").data("val")
	});

	$('#time_fin').timepicker({
		showMeridian: false,
		minuteStep: 30,
		defaultTime: $("#time_fin").data("val")
	});

	//verificación datos del formulario
	$("#formAddAction").submit(function(evento){
		$(".alert-message").html("").css("display","none");
		var form_ok = true;

		if (jQuery.trim($("#title_alert").removeClass("input-alert").val()) == ""){
			$('#title_alert').addClass("input-alert").attr("placeholder", $('#title_alert').data("alert")).focus();
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

		if ($("#destination_alert").val() == null){
			$("#formAddAction").find("[data-id='destination_alert']").addClass("input-alert");
			form_ok = false;
		}
		else $("#formAddAction").find("[data-id='destination_alert']").removeClass("input-alert");

		return form_ok;
	});


	getDestinations($("#type_alert").val(), $("#type_alert").data("sel"));
	$("#type_alert").change(function(evento){
		getDestinations($(this).val(), $(this).data("sel"));
	});

	function getDestinations(tipo, seleccionado){
		$("#destination_alert").load("app/modules/alerts/pages/alertsCmb-ajax.php?tipo=" + tipo + "&sel=" + seleccionado, function(){
			$('#destination_alert').selectpicker('refresh');
		});
	}
});