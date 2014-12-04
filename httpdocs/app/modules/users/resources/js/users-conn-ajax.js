$(document).ready(function(){   
   cargarUsersConn();




	// $(".users-connected").scroll(function(){		
	// 	if ($(this).scrollTop() == (450*pagina_conn)){
	// 		pagina_conn++;
	// 		cargarUsersConn();
	// 	}
	// });	

	$('.users-connected').bind('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight) {
            alert('end reached');
            pagina_conn++;
	 		cargarUsersConn();
        }
    })

})

	var pagina_conn=1;
	function cargarUsersConn(){
		$("#cargando-users-conn").css("display", "inline-block");
		$.get("app/modules/users/pages/users-conn-ajax.php?pagina="+pagina_conn + "&ms=" + new Date().getTime(),
		function(data){
			if (data != "") {
			$(".mensaje:last").before(data);
			var destino= "#users-connected-"+pagina_conn;
			$("#cargando-users-conn").css("display", "none");
			$(destino).fadeIn();
			}
		});
	}