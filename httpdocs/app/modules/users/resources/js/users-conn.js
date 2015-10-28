$(document).ready(function(){
	cargardatos();
})

var pagina = 1;
function cargardatos(){
	$("#cargando").css("display", "inline-block");
	$.get("app/modules/users/pages/users-conn-data.php?pagina=" + pagina,
	function(data){
		if (data != ""){
			$(".mensaje:last").before(data);
			var destino = "#users-connected-" + pagina;
			$("#cargando").css("display", "none");
			$(destino).fadeIn();
		}
	});
}

$(window).scroll(function(){
	if ($(window).scrollTop() == $(document).height() - $(window).height()){
		pagina++;
		cargardatos();
	}
});	