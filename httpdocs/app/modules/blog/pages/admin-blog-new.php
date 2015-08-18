<?php

addJavascripts(array("js/libs/ckeditor/ckeditor.js", 
					 "js/libs/ckfinder/ckfinder.js", 
					 "js/bootstrap.file-input.js", 
					 getAsset("blog")."js/admin-blog-new.js"));

templateload("cmbCanales","users");
?>
<div class="row row-top">
	<div class="app-main">
		<?php 

		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Blog"), "ItemUrl"=>"admin-blog"),
			array("ItemLabel"=>"Entrada en ".strTranslate("Blog"), "ItemClass"=>"active"),
		));

		$id = (isset($_GET['id']) ? $_GET['id'] : 0);
		session::getFlashMessage( 'actions_message' );
		blogController::createAction();
		blogController::updateAction();
		$elements = blogController::getItemAction($id);

		if (isset($elements[0])){
			$accion = "edit";
			$nombre = $elements[0]['nombre'];
			$descripcion = $elements[0]['descripcion'];
			$tipo_tema = $elements[0]['tipo_tema'];
			$canal = $elements[0]['canal'];
		}
		else{
			$accion = "new";
			$nombre = "";
			$descripcion = "";
			$tipo_tema = "";
			$canal = "";
		}

		?>
		<form id="formData" name="formData" method="post" enctype="multipart/form-data" action="" role="form">
		<input type="hidden" name="id" value="<?php echo $id;?>" />
		<div class="col-md-9">
			<div class="panel panel-default">
				<div class="panel-body">

					<label for="nombre" class="sr-only">Título de la entrada:</label>
					<input type="text" class="form-control form-big" name="nombre" id="nombre" value="<?php echo $nombre;?>" placeholder="título de la entrada" />
					<br />
					<select name="canal" id="canal" class="form-control" <?php echo ($accion=='edit' ? 'disabled="disabled"' : '');?>>
						<?php ComboCanales($canal);?>
					</select>
					<br />
					<label for="descripcion" class="sr-only">Cuerpo de la entrada:</label>
					<textarea cols="40" rows="5" name="descripcion"><?php echo $descripcion;?></textarea>
					<script type="text/javascript">

					var editor=CKEDITOR.replace('descripcion',{customConfig : 'config-page.js'});
					CKFinder.setupCKEditor(editor, 'js/libs/ckfinder/') ;

					</script>
					
				</div>
			</div>
		</div>
		<div class="col-md-3 nopadding">
			<div class="panel panel-default">
				<div class="panel-heading">Entrada en el blog</div>
				<div class="panel-body">
					
					<input type="submit" name="SubmitData" class="btn btn-primary btn-block" value="Guardar entrada" />
					<hr />
					<?php
						if ( $id>0 ){
							$num_comentarios = connection::countReg("foro_comentarios"," AND estado=1 AND id_tema=".$id." ");
							echo '<a target="_blank" href="blog?id='.$id.'" title="ver entrada">Ver entrada</a><br />';
							echo '<a href="admin-blog-foro?id='.$id.'" title="comentario">Comentarios de la entrada ('.$num_comentarios.')</a><br />';
						}
					?>					
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Imágen principal</div>
				<div class="panel-body">
					<p>Selecciona la imágen principal de la entrada:</p>
					<?php
						if (isset($elements[0]['imagen_tema']) and $elements[0]['imagen_tema']!=""){
							echo '<img src="images/foro/'.$elements[0]['imagen_tema'].'" style="width: 100%" class="responsive" />';
						}
					?>
					<input type="file" name="imagen-tema" id="imagen-tema" class="btn btn-primary btn-block" title="seleccionar imágen" />
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Etiquetas</div>
				<div class="panel-body">
					<p>Introduce las etiquetas de la entrada:</p>
					<input type="text" name="etiquetas" id="etiquetas" class="form-control" value="<?php echo $tipo_tema;?>" />
					<br /><span class="text-muted">Etiquetas existentes: </span>
					<?php
						$foro = new foro();
						$categorias = $foro->getCategorias(" AND ocio=1 ");
						foreach($categorias as $categoria):
							echo '<a href="#">'.$categoria.'</a> ';
						endforeach;
						?>
				</div>
			</div>
		</div>
		</form>
	</div>
	<?php menu::adminMenu();?>
</div>