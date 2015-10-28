jQuery(document).ready(function(){
	$('#fichero').bootstrapFileInput();

	$("#formRanking").submit(function(evento){
		$(".alert-message").css("display","none");
		var form_ok = true;
		if (jQuery.trim($("#nombre").val()) == ""){
			$("#nombre-alert").fadeIn().css("display", "block");
			form_ok = false;
		}
		return form_ok;
	});
});