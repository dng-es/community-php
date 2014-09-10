// JavaScript Document
$(function(){
		BT_setOptions({openWait:250, closeWait:0, cacheEnabled:true});
})


jQuery(document).ready(function(){	
	$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animationSpeed:'slow',theme:'facebook',slideshow:4000, autoplay_slideshow: true});
	$(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animationSpeed:'slow',slideshow:50000});

	$("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
		custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
		changepicturecallback: function(){ initialize(); }
	});

	$("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
		custom_markup: '<div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
		changepicturecallback: function(){ _bsap.exec(); }
	});


	$(".trigger-gallery").click(function(){
		var id_album = $(this).attr("data-id"),
			nombre_abum = $(this).attr("data-album");
		$(".modal-body").load("fotos-gallery-ajax.php?id=" + id_album,function(){
			$("#myModalLabel").html(nombre_abum);
			$('#myModal').modal('show');
		})
	});

	resizeGallery();
	$(window).resize(function(event) {
		resizeGallery();
	});

	function resizeGallery(){
		var elem = $(".gallery-container-mini"),
			ancho = elem.width()*(0.7);
		elem.css("height",ancho);
		$(".gallery-container-mini img").css("min-height",ancho);	
	}

});