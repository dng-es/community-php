$(document).ready(function(){   
   cargarUsersConn();
})

var pagina_conn=1;
function cargarUsersConn(){
	$("#cargando-users-conn").css("display", "inline-block");
	$.get("includes/modules/users/pages/users-conn-ajax.php?pagina="+pagina_conn + "&ms=" + new Date().getTime(),
	function(data){
		if (data != "") {
		$(".mensaje:last").before(data);
		var destino= "#users-connected-"+pagina_conn;
		$("#cargando-users-conn").css("display", "none");
		$(destino).fadeIn();
		}
	});
}

$("#mensajes-users-conn").scroll(function(){		
	if ($(".mensajes-users-conn").scrollTop() == (450*pagina_conn)){
		pagina_conn++;
		cargarUsersConn();
	}
});	