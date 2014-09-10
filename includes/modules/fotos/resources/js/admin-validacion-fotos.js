jQuery(document).ready(function(){
	$(".abrir-modal").click(function(event) {
		event.preventDefault()
		$(this).next("div .modal").modal();
	});

	$(".trigger-validar").click(function(event) {		
		var id_file = $(this).attr("data-id"),
			id_album = $("#nombre_album_" + id_file).val(),
			user_add = $(this).attr("data-user");
		if (id_album > 0){
			Confirma('¿Seguro que desea validar la foto?', '?page=admin-validacion-fotos&act=foto_ok&id=' + id_file + '&ida=' + id_album + '&u=' + user_add);
		}
		else{
			alert("Debes seleccionar un album para la foto");
		}
	});
	
});