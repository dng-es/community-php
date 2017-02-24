jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();
	$("#SubmitData").click(function(evento){
		$(".alert-message").css("display", "none");
		var form_ok = true;
		if (jQuery.trim($('#info_title').val()) == ""){
			$("#title-alert").fadeIn().css("display", "block");
			form_ok = false;
		}

		// if (jQuery.trim($('#info_file').val()) == "") {
		// 	 $("#file-alert").fadeIn().css("display", "block");
		// 	 form_ok = false;
		// }				
		if (form_ok == true) $("#formData").submit();
	});
});