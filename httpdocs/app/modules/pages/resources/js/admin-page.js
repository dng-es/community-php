jQuery(document).ready(function(){
	$(".numeric").numeric();
	
	$("#formData").submit(function(evento){
		$(".alert-message").html("").css("display", "none");
		var form_ok = true;

		if (jQuery.trim($("#page_name_new").removeClass("input-alert").val()) == ""){
			$('#page_name_new').addClass("input-alert").attr("placeholder", $('#page_name_new').data("alert")).focus();
			form_ok = false;
		}
		
		return form_ok;
	});
});