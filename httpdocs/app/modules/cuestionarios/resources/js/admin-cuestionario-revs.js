jQuery(document).ready(function(){
	$(".entero").numeric();
	$("#btn_search").click(function(){
		$("#frm_search").submit();
	});
});

function createDialog(id_cuestionario, usuario){
	$.ajax({
		type: 'POST',
		url: 'app/modules/cuestionarios/pages/admin-cuestionario-revs-ajax.php',
		data: {cuestionario:id_cuestionario, user:usuario},
		// Mostramos un mensaje con la respuesta de PHP
		success: function(data){
			errorDias=data;
				$(".modal-resp .modal-body").html(data);
				$(".modal.modal-resp").modal();
		}
	});
}