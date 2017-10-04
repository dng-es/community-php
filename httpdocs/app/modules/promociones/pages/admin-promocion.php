<?php
addJavascripts(array("js/libs/ckeditor/ckeditor.js", 
					 "js/libs/ckfinder/ckfinder.js", 
					 "js/bootstrap.file-input.js", 
					 getAsset("promociones")."js/admin-promocion.js"));

templateload("cmbCanales","users");
?>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("promociones_list"), "ItemUrl"=>"admin-promociones"),
			array("ItemLabel"=>strTranslate("Edit")." ".strTranslate("promocion"), "ItemClass"=>"active"),
		));

		$id = intval(isset($_GET['id']) ? $_GET['id'] : 0);
		session::getFlashMessage('actions_message');
		promocionesController::createAction();
		promocionesController::updateAction();
		$element = promocionesController::getItemAction($id);
		?>
		<form id="formData" name="formData" method="post" enctype="multipart/form-data" action="" role="form">
		<input type="hidden" name="id" value="<?php echo $id;?>" />
		<div class="col-md-9">
			<div class="panel panel-default">
				<div class="panel-body">

					<label for="nombre" class="sr-only">Título del reto:</label>
					<input type="text" class="form-control form-big" name="nombre_promocion" id="nombre_promocion" value="<?php echo $element['nombre_promocion'];?>" placeholder="título del reto" />
					<br />
					<label for="descripcion" class="sr-only">Descripción del reto:</label>
					<textarea cols="40" rows="5" name="texto_promocion"><?php echo $element['texto_promocion'];?></textarea>
					<script type="text/javascript">
						var editor=CKEDITOR.replace('texto_promocion', {customConfig : 'config-page.js'});
						CKFinder.setupCKEditor(editor, 'js/libs/ckfinder/') ;
					</script>	
				</div>
			</div>
		</div>
		<div class="col-md-3 nopadding">
			<div class="panel panel-default">
				<div class="panel-heading">Opciones del reto</div>
				<div class="panel-body">
					<div class="radio radio-primary">
						<input type="radio" id="galeria_promocion1" name="galeria_promocion" value="comentarios" <?php echo ($element['galeria_comentarios'] ==1 ? 'checked' : '');?>> 
						<label>Comentarios</label>
					</div>

					<div class="radio radio-primary">
						<input type="radio" id="galeria_promocion2" name="galeria_promocion" value="fotos" <?php echo ($element['galeria_fotos'] ==1 ? 'checked' : '');?>> 
						<label>Fotos</label>
					</div>

					<div class="radio radio-primary">
						<input type="radio" id="galeria_promocion3" name="galeria_promocion" value="videos" <?php echo ($element['galeria_videos'] ==1 ? 'checked' : '');?>> 
						<label>Videos</label>
					</div>
				</div>
			</div>
			<input type="submit" name="SubmitData" class="btn btn-primary btn-block" value="Guardar reto" />
		</div>
		</form>
	</div>
	<?php menu::adminMenu();?>
</div>