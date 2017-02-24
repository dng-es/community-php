jQuery(document).ready(function(){
	$(".numeric").numeric(false);
	$(".double").numeric();

	$("#configForm").submit(function(event){
		/* Validaciones */
		$('#configForm-result').html("").css("display", "none");

		var form_ok = true;
/*		if (jQuery.trim($("#respuesta-texto").val())=="") {
			 $("#respuesta-alert").html("Debes intruducir algo de texto.")
			 				.fadeIn()
			 				.css("display","block");
			 form_ok=false;
		}*/

		if (form_ok){
			$.ajax({
				type: 'POST',
				url: 'app/modules/configuration/pages/admin-modules-ajax-process.php',
				data: $('#configForm').serialize(),
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					$('#configForm-result').html(data).fadeIn();
				}
			})
		}

		return false;
	});
});