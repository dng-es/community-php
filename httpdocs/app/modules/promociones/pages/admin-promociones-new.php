<?php
addJavascripts(array("js/libs/ckeditor/ckeditor.js", 
					 "js/libs/ckfinder/ckfinder.js", 
					 "js/bootstrap.file-input.js", 
					 getAsset("promociones")."js/admin-promociones-new.js"));

templateload("cmbCanales","users");
?>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Reto"), "ItemUrl"=>"admin-blog"),
			array("ItemLabel"=>"Entrada en el reto", "ItemClass"=>"active"),
		));

		$id = (isset($_GET['id']) ? $_GET['id'] : 0);
		session::getFlashMessage( 'actions_message' );
		promocionesController::createAction();
		promocionesController::updateAction();
		$elements = promocionesController::getItemAction($id);

		if (isset($elements[0])){
			$accion = "edit";
			$nombre = $elements[0]['nombre_promocion'];
			$descripcion = $elements[0]['texto_promocion'];
			$comentarios = $elements[0]['galeria_comentarios'];
			$videos = $elements[0]['galeria_videos'];
			$fotos = $elements[0]['galeria_fotos'];

		}
		else{
			$accion = "new";
			$nombre = "";
			$descripcion = "";
			$comentarios = 1;
			$videos = 0;
			$fotos = 0;
		}

		?>
		<form id="formData" name="formData" method="post" enctype="multipart/form-data" action="" role="form">
		<input type="hidden" name="id" value="<?php echo $id;?>" />
		<div class="col-md-9">
			<div class="panel panel-default">
				<div class="panel-body">

					<label for="nombre" class="sr-only">Título del reto:</label>
					<input type="text" class="form-control form-big" name="nombre_promocion" id="nombre_promocion" value="<?php echo $nombre;?>" placeholder="título del reto" />
					<br />
					<label for="descripcion" class="sr-only">Descripción del reto:</label>
					<textarea cols="40" rows="5" name="texto_promocion"><?php echo $descripcion;?></textarea>
					<script type="text/javascript">
						var editor=CKEDITOR.replace('texto_promocion',{customConfig : 'config-page.js'});
						CKFinder.setupCKEditor(editor, 'js/libs/ckfinder/') ;
					</script>	
				</div>
			</div>
		</div>
		<div class="col-md-3 nopadding">
			<div class="panel panel-default">
				<div class="panel-heading">Opciones del reto</div>
				<div class="panel-body">
	
					<div class="radio">
						<label>
							<input type="radio" name="galeria_promocion" id="galeria_promocion1" value="comentarios" <?php echo ($comentarios ==1 ? 'checked' : '');?>>
							Comentarios
						</label>
					</div>

					<div class="radio">
						<label>
							<input type="radio" name="galeria_promocion" id="galeria_promocion2" value="fotos" <?php echo ($fotos ==1 ? 'checked' : '');?>>
							Fotos
						</label>
					</div>

					<div class="radio">
						<label>
							<input type="radio" name="galeria_promocion" id="galeria_promocion3" value="videos" <?php echo ($videos ==1 ? 'checked' : '');?>>
							Videos
						</label>
					</div>

				</div>
			</div>
			<input type="submit" name="SubmitData" class="btn btn-primary btn-block" value="Guardar reto" />
		</div>
		</form>
	</div>
	<?php menu::adminMenu();?>
</div>