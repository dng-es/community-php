<?php
addJavascripts(array("js/libs/ckeditor/ckeditor.js", 
					"js/libs/ckfinder/ckfinder.js", 
					"js/jquery.numeric.js", 
					getAsset("novedades")."js/admin-novedad.js"));

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

		$id_novedad = intval((isset($_REQUEST['id']) && $_REQUEST['id'] > 0) ? $_REQUEST['id'] : 0);
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

					<div class="form-group col-md-3">
						<label for="canal"><?php e_strTranslate("Channel");?>:</label>
						<select name="canal[]" id="canal" class="selectpicker show-menu-arrow show-tick" data-container="body" data-style="btn-default" data-width="100%" multiple data-actions-box="true" data-none-selected-text="<?php e_strTranslate("Choose_channel");?>" data-deselect-all-text="<?php e_strTranslate('deselect_all');?>"  data-select-all-text="<?php e_strTranslate('select_all');?>">
							<?php ComboCanales($element['canal']);?>
						</select>
					</div>

					<div class="form-group col-md-3">
						<label for="perfil"><?php e_strTranslate("Profile");?>:</label>
						<select name="perfil" id="perfil" class="selectpicker show-menu-arrow show-tick" data-container="body" data-style="btn-default" data-width="100%">
							<option value="">---Todos los perfiles---</option>
							<?php ComboPerfiles($element['perfil']);?>
						</select>
					</div>

					<div class="form-group col-md-2">
						<label for="tipo"><?php e_strTranslate("Type");?>:</label>
						<select name="tipo" id="tipo" class="selectpicker show-menu-arrow show-tick" data-container="body" data-style="btn-default" data-width="100%">
							<option value="slider" <?php echo ($element['tipo'] == 'slider' ? ' selected="selected" ' : '');?>>Slider</option>
							<option value="popup" <?php echo ($element['tipo'] == 'popup' ? ' selected="selected" ' : '');?>>Popup</option>
							<option value="banner" <?php echo ($element['tipo'] == 'banner' ? ' selected="selected" ' : '');?>>Banner</option>
						</select>
					</div>

					<div class="form-group col-md-2">
						<label for="orden">Orden:</label>
						<input type="text" class="form-control numeric text-right" name="orden" id="orden" value="<?php echo $element['orden'];?>" />
					</div>

					<div class="form-group col-md-2">
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