jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();
	
	$("#inputFile").click(function(evento){
		$(".alert-message").css("display","none");

		var form_ok = true;
		// if (jQuery.trim($("#nombre-fichero").val())=="") 
		// {
		// 	 $("#fichero-alert").fadeIn().css("display","block");
		// 	 form_ok=false;
		// }				
		if (form_ok == true){
			$("#formImport").submit();
		}
	});

	$(".entero").numeric();
	$("#btn_search").click(function(){
		$("#frm_search").submit();
	});
});

function createDialog(id_tarea,usuario){
	$.ajax({
		type: 'POST',
		url: 'app/modules/na_areas/pages/admin-area-revs-form.php',
		data: {tarea:id_tarea, user:usuario},
		// Mostramos un mensaje con la respuesta de PHP
		success: function(data) {
			errorDias = data;
			$(".modal-resp .modal-body").html(data);
			$(".modal.modal-resp").modal();
		}
	});
}