// JavaScript Document
$(document).ready(function(){
	  var capaTrans = $('<div id="modal-window"></div>');
	  var capaModal = $('<div id="modal-window-int"><div class="modal-close modal-close-button" title="Cerrar"></div><div id="modal-content"></div></div>');
	  capaTrans.appendTo(document.body);
	  capaModal.appendTo(document.body);


	  /*Evento click de la clase abrir-modal*/
	  $(".abrir-modal").click(function(e){
		var pos_y=$(this).position().top;
	    e.preventDefault();
		var contenedor = $(this).attr("title");
		contenedor = contenedor.replace(/[ .]/gi,"-");
	    var lanzador = $('#' + contenedor);
	    $("#modal-window-int").data("ventana", lanzador);
	    lanzador.css({"display": "block"});
	    $("#modal-content").after(lanzador);
	    $("#modal-window").css({width: $(document).width(), height: $(document).height(),opacity: 0.8});	
	    $("#modal-window").fadeIn("fast");
	    $("#modal-window-int").fadeIn("fast");
	    $("#modal-window-int").css({
				"top": pos_y-200,
				"left": "50%",
				"display": "block",
				"margin-left": - $("#modal-window-int").width()/2});
	  });	
	  /*Evento click de la clase modal-close*/
	  $(".modal-close").click(function(e){
		e.preventDefault();
		var windowRemove = $("#modal-window-int").data("ventana");
		$("#modal-window").fadeOut(800);
		$("#modal-window-int").slideUp(500, function()
		  { windowRemove.css({"display" : "none"});}
		);
	  });
	  /*Evento resize de la ventana*/
	  $(window).resize(function() {
		$("#modal-window").css({width: $(document).width(), height: $(document).height(),opacity: 0.8});		
	  });
});