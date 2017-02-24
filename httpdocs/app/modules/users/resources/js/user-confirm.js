// JavaScript Document
jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();

	$("#datetimepicker1").datetimepicker({
		language: "es-ES",
		startDate: "2014/01/01"
	});

	$("#declaracion-trigger").click(function(event){
		event.preventDefault();
		$('#declaracionModal').modal('show');
	});

	$("#policy-trigger").click(function(event){
		event.preventDefault();
		$('#policyModal').modal('show');
	});

	$("#confirm-form").submit(function(evento){
		$(".alert-message").css("display", "none");

		var form_ok = true;
		if (validateEmail($("#user-email").removeClass("input-alert").val()) == false){
			$('#user-email').addClass("input-alert").attr("placeholder", $('#user-email').data("alert")).focus();
			form_ok = false;
		}
		if (jQuery.trim($("#user-nick").removeClass("input-alert").val()) == ""){
			$('#user-nick').addClass("input-alert").attr("placeholder", $('#user-nick').data("alert")).focus();
			form_ok = false;
		}
		if (jQuery.trim($("#user-nombre").removeClass("input-alert").val()) == ""){
			$('#user-nombre').addClass("input-alert").attr("placeholder", $('#user-nombre').data("alert")).focus();
			form_ok = false;
		}
		if (jQuery.trim($("#user-apellidos").removeClass("input-alert").val()) == ""){
			$('#user-apellidos').addClass("input-alert").attr("placeholder", $('#user-apellidos').data("alert")).focus();
			form_ok = false;
		}
		if ($("#user-date").val()!="" && esFechaValida($("#user-date").val()) == false){
			$('#user-date').addClass("input-alert").attr("placeholder", $('#user-date').data("alert")).focus();
			form_ok = false;
		}
		if (jQuery.trim($("#user-pass").removeClass("input-alert").val()) == ""){
			$('#user-pass').addClass("input-alert").attr("placeholder", $('#user-pass').data("alert")).focus();
			form_ok = false;
		}
		if (jQuery.trim($("#user-repass").removeClass("input-alert").val()) == ""){
			$('#user-repass').addClass("input-alert").attr("placeholder", $('#user-repass').data("alert")).focus();
			 form_ok = false;
		}	
		if (jQuery.trim($("#user-repass").removeClass("input-alert").val()) != jQuery.trim($("#user-pass").val())){
			$('#user-repass').addClass("input-alert").attr("placeholder", $('#user-repass').data("alert")).focus();
			form_ok = false;
		}
		if ($("#user-declaracion").is(":checked")==false){
			$("#user-declaracion-alert").html("Debes aceptar los términos y condiciones.").fadeIn().css("display", "block");
			form_ok = false;
		}

		return form_ok;
	});
});