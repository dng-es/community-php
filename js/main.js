jQuery(document).ready(function(){
	$("#menu-toggle").click(function(e) {
	    e.preventDefault();
	    $("#wrapper").toggleClass("active");
	});

	$("#declaracion-trigger").click(function(event) {
		event.preventDefault();
		$("#declaracionModal").modal("show");
	});

	$("#policy-trigger").click(function(event) {
		event.preventDefault();
		$("#policyModal").modal("show");
	});	
				
	resizeApp();

	$(window).resize(function(){
		resizeApp();
	});

	function resizeApp(){
		var anchoVentana = $(document).width();
		if (anchoVentana > 991){ cargarImagenes();}				
		updateBackground();
	}

	function cargarImagenes(){
		var pathImg = "";
		$(".nomobile").each(function(){
			pathImg = $(this).attr("data-src");
			$(this).attr("src",pathImg);
		});
	}

	function updateBackground() {
		screenWidth = $(window).width();
		screenHeight = $(window).height();
		var bg = jQuery("#bg");
		
		// Proporcion horizontal/vertical. En este caso la imagen es cuadrada
		ratio = 1;
		
		if (screenWidth/screenHeight > ratio) {
		$(bg).height("auto");
		$(bg).width("100%");
		} else {
		$(bg).width("auto");
		$(bg).height("100%");
		}
		
		// Si a la imagen le sobra anchura, la centramos a mano
		if ($(bg).width() > 0) {
		$(bg).css("left", (screenWidth - $(bg).width()) / 2);
		}
	}


	//Menu administración
	$(".module-admin-header").click(function(e){
		e.preventDefault();
		$(this).next(".module-admin-item").slideToggle();	
	});
});