// JavaScript Document
jQuery(document).ready(function(){
	$(".numeric").numeric();

	$("#formData").submit(function(evento){
		var form_ok = true;

		if (jQuery.trim($("#points_info").removeClass("input-alert").val()) == ""){
			form_ok = false;
			$("#points_info").addClass("input-alert").attr("placeholder", $('#points_info').data("alert")).focus();
		}

		return form_ok;
	});
});