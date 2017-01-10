// JavaScript Document
jQuery(document).ready(function(){

	var tab_default = ($.getURLParam("t") > 0 ? $.getURLParam("t") : 0);
	$('#myTab li:eq(' + tab_default + ') a').tab('show')

	$(".permission-check").change(function(){
		if ($(this).is(':checked')) $(this).next().val("1");
		else $(this).next().val("0");
	});

	$("#formData").submit(function(evento){
		var form_ok = true;
		if (jQuery.trim($("#username").removeClass("input-alert").val()) == ""){
			form_ok = false;
			$("#username").addClass("input-alert").attr("placeholder",$('#username').data("alert")).focus();
		}
		if (jQuery.trim($("#user_password").removeClass("input-alert").val()) == ""){
			form_ok = false;
			$("#user_password").addClass("input-alert").attr("placeholder",$('#user_password').data("alert")).focus();
		}
		if (jQuery.trim($("#perfil_user").removeClass("input-alert").val()) == ""){
			form_ok = false;
			$("#perfil_user").addClass("input-alert").attr("placeholder",$('#perfil_user').data("alert")).focus();
		}
		if (jQuery.trim($("#canal_user").removeClass("input-alert").val()) == "" && ($("#perfil_user").val()=="usuario" || $("#perfil_user").val() == 'responsable' )){
			form_ok = false;
			$("#canal_user").addClass("input-alert").attr("placeholder", $('#canal_user').data("alert")).focus();
		}
		if (jQuery.trim($("#empresa_user").removeClass("input-alert").val())==""){
			form_ok = false;
			$("#empresa_user").addClass("input-alert").attr("placeholder", $('#empresa_user').data("alert")).focus();
		}
		if (jQuery.trim($("#name_user").removeClass("input-alert").val()) == ""){
			form_ok = false;
			$("#name_user").addClass("input-alert").attr("placeholder", $('#name_user').data("alert")).focus();
		}
		if (validateEmail($("#email_user").removeClass("input-alert").val()) == false){
			form_ok = false;
			$("#email_user").addClass("input-alert").attr("placeholder", $('#email_user').data("alert")).focus();
		}

		return form_ok;
	});
});