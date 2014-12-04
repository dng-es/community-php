jQuery(document).ready(function(){
	showMuro();
	var timer = setInterval( showMuro, 10000);
	
	function showMuro(){
		  $("#cargando").css("display", "inline");
		  $("#destino").load("app/modules/muro/pages/muro.php", {nombre: "Pepe",edad: 45}, function(){
		  $("#cargando").css("display", "none");
	   });
	}
})