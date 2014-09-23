<?php
function playVideo($id_contenedor,$nombre_video,$ancho_video,$alto_video,$controlBar = "bottom",$autostart=false){ ?>
	<div style="background-color: #000; color: #FFF;">
		<div id="<?php echo $id_contenedor;?>"><?php echo strTranslate('Loading');?> ...</div> 
		<script type="text/javascript"> 
		jwplayer("<?php echo $id_contenedor;?>").setup({ 
		    file: "<?php echo $nombre_video;?>", 
		    image: "<?php echo $nombre_video;?>.jpg", 
		    width: "100%",
			aspectratio: "16:9",
		    autostart: "<?php echo $autostart;?>"
		}); 
		</script>
	</div>
<?php } ?>