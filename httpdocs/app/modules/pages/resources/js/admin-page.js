jQuery(document).ready(function(){
	$(".numeric").numeric();
	
	$("#formData").submit(function(evento){
		$(".alert-message").html("").css("display", "none");
		var form_ok = true;
		return form_ok;
	});
});