<?php
function PanelSubirFoto($id_promocion=0){ 

	$module_config = getModuleConfig("fotos");
	if ($module_config['options']['allow_uploads']==true or $_SESSION['user_perfil']=='admin'){
	?>

	<h4>
		<span class="fa-stack fa-sx">
			<i class="fa fa-circle fa-stack-2x"></i>
			<i class="fa fa-share-alt fa-stack-1x fa-inverse"></i>
		</span>
		<?php echo strTranslate("Upload_photo");?>
	</h4>
	<p><?php echo strTranslate("Upload_photo_formats_allowed");?> <b>GIF</b>, <b>PNG,</b> o <b>JPG</b>. <?php echo strTranslate("Upload_photo_max_size_allowed");?> <b><?php echo MAX_SIZE_FOTOS_KB;?> Kb</b></p>
	<form id="foto-form" name="coment-form" action="" method="post" enctype="multipart/form-data" role="form">
		<input type="hidden" name="id_promocion" id="id_promocion" value="<?php echo $id_promocion;?>"/>
		<input type="hidden" name="tipo_envio" id="tipo_envio" value="foto"/>
		<input maxlength="250" name="titulo-foto" id="titulo-foto" type="text" class="form-control" value="" placeholder="<?php echo strTranslate("Photo_title");?>" />
		<?php if ($_SESSION['user_perfil']=='admin' or $_SESSION['user_perfil']=='formador'):?>
		<select name="canal-foto" id="canal-foto" class="form-control">
			<?php ComboCanales()?>
		</select>
		<?php endif;?>
		<input type="file" class="btn btn-default btn-block" name="nombre-foto" id="nombre-foto" title="<?php echo strTranslate("Choose_file");?>" />
		<div class="alert alert-danger" id="alertas-participa" style="display: none"></div>
		<button type="button" class="btn btn-primary btn-block" id="foto-submit" name="foto-submit"><?php echo strTranslate("Send_photo");?></button>
	</form>
	<?php } ?>
<?php } ?>