jQuery(document).ready(function(){
	$(".numeric").numeric();
	$('input[type=file]').bootstrapFileInput();

	$("#formData").submit(function(evento){
		$(".alert-message").html("").css("display", "none");
		var resultado_ok = true;
		return resultado_ok;
	});
});