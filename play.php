<?php

function reproducirVideo($id_contenedor,$nombre_video,$ancho_video,$alto_video,$controlBar = "bottom",$id_video){
	 echo'<div class="pg_left" style="background-color: #000; color: #FFF; margin-left:4px; width: '.$ancho_video.'px; height:'.$alto_video.'px">
 	<div id="'.$id_contenedor.'">Cargando video ...</div> 
	<script type="text/javascript"> 
        jwplayer("'.$id_contenedor.'").setup({ 
            flashplayer: "./jwplayer/player.swf",
			controlbar: "'.$controlBar.'",
            file: "'.$nombre_video.'", 
            image: "'.$nombre_video.'.jpg", 
            height: '.$alto_video.', 
            width: '.$ancho_video.' 
        });

        jwplayer("'.$id_contenedor.'").onComplete(function(){
            $.ajax({
                type : "POST",
                url : "video-reg.php",
                data : {id : '.$id_video.'}
            });
        });
    </script>
	</div>';
  
}
?>