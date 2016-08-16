<?php
addJavascripts(array("js/libs/ckeditor/ckeditor.js", 
					 "js/libs/ckfinder/ckfinder.js", 
					 getAsset("novedades")."js/admin-novedades.js"));

templateload("cmbCanales", "users");
?>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("News"), "ItemUrl"=>"admin-novedades"),
			array("ItemLabel"=>strTranslate("News_new"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		novedadesController::createAction();
		novedadesController::updateAction();

		$id_novedad = ((isset($_REQUEST['id']) and $_REQUEST['id'] > 0) ? $_REQUEST['id'] : 0);
		$element = novedadesController::getItemAction($id_novedad);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form id="formData" name="formData" method="post" enctype="multipart/form-data" action="" role="form">
					<input type="hidden" name="id_novedad" id="id_novedad" value="<?php echo $id_novedad;?>" />
					<div class="form-group col-md-12">
						<label for="titulo"><?php e_strTranslate("Title");?>:</label>
						<input type="text" class="form-control form-big" name="titulo" id="titulo" value="<?php echo $element['titulo'];?>" placeholder="<?php e_strTranslate("Title");?>" />
					</div>

					<div class="form-group col-md-4">
						<label for="canal"><?php e_strTranslate("Channel");?>:</label>
						<select name="canal" id="canal" class="form-control">
							<option value="">---Todos los canales---</option>
							<?php ComboCanales($element['canal']);?>
						</select>
					</div>

					<div class="form-group col-md-4">
						<label for="perfil"><?php e_strTranslate("Profile");?>:</label>
						<select name="perfil" id="perfil" class="form-control">
							<option value="">---Todos los perfiles---</option>
							<?php ComboPerfiles($element['perfil']);?>
						</select>
					</div>

					<div class="form-group col-md-4">
						<label for="tipo"><?php e_strTranslate("Type");?>:</label>
						<select name="tipo" id="tipo" class="form-control">
							<option value="slider" <?php echo ($element['tipo'] == 'slider' ? ' selected="selected" ' : '');?>>Slider</option>
							<option value="popup" <?php echo ($element['tipo'] == 'popup' ? ' selected="selected" ' : '');?>>Popup</option>
						</select>
					</div>

					<div class="form-group col-md-12">
						<div class="checkbox checkbox-primary">
							<input class="styled" type="checkbox" id="activo"  name="activo" <?php echo $element['activo'] == 1 ? "checked" : "";?>>
							<label for="activo"><?php e_strTranslate("Active");?></label>
						</div>
					</div>
					
					<div class="form-group col-md-12">
						<label for="texto" class="sr-only"><?php e_strTranslate("Description");?></label>
						<textarea cols="40" rows="5" id="texto" name="texto"><?php echo $element['cuerpo'];?></textarea>
						<script type="text/javascript">
							var editor=CKEDITOR.replace('texto',{customConfig : 'config-page.js'});
							CKFinder.setupCKEditor(editor, 'js/libs/ckfinder/') ;
						</script>
					</div>
					<div class="form-group col-md-12">
						<input type="submit" name="SubmitData" class="btn btn-primary" value="<?php e_strTranslate("Save_data");?>" />
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>