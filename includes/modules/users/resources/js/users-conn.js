$(document).ready(function(){
	$("#EnviarForm").button({icons: {primary: "ui-icon-mail-closed"}});
	$(".comunidad-panel").fadeIn(1000);	   
	cargardatos();
})

var pagina=1;
function cargardatos(){
	$("#cargando").css("display", "inline-block");
	$.get("includes/modules/users/pages/users-conn-data.php?pagina="+pagina,
	function(data){
		if (data != "") {
		$(".mensaje:last").before(data);
		var destino= "#users-connected-"+pagina;
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