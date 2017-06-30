jQuery(window).load(function(){

	$(document).on("click", '.category', function(e){
		e.preventDefault();

		$("#content-ajax").css("display", "none");

		var guide = $(this).data("guide"),
			category = $(this).data("category"),
			subcategory = $(this).data("subcategory"),
			target = $(this).data("target"),
			id = '#' + $(this).attr("id");

		$('.h-d').each(function(){
			if(!$(this).hasClass( "invisible" )){
				$(this).addClass( "invisible" );
				$(this).parent().find('.active').removeClass('active');
			}
		});

		$.ajax({
			type: 'POST',
			cache: false,
			url: 'app/modules/guides/pages/guides-ajax.php',
			data: {"guide" : guide, "category" : category, "subcategory" : subcategory},
			// Mostramos un mensaje con la respuesta de PHP
			success: function(data) {
				$('#content-ajax').html(data).fadeIn();
				if($(id).closest('.angle')){
					$(id).addClass('active').parent().find('.angle').removeClass('invisible');
				}
				$(".menu-hidden-container").css({"height" : $("#container-content").outerHeight()});
			}
		})
	});

	$(document).on("click", '.category2', function(e){
		e.preventDefault();

		$("#content-ajax").css("display", "none");

		var guide = $(this).data("guide"),
			category = $(this).data("category"),
			subcategory = $(this).data("subcategory"),
			target = $(this).data("target"),
			id = '#' + $(this).attr("id");

		$('.h-d-2').each(function(){
			if(!$(this).hasClass("invisible")){
				$(this).addClass("invisible");
				$(this).parent().find('.active').removeClass('active');
			}
		});

		$.ajax({
			type: 'POST',
			cache: false,
			url: 'app/modules/guides/pages/guides-ajax.php',
			data: {"guide" : guide, "category" : category, "subcategory" : subcategory},
			// Mostramos un mensaje con la respuesta de PHP
			success: function(data) {
				$('#content-ajax').html(data).fadeIn();
				if($(id).closest('.angle-2')){
					$(id).addClass('active').parent().find('.angle-2').removeClass('invisible');
				}
				$(".menu-hidden-container").css({"height" : $("#container-content").outerHeight()});
			}
		})
	});

	$(document).on("submit", '.form_subcategory', function(e){
		e.preventDefault();

		var guide = $(this).data("guide"),
			category = $(this).data("category"),
			subcategory = $(this).data("subcategory"),
			id_button = '#b' + $(this).attr("id"),
			id_alert = '#a' + $(this).attr("id"),
			id_radio_0 = '#no_' + $(this).attr("id"),
			id_radio_1 = '#yes_' + $(this).attr("id"),
			id_form = '#' + $(this).attr("id"),
			resultado_ok = true;

		if (jQuery.trim($(id_radio_0 + ":checked").val()) == "" && jQuery.trim($(id_radio_1 + ":checked").val()) == ""){
			$(id_alert).fadeIn().css("display", "block");
			resultado_ok = false;
		}

		$(id_alert).delay(2000).fadeOut('slow');

		if(resultado_ok == true){
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
				$.ajax({
					type: 'POST',
					cache: false,
					url: 'app/modules/guides/pages/guides-ajax.php',
					data: $(id_form).serialize(),
					// Mostramos un mensaje con la respuesta de PHP
					success: function(data) {
						var response = $.parseJSON(data)
						if($('.user_can_modify').val() == false || $('.user_can_modify').val() == ''){
							$(id_button).remove();
						}

						swal({
							title: response.title,
							text: response.description,
							type: response.message,
							showCancelButton: true,
							cancelButtonText: "Cancelar",
							closeOnConfirm: true
						})
					}
				})
			});
		}
	});

	$(".tipo_guia").change(function(e){
		e.preventDefault();
		cargaIni($('.tipo_guia').val());
	});

	cargaIni($("#guiaIni").val());

	function cargaIni(tipo_guia){
		$('.context-ajax-ini').load('app/modules/guides/pages/guides-ajax.php', {"tipo_guia": tipo_guia}, function(){
			$('#content-ajax').html('');
		});
	}
});