jQuery(document).ready(function(){
	$("#FinalizarForm").click(function(evento){
		swal({
			title: "¿Estas seguro?",
			text: "¿Seguro que deseas finalizar el cuestionario?.",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			cancelButtonText: "Cancelar",
			confirmButtonText: "Confirmar",
			closeOnConfirm: false
		},
		function(){
			$("#type-save").val("1");
			$("#formTarea").submit();
		});
	});
});