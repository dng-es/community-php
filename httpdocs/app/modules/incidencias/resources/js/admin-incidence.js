// JavaScript Document
jQuery(document).ready(function(){

	$("#cancelarBtn").click(function(evento){
		evento.preventDefault();
		swal({
			title: "Confirmación de cambio de estado",
			text: "¿Seguro que deseas cancelar la incidencia?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			cancelButtonText: "Cancelar",
			confirmButtonText: "Confirmar",
			closeOnConfirm: false
		},
		function(){
			$("#formData").attr('action', 'admin-incidence?a=2').submit();
		});
	});

	$("#finalizarBtn").click(function(evento){
		evento.preventDefault();
		swal({
			title: "Confirmación de cambio de estado",
			text: "¿Seguro que deseas finalizar la incidencia?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			cancelButtonText: "Cancelar",
			confirmButtonText: "Confirmar",
			closeOnConfirm: false
		},
		function(){
			$("#formData").attr('action', 'admin-incidence?a=1').submit();
		});
	});

	$("#pendienteBtn").click(function(evento){
		evento.preventDefault();
		swal({
			title: "Confirmación de cambio de estado",
			text: "¿Seguro que deseas poner pendiente la incidencia?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			cancelButtonText: "Cancelar",
			confirmButtonText: "Confirmar",
			closeOnConfirm: false
		},
		function(){
			$("#formData").attr('action', 'admin-incidence?a=0').submit();
		});
	});		
});