jQuery(document).ready(function(){

	$(".user-tip").tooltip({
		placement : 'auto top',
		container: 'body'
	});

	$(".disabled a").click(function(e){
		e.preventDefault();
	});

	$("#menu-toggle").click(function(e){
		e.preventDefault();
		$("#wrapper").toggleClass("active");
	});

	$("#declaracion-trigger").click(function(event){
		event.preventDefault();
		$("#declaracionModal").modal("show");
	});

	$("#policy-trigger").click(function(event){
		event.preventDefault();
		$("#policyModal").modal("show");
	});

	resizeApp();

	$(window).resize(function(){
		resizeApp();
	});

	function resizeApp(){
		var anchoVentana = $(document).width(),
			altoVentana = $(window).height();
		if (anchoVentana > 991){ 
			cargarImagenes();
			$(".row-top").css({"min-height" : altoVentana - ($(".footer").outerHeight() + $("#menu-main").outerHeight() + $(".header-info").outerHeight())})
		}

		updateBackground();
	}

	function cargarImagenes(){
		var pathImg = "";
		$(".nomobile").each(function(){
			pathImg = $(this).attr("data-src");
			$(this).attr("src", pathImg);
		});
	}

	function updateBackground() {
		screenWidth = $(window).width();
		screenHeight = $(window).height();
		var bg = jQuery("#bg");

		// Proporcion horizontal/vertical. En este caso la imagen es cuadrada
		ratio = 1.5;

		if (screenWidth/screenHeight > ratio){
			$(bg).height("auto");
			$(bg).width("100%");
		}
		else{
			$(bg).width("auto");
			$(bg).height("100%");
		}

		// Si a la imagen le sobra anchura, la centramos a mano
		if ($(bg).width() > 0){
		$(bg).css("left", (screenWidth - $(bg).width()) / 2);
		}
	}

	if ($(".msg-flash").length == 1){
		window.sweetAlertInitialize();
		var color_btn = $("a").css("color");
		if ($(".msg-flash").hasClass('alert-success')){
			swal({
				title: "Muy bien!",
				text: $(".msg-flash").html(),
				timer: 3000,
				type: "success",
				confirmButtonColor: color_btn,
				confirmButtonText: "Cerrar"
			});
		}
		else if($(".msg-flash").hasClass('alert-warning')){
			swal({
				title: "Cuidado...",
				text: $(".msg-flash").html(),
				type: "warning",
				confirmButtonColor: color_btn,
				confirmButtonText: "Cerrar"
			});
		}
		else{
			swal({
				title: "Error",
				text: $(".msg-flash").html(),
				type: "error",
				confirmButtonColor: color_btn,
				confirmButtonText: "Cerrar"
			});
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
		var screenWidth = $(window).width(),
			screenHeight = $(window).height();
/*		if (screenWidth>991){
			//console.log($("#admin-panel").offset().top);
			//console.log(screenWidth);
			if ($(window).scrollTop() > ($('#container-main').outerHeight()) - ($('#container-content').outerHeight() + $('.footer').outerHeight())){
				//console.log("ENTRA: " + $(window).scrollTop() + " PAGE: " + $('#container-main').outerHeight() + " CONTENT: " + $('#container-content').outerHeight());
				$("#admin-panel").css({"position": "fixed","top" : 0, "right": 0});
			} else {
				//console.log("NO ENTRA: " + $(window).scrollTop() + " PAGE: " + $('#container-main').outerHeight() + " CONTENT: " + $('#container-content').outerHeight());
				$("#admin-panel").css({"position": "relative","top" : 0, "right": 0});
			}
		}*/

		if ($(this).scrollTop()){
			$('#toTop').fadeIn();
		}
		else{
			$('#toTop').fadeOut();
		}
	});

	$("#toTop").click(function (){
		$("html, body").animate({scrollTop: 0}, 500);
	});

	$("#tienda_go").click(function(e){
		e.preventDefault();
		$('#formGlobalOptions').submit();
	})
});