// JavaScript Document
jQuery(function($) {
	var panelList = $('.draggablePanelList');

	panelList.sortable({
		// Only make the .panel-heading child elements support dragging.
		// Omit this to make then entire <li>...</li> draggable.
		handle: '.panel-heading', 
		update: function() {
			$('.panel', panelList).each(function(index, elem) {
				 var $listItem = $(elem),
					 newIndex = $listItem.index();

				// Persist the new indices.
			});
		}
	});
	
	$(".plus").click(function(e){
		e.preventDefault();
		//var elem_container = $(this).parent().parent().parent().parent(),
		var elem_container = $(this).data("dest"),
			elem_container = $(elem_container),
			valor = parseInt(elem_container.data("colsn"));
		if (valor < 13){
			elem_container.removeClass('col-md-' + valor).addClass('col-md-' + (valor + 1));
			elem_container.data("colsn", (valor + 1));
			//jQuery.data( elem_container, "colsn", (valor + 1) );
		}
	});

	$(".minus").click(function(e){
		e.preventDefault();
		//var elem_container = $(this).parent().parent().parent().parent(),
		var elem_container = $(this).data("dest"),
			elem_container = $(elem_container),
		valor = parseInt(elem_container.data("colsn"));
		if (valor > 0){
			elem_container.removeClass('col-md-' + valor).addClass('col-md-' + (valor - 1));
			elem_container.data("colsn", (valor - 1));
			//jQuery.data( elem_container, "colsn", (valor - 1) );
		}
	});


	$("#saveTemplate").click(function(e){
		e.preventDefault();

		//borrar datos
		$.ajax({
			type: 'POST',
			cache: false,
			url: 'app/modules/configuration/pages/admin-home-ajax.php',
			data: {"action" : "init"},
			// Mostramos un mensaje con la respuesta de PHP
			success: function(data) {
				//alert("datos guardados");
			}
		})

		$(".draggableContainer .draggablePanelList .container-drop").each(function(index, el) {
			//console.log(index + $(this).data("namepanel"));

			var namepanel = $(this).data("namepanel"),
				numCols = $(this).data("colsn"),
				numRow = $(this).parent().data("row"),
				numPos = (index + 1);

			$.ajax({
				type: 'POST',
				cache: false,
				url: 'app/modules/configuration/pages/admin-home-ajax.php',
				data: {"panel_name" : namepanel, "panel_cols": numCols, "panel_pos": numPos, "panel_row": numRow},
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					//alert("datos guardados");
				}
			})
		});
		alert("datos guardados");
	});

	getPanels();

	function getPanels(){
		//borrar datos
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

	$(".panelPlus").click(function(e) {
		e.preventDefault()
		var panelAdd = $(this).parent().prev().find('.panelsSelect').val(),
			panelDestino = $(this).parent().parent().next(".draggablePanelList");

		$("." + panelAdd).appendTo(panelDestino).toggle( "fade" ).removeClass('hidden');
		$(".panelsSelect option[value='" + panelAdd + "']").remove();
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
		});

		$("#addRow").removeClass("disabled");
		container.toggle( "explode" ).appendTo('#container-rows-invisibles').addClass('hidden');
	});
});