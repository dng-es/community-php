jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();
	$("#formData").submit(function(evento){
		var form_ok = true;

		if (jQuery.trim($("#info_title").removeClass("input-alert").val()) == ""){
			$('#info_title').addClass("input-alert").attr("placeholder", $('#info_title').data("alert")).focus();
			form_ok = false;
		}
		// if (jQuery.trim($('#info_file').val())==""){
		// 	 $("#file-alert").html("Debe insertar un documento.").fadeIn().css("display","block");
		// 	 form_ok=false;
		// }				
		return form_ok;
	});
});