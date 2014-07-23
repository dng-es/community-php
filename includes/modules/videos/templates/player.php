<?php
function playVideo($id_contenedor,$nombre_video,$ancho_video,$alto_video,$controlBar = "bottom",$autostart=false){
	echo'<div style="background-color: #000; color: #FFF;">
	<div id="'.$id_contenedor.'">Cargando video ...</div> 
	<script type="text/javascript"> 
	jwplayer("'.$id_contenedor.'").setup({ 
	    file: "'.$nombre_video.'", 
	    image: "'.$nombre_video.'.jpg", 
	    width: "100%",
			aspectratio: "16:9",
	    autostart: "'.$autostart.'"
	}); 
	</script>
	</div>';	  
}
?>