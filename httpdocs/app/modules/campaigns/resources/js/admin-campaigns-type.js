jQuery(document).ready(function(){
	$("#formData").submit(function(evento){
		var form_ok = true;
			
		if (jQuery.trim($("#name").removeClass("input-alert").val()) == ""){
			$('#name').addClass("input-alert").attr("placeholder", $('#name').data("alert")).focus();
			form_ok = false;
		}

		if (jQuery.trim($("#desc").removeClass("input-alert").val()) == ""){
			$('#desc').addClass("input-alert").attr("placeholder", $('#desc').data("alert")).focus();
			form_ok = false;
		}				

		return form_ok;
	});
});