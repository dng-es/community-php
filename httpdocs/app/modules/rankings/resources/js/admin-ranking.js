jQuery(document).ready(function(){
	$('#fichero').bootstrapFileInput();

	$("#formRanking").submit(function(evento){
		var form_ok = true;

		if (jQuery.trim($("#nombre").removeClass("input-alert").val()) == ""){
			$('#nombre').addClass("input-alert").attr("placeholder", $('#nombre').data("alert")).focus();
			form_ok = false;
		}
		
		return form_ok;
	});
});