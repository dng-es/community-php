jQuery(document).ready(function(){
	$("#batalla-puntos").numeric();

	function envio() {
		$("#form-batalla").submit(function(e){

			$("#cargando").show();
			$("#batalla-btn").prop('disabled', true);
			e.preventDefault();
					
			$.ajax({
				type: 'POST',
				url: 'app/modules/batallas/pages/batallas_crear.php',
				data: $('#form-batalla').serialize(),
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					$("#cargando").hide();
					$('#BatallaModal').modal();
					$('#BatallaModal .modal-body').html(data);

				}
			});
		});
	}

	$("#batalla-go-btn").click(function(){
		$("#batalla-btn").prop('disabled', false);
	});

	$("#batalla-btn").click(function(){
		envio();
	});

	$("#BatallaModal .close").click(function(){
		$("#batalla-btn").prop('disabled', false);
	});

	
	$(".jugar-batalla").click(function(e){

		e.preventDefault();
		var id = $(this).data("id");
		//var tipo = $(this).data("c");

		$.ajax({
			type: 'POST',
			url: 'app/modules/batallas/pages/batallas_jugar.php',
			data: {"id": id},
			// Mostramos un mensaje con la respuesta de PHP
			success: function(data) {
				$('#BatallaModal').modal();
				$('#BatallaModal .modal-body').html(data);

			}
		});
	});	

	posicionarLegend();

	$(window).resize(function(){
		posicionarLegend();		
	});

	function posicionarLegend(){
		var anchoVentana = $(document).width();
		if (anchoVentana > 991){ 
			var posLegend = $(".user-perfil-containner").outerHeight() + 30
				heightlegend = $(".complementos-legend").outerHeight();
			$("#col-avatar").css({"height" : posLegend + heightlegend});
			$(".complementos-legend").css({"bottom": "10px", "position": "absolute", "widht" : "80%", "margin-left" : "35%"});
		}
		else{
			$(".complementos-legend").css({"position": "relative", "bottom": "0", "widht" : "100%", "margin-left" : "0%"});	
		}
	}	

});