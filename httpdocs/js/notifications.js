jQuery(document).ready(function(){
function testNotifications(){
  //nos devuelve true si podemos usar notificaciones
  if(window.webkitNotifications || Notification)
    return true;
  return false;
}

function checkPermission(){
  if(window.webkitNotifications && window.webkitNotifications.checkPermission() == 0){
    return true;
  }else if(Notification && Notification.permission == 'granted'){
    return true;
  }
  return false;
}

function requestPermission(){
  //pedimos permiso para mostrar notificaciones
  if(window.webkitNotifications && window.webkitNotifications.checkPermission() != 0){//Chrome
    window.webkitNotifications.requestPermission();
  }else if(Notification && Notification.permission != 'granted'){//Firefox
    Notification.requestPermission();
  }
}
//Con estas tres funciones podemos crear un enlace con id="activar" y crear un evento para él:
$('#activar').click(function(){
	if(testNotifications()){
	    requestPermission();
	}	
})

/*$('#activar').click,function(e){
  if(testNotifications()){
    requestPermission();
  }
}, false);*/

//newNotification("Mensaje Comunidad", "Este es el contenido del mensaje", "");

function newNotification(title, content, img_uri){
/*  if(window.webkitNotifications && checkPermission()){
    var notification = window.webkitNotifications.createNotification(
      img_uri,
      title,
      content
    );
    return notification;
  }else if(Notification && checkPermission()){
    return {
      show: function(){
        new Notification( title,
        {
          body: content,
          iconUrl: img_uri
        });
      }
    }
  }*/

if (Notification) {
	if (Notification.permission !== "granted") {
		Notification.requestPermission()
	}
	var extra = {
		//icon: "http://xitrus.es/imgs/logo_claro.png",
		icon: "../images/logo01.png",
		body: content,
		tag : "primera notificacion"
	}
	var noti = new Notification( title, extra)
}

}	



var source = new EventSource("../demo_sse.php");
var last_id;
source.onmessage = function(event) {
	//newNotification("Mensaje Comunidad", event.data, "");
    //document.getElementById("result").innerHTML += event.data + "<br>";

    var extra = {
		//icon: "http://xitrus.es/imgs/logo_claro.png",
		icon: "../images/logo01.png",
		body: event.data,
		tag : event.id
	}
	var noti = new Notification( "Mensaje Comunidad", extra);
	//source.close();
};


});

