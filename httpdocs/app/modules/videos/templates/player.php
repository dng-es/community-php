<?php
/**
 * Show video player
 * @param	String		$id_contenedor	Id del contenedor del video
 * @param	String		$nombre_video	Nombre del video a reproducir
 * @param	double		$ancho_video	Ancho del reproductor
 * @param	double		$alto_video		Alto del reproductor
 * @param	String		$controlBar		Posición de la barra de controles
 * @param	Boolean		$autostart		Indica si el video se reproduce de inicio
 * @param	int			$id_file		Id del video a reproducir
 * @return								JS video player
 */
function playVideo($id_contenedor, $nombre_video, $ancho_video, $alto_video, $controlBar = "bottom", $autostart = false, $id_file = 0){ ?>
	<div class="videoplayer">
		<div id="<?php echo $id_contenedor;?>"><?php e_strTranslate('Loading');?> ...</div> 
		<script type="text/javascript"> 
		jwplayer("<?php echo $id_contenedor;?>").setup({ 
			file: "<?php echo $nombre_video;?>", 
			image: "<?php echo $nombre_video;?>.jpg", 
			width: "100%",
			aspectratio: "16:9",
			autostart: "<?php echo $autostart;?>"
		});

		//REGISTRO DE VISUALIZACION
		jwplayer("<?php echo $id_contenedor;?>").onComplete(function(){
			$.ajax({
				type : "POST",
				url : "app/modules/videos/pages/videos-process.php",
				data : {v : <?php echo $id_file;?>}
			});			
		})

		//BOTON PARA DESCARGAR EL VIDEO
		/*jwplayer("<?php //echo $id_contenedor;?>").addButton(
			//This portion is what designates the graphic used for the button
			"images/download.png",
			//This portion determines the text that appears as a tooltip
			"Download Video", 
			//This portion designates the functionality of the button itself
			function() {
			//With the below code, we're grabbing the file that's currently playing
			window.location.href = jwplayer().getPlaylistItem()['file'];
			},
			//And finally, here we set the unique ID of the button itself.
			"download"
		);*/

		function playerReady(obj){
			var player;
			player = document.getElementById(obj['id']);
			player.addControllerListener("PLAY","registraReproduccion");
		};

		function registraReproduccion(obj){
			var idvideo = obj.id;
			if (obj.state===true){
				idvideo = idvideo.substring(12,idvideo.length);
				$.ajax({
					type : "POST",
					url : "video-reg.php",
					data : {id : idvideo}
				});
			}
		};
		</script>
	</div>
<?php } ?>