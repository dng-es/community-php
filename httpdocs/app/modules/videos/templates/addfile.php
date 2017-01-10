<?php
templateload("cmbCanales", "users");

function PanelSubirVideo($id_promocion = 0){
	$module_config = getModuleConfig("videos");
	$module_channels = getModuleChannels($module_config['channels'], $_SESSION['user_canal']);
	$filter_videos = ($_SESSION['user_canal'] == 'admin' ? "" : " AND (v.canal IN (".$module_channels.") OR v.canal='') ");
	if ($module_config['options']['allow_uploads'] == true or $_SESSION['user_canal'] == 'admin'){?>
	<h4>
		<span class="fa-stack fa-sx">
			<i class="fa fa-circle fa-stack-2x"></i>
			<i class="fa fa-share-alt fa-stack-1x fa-inverse"></i>
		</span>
		<?php e_strTranslate("Upload_video");?>
	</h4>
	<p><?php e_strTranslate("Upload_video_formats_allowed");?> <b>MP4, MOV, AVI, 3GP, WMV</b>. <?php e_strTranslate("Upload_video_max_size_allowed");?> <b><?php echo MAX_SIZE_VIDEOS_KB;?> Kb</b>.</p>
	<form id="video-form" name="video-form" action="" method="post" enctype="multipart/form-data" role="form">
		<input type="hidden" name="id_promocion" id="id_promocion" value="<?php echo $id_promocion;?>" />
		<input type="hidden" name="tipo_envio" id="tipo_envio" value="video" />
		<label for="titulo-video" class="sr-only"><?php e_strTranslate("Title");?>:</label>
		<input maxlength="250" name="titulo-video" id="titulo-video" type="text" class="form-control" value="" placeholder="<?php e_strTranslate("Video_title");?>" />
		<?php if ($_SESSION['user_canal'] == 'admin'): ?>
		<label for="canal-video" class="sr-only">Canal:</label>
		<select name="canal-video" id="canal-video" class="form-control">
			<?php ComboCanales();?>
		</select>
		<?php endif;?>
		<label for="etiquetas" class="sr-only">Introduce las etiquetas de la foto:</label>
		<input type="text" name="etiquetas" id="etiquetas" class="form-control" value="" placeholder="Etiquetas (separadas por coma)" />
		<label for="nombre-foto" class="sr-only">Video:</label>
		<input type="file" class="btn btn-default btn-block" name="nombre-video" id="nombre-video" title="<?php e_strTranslate("Choose_file");?>" />
		<div class="alert alert-danger" id="alertas-participa" style="display: none"><?php e_strTranslate("Required_all_fields");?></div>
		<button type="submit" class="btn btn-primary btn-block" id="video-submit" name="video-submit"><?php e_strTranslate("Send_video");?></button>
		<br /><span class="text-muted">Etiquetas existentes: </span>
		<div class="tags">
		<?php
		$videos = new videos();
		$tags = $videos->getTags($filter_videos); //print_r($tags);
		$valor_max = max($tags);
		$valor_min = min($tags);
		$diferencia = $valor_max - $valor_min;

		//ordeno el array
		ksort($tags);

		//$separator = (strpos($_SERVER['REQUEST_URI'], "?") == 0  ? "?" : "&");
		//$enlace = (isset($_REQUEST['id']) and $_REQUEST['id'] > 0) ? "&id": "?";

		foreach(array_keys($tags) as $key){
			$valor_relativo = round((($tags[$key] - $valor_min) / $diferencia) * 10);
			echo '<a href="videos?tag='.$key.'" class="tag'.$valor_relativo.'">'.$key.'</a> ';
		}

		?>
		</div>
	</form>
	<div id="cargando" style="background-color: red;display:none">cargando....</div>
	<?php }?>
<?php }?>