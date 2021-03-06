// JavaScript Document
jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();

	//verificación datos del formulario
	$("#confirm-form").submit(function(evento){
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
		if ($("#user-date").removeClass("input-alert").val() != "" && esFechaValida($("#user-date").val()) == false){
			$('#user-date').addClass("input-alert").attr("placeholder", $('#user-date').data("alert")).focus();
			form_ok = false;
		}
		if (jQuery.trim($("#user-pass").removeClass("input-alert").val().length) < 6){
			$("#password-text-alert").html("La contraseña tiene que tener mínimo 6 caracteres.").fadeIn().css("display","block");
			$('#user-pass').addClass("input-alert").focus();
			form_ok=false;
		}
		if (jQuery.trim($("#user-pass").removeClass("input-alert").val()) == ""){
			$('#user-pass').addClass("input-alert").attr("placeholder", $('#user-pass').data("alert")).focus();
			form_ok = false;
		}
		if (jQuery.trim($("#user-repass").removeClass("input-alert").val()) != jQuery.trim($("#user-pass").val())){
			$('#user-repass').addClass("input-alert").attr("placeholder", $('#user-repass').data("alert")).focus();
			form_ok = false;
		}

		if ($("#nombre-fichero").val() != ""){
			var fileSize = $('#nombre-fichero')[0].files[0].size;
			if (fileSize > 1000000){
				$('#foto-alert').show();
				form_ok = false;
			}
		}		
	
		//iconAlerts($(this).attr('id'));
		return form_ok;
	}).iconsalerts();

});