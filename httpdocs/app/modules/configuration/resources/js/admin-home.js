// JavaScript Document
jQuery(function($) {

	getPanels();

	function getPanels(){
		$.ajax({
			type: 'POST',
			url: 'app/modules/configuration/pages/admin-home-ajax.php',
			cache: false,
			data: {"action" : "panels"},
			// Mostramos un mensaje con la respuesta de PHP
			success: function(data) {
				$(".panelsSelect").html(data);
			}
		})
	}

	var panelList = $('.draggablePanelList');
	panelList.sortable({
		handle: '.panel-heading'
	});

	var panelRow = $('.draggableContainer');
	panelRow.sortable({
		// Only make the .draggablePanelListHeader child elements support dragging.
		// Omit this to make then entire panel draggable.
		handle: '.draggablePanelListHeader', 
		update: function() {
			$('.draggablePanelList', panelRow).each(function(index, elem) {
				$(elem).data("row", index);				
			});
		}
	});

	$(".plus").click(function(e){
		e.preventDefault();
		var elem_container = $(this).data("dest"),
			valor = parseInt($(elem_container).data("colsn"));

		if (valor < 12) $(elem_container).removeClass('col-md-' + valor).addClass('col-md-' + (valor + 1)).data("colsn", (valor + 1));
	});

	$(".minus").click(function(e){
		e.preventDefault();
		var elem_container = $(this).data("dest"),
			valor = parseInt($(elem_container).data("colsn"));

		if (valor > 1) $(elem_container).removeClass('col-md-' + valor).addClass('col-md-' + (valor - 1)).data("colsn", (valor - 1));
	});

	$("#saveTemplate").click(function(e){
		e.preventDefault();
		$.ajax({
			type: 'POST',
			cache: false,
			url: 'app/modules/configuration/pages/admin-home-ajax.php',
			data: {"action" : "init"},
			success: function(data){
				$(".draggableContainer .draggablePanelList .container-drop").each(function(index, el){
					var namepanel = $(this).data("namepanel"),
						numCols = $(this).data("colsn"),
						numRow = $(this).parent().data("row"),
						numPos = (index + 1);

					$.ajax({
						type: 'POST',
						cache: false,
						url: 'app/modules/configuration/pages/admin-home-ajax.php',
						data: {"panel_name" : namepanel, "panel_cols": numCols, "panel_pos": numPos, "panel_row": numRow},
						success: function(data) {
						}
					})
				});

				swal({
					title: "Home",
					text: "Datos guardados.",
					type: "success",
					confirmButtonColor: "#000",
					confirmButtonText: "Cerrar"
				});				
			}
		})
	});

	$(".panelPlus").click(function(e) {
		e.preventDefault()
		var panelAdd = $(this).parent().prev().find('.panelsSelect').val(),
			panelDestino = $(this).parent().parent().next(".draggablePanelList");

		$("." + panelAdd).appendTo(panelDestino).toggle( "fade" ).removeClass('hidden');
		$(".panelsSelect option[value='" + panelAdd + "']").remove();
		$("#oculto-" + panelAdd).remove();
	});

	$(".panelDelete").click(function(e){
		e.preventDefault();
		var elem_container = $(this).data("dest"),
			elem_container = $(elem_container),
			namepanel = elem_container.data("namepanel");

		elem_container.toggle( "explode" ).appendTo('#container-invisibles').addClass("hidden");
		$('.panelsSelect').append($('<option>', {
			value: namepanel,
			text: namepanel
		}));

		$('#lista-invisibles').append($('<li>', {
			id: "oculto-" + namepanel,
			text: namepanel
		}));
	});

	$("#addRow").click(function(e) {
		e.preventDefault()
		var elems = $("#container-rows-invisibles .draggablePanelContainer.hidden"),
			numRows = elems.length;
		if (numRows == 1){
			$(this).addClass('disabled');
		}
		else if(numRows > 1){
			elems.each(function(index, el) {
				if (index == 0) $(this).appendTo($(".draggableContainer")).toggle( "fade" ).removeClass('hidden');
			});
		}
	});

	$(".deleteRow").click(function(e) {
		e.preventDefault()
		var panels = $(this).parent().parent().next(".draggablePanelList").find(".container-drop"),
			container = $(this).parent().parent().parent();
		panels.appendTo('#container-invisibles').addClass("hidden").each(function(index) {
			var namepanel = $(this).data("namepanel");
			$('.panelsSelect').append($('<option>', {
				value: namepanel,
				text: namepanel
			}));

			$('#lista-invisibles').append($('<li>', {
				id: "oculto-" + namepanel,
				text: namepanel
			}));
		});

		$("#addRow").removeClass("disabled");
		container.toggle( "explode" ).appendTo('#container-rows-invisibles').addClass('hidden');
	});
});