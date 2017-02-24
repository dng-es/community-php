$(window).load(function() {


	resizePanels();


	$(window).resize(function(){
		resizePanels();
	});

	function resizePanels(){
		var anchoVentana = $(document).width()
		if (anchoVentana < 991){ 
			$('.dinamicRow .card-section').css({"height" : "auto"})
		}
		else{
			$('.dinamicRow').each(function(){

			elems = $(this).find(".card-section");

			elems.jcolumn({
			    //delay: 500,
			    //maxWidth: 767,
			    callback: function (height) {
			        //console.log('La nueva altura máxima es: ' + height);
			    }
			});
		});
		}
	}	

});