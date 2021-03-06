<?php
templateload("cmbCanales", "users");

/**
 * Print HTML upload video form
 * @param	Int 		$id_promocion		ID de la promocion a la que pertenece el video
 * @return	String							HTML form
 */
function PanelSubirVideo($id_promocion = 0){
	$module_config = getModuleConfig("videos"); ?>
	<h4>
		<span class="fa-stack fa-sx">
			<i class="fa fa-circle fa-stack-2x"></i>
			<i class="fa fa-share-alt fa-stack-1x fa-inverse"></i>
		</span>
		<?php e_strTranslate("Upload_video"); ?>
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
			<?php ComboCanales(); ?>
		</select>
		<?php endif; ?>
		<label for="etiquetas" class="sr-only">Introduce las etiquetas de la foto:</label>
		<input type="text" name="etiquetas" id="etiquetas" class="form-control" value="" placeholder="Etiquetas (separadas por coma)" />
		<label for="nombre-foto" class="sr-only">Video:</label>
		<input type="file" class="btn btn-default btn-block" name="nombre-video" id="nombre-video" title="<?php e_strTranslate("Choose_file");?>" />
		<div class="alert alert-danger" id="alertas-participa" style="display: none"><?php e_strTranslate("Required_all_fields");?></div>
		<button type="submit" class="btn btn-primary btn-block" id="video-submit" name="video-submit"><?php e_strTranslate("Send_video");?></button>
	</form>
	<div id="cargando" style="background-color: red;display:none">cargando....</div>
<?php } ?>