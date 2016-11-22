jQuery(document).ready(function(){
	$(".btn-status").click(function(){
		var id_order = $(this).data("ido");
		var form_name = "#form-status-" + id_order;
		swal({
			title: "¿Estas seguro?",
			text: "¿Seguro que deseas cambiar el estado?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			cancelButtonText: "Cancelar",
			confirmButtonText: "Confirmar",
			closeOnConfirm: false
		},
		function(){
			$(form_name).submit();
		});
	})
});