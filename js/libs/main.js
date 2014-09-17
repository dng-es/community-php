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

	//desplegar menu administración activo
	$(".module-admin-item li a.active").closest(".module-admin-item").show();

	$(window).scroll(function() {
		var screenWidth = $(window).width();
		if (screenWidth>991){
			//console.log($("#admin-panel").offset().top);
			if ($(window).scrollTop() > ($('#page-content-wrapper').outerHeight()) - ($('#container-content').outerHeight() + $('.footer').outerHeight())){
				//console.log("ENTRA: " + $(window).scrollTop() + " PAGE: " + $('#page-content-wrapper').outerHeight() + " CONTENT: " + $('#container-content').outerHeight());
				$("#admin-panel").css({"position": "fixed","top" : 0, "right": "-11px"});
			} else {
				//console.log("NO ENTRA: " + $(window).scrollTop() + " PAGE: " + $('#page-content-wrapper').outerHeight() + " CONTENT: " + $('#container-content').outerHeight());
				$("#admin-panel").css({"position": "relative","top" : 0, "right": 0});
			}
		}
	});
});