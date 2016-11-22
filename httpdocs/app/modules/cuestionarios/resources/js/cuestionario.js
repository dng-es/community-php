jQuery(document).ready(function(){	
	$("#FinalizarForm").click(function(){
		swal({
			title: "¿Estas seguro?",
			text: "¿Seguro que desea finalizar el cuestionario?.\nRecuerda  que previamente tienes que guardar tus respuestas.",
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
	})
});