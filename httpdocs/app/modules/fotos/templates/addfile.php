<?php
templateload("cmbCanales", "users");

function PanelSubirFoto($id_promocion = 0, $albumes = null, $id_album = 0){

	$module_config = getModuleConfig("fotos");
	if ($module_config['options']['allow_uploads'] == true or $_SESSION['user_perfil'] == 'admin'){?>
	<h4>
		<span class="fa-stack fa-sx">
			<i class="fa fa-circle fa-stack-2x"></i>
			<i class="fa fa-share-alt fa-stack-1x fa-inverse"></i>
		</span>
		<?php e_strTranslate("Upload_photo");?>
	</h4>
	<p><?php e_strTranslate("Upload_photo_formats_allowed");?> <b>GIF</b>, <b>PNG,</b> o <b>JPG</b>. <?php e_strTranslate("Upload_photo_max_size_allowed");?> <b><?php echo MAX_SIZE_FOTOS_KB;?> Kb</b></p>

	<form id="foto-form" name="foto-form" action="" method="post" enctype="multipart/form-data" role="form">
		<input type="hidden" name="id_promocion" id="id_promocion" value="<?php echo $id_promocion;?>"/>
		<input type="hidden" name="tipo_envio" id="tipo_envio" value="foto"/>
		<input maxlength="250" name="titulo-foto" id="titulo-foto" type="text" class="form-control" value="" placeholder="<?php e_strTranslate("Photo_title");?>" />
		<?php //if ($_SESSION['user_canal'] == 'admin'):?>
		<!--<select name="canal-foto" id="canal-foto" class="form-control">-->
			<?php //ComboCanales()?>
		<!--</select>-->
		<?php //endif;?> 
		<?php if (($module_config['options']['allow_users_albums'] == true) and $albumes != null): 
			if ($id_album == 0):
				ComboAlbumes(0, $albumes, "id_album"); ?>
				<!--<p>Para crear un nuevo album pincha <a href="#" id="createAlbum">aquí</a></p>-->
			<?php else: ?>
				<input type="hidden" name="nombre_album" id="nombre_album" value="<?php echo $id_album;?>" />
			<?php endif;
		endif;
		?>
		
		<label for="etiquetas" class="sr-only">Introduce las etiquetas de la foto:</label>
		<input type="text" name="etiquetas" id="etiquetas" class="form-control" value="" placeholder="Etiquetas (separadas por coma)" />
		<input type="file" class="btn btn-default btn-block" name="nombre-foto" id="nombre-foto" title="<?php e_strTranslate("Choose_file");?>" />
		<div class="alert alert-danger" id="alertas-participa" style="display: none"><?php e_strTranslate("Required_all_fields");?></div>
		<button type="submit" class="btn btn-primary btn-block" id="foto-submit" name="foto-submit"><?php e_strTranslate("Send_photo");?></button>
		<!--<br /><h3 class="text-muted">Etiquetas existentes</h3>-->
		<div class="tags">
		<?php
		$fotos = new fotos();
		$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND canal_album LIKE '%".$_SESSION['user_canal']."%' " : "");
		$tags = $fotos->getTags($filtro_canal); //print_r($tags);
		$valor_max = max($tags);
		$valor_min = min($tags);
		$diferencia = $valor_max - $valor_min;

		//ordeno el array
		ksort($tags);

		foreach(array_keys($tags) as $key){
			$valor_relativo = round((($tags[$key] - $valor_min) / $diferencia) * 10);
			echo '<a href="fotos?tag='.$key.'" class="tag'.$valor_relativo.'">'.$key.'</a> ';
		}

		?>
		</div>
	</form>
	<?php }?>
<?php }?>