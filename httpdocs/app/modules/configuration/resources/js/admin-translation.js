// JavaScript Document
jQuery(document).ready(function(){
	$("#formData").submit(function(evento){
		var form_ok = true;

		// if (jQuery.trim($("#site-name").removeClass("input-alert").val()) == ""){
		// 	$('#site-name').addClass("input-alert").attr("placeholder", $('#site-name').data("alert")).focus();
		// 	form_ok = false;
		// }


		return form_ok;
	});

	$('.popover-dismiss').popover({
	  trigger: 'focus',
	  container: 'body',
	  html: true, 
	})
});