// JavaScript Document
jQuery(document).ready(function(){
	$("#formData").submit(function(evento){
		var resultado_ok = true;

		if (jQuery.trim($("#site-name").removeClass("input-alert").val()) == ""){
			$('#site-name').addClass("input-alert").attr("placeholder", $('#site-name').data("alert")).focus();
			resultado_ok = false;
		}
		if (jQuery.trim($("#site-url").removeClass("input-alert").val()) == ""){
			$('#site-url').addClass("input-alert").attr("placeholder", $('#site-url').data("alert")).focus();
			resultado_ok = false;
		}
		if(validateEmail($("#email-contact").removeClass("input-alert").val()) == false){
			$('#email-contact').addClass("input-alert").attr("placeholder", $('#email-contactl').data("alert")).focus();
			resultado_ok = false;
		}
		if(validateEmail($("#email-mailing").removeClass("input-alert").val()) == false){
			$('#email-mailing').addClass("input-alert").attr("placeholder", $('#email-mailing').data("alert")).focus();
			resultado_ok = false;
		}

		return resultado_ok;
	});
});