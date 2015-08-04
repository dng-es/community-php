// JavaScript Document
jQuery(document).ready(function(){
	$(".connect-as").click(function(e){
		e.preventDefault();
		var user = $(this).data("u"),
			pass = $(this).data("p");
		swal({
			title: "¿Estas seguro?",
			text: "¿Estás seguro de conectar como el usuario " + user + "?,\n perderás la sesión actual.",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			cancelButtonText: "Cancelar",
			confirmButtonText: "Confirmar",
			closeOnConfirm: false
		},
		function(){
			$.ajax({
				type: 'POST',
				async: false,
				url: 'home',
				data:{"form-login-user": user, "form-login-password": pass},
				success: function(data) {
					location.href = "login";
				}
			});
		});
	});
});