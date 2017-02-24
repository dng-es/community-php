// JavaScript Document
jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();

	$("#inputFile").click(function(evento){
		$(".alert-message").html("").css("display","none");

		var form_ok = true;
		if (jQuery.trim($("#nombre-fichero").val()) == ""){
			$("#fichero-alert").html("tienes que seleccionar un fichero.").fadeIn().css("display", "block");
			form_ok = false;
		}
		if (form_ok == true){
			$("#formImport").submit();
		}
	});
});