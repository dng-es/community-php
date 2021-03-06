<?php
addJavascripts(array("js/bootstrap.file-input.js",
					getAsset("recompensas")."js/admin-recompensa.js"));

$id = (isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Rewards"), "ItemUrl"=>"admin-recompensas"),
			array("ItemLabel"=>strTranslate("Reward"), "ItemClass"=>"active"),
		));
		
		session::getFlashMessage('actions_message');
		recompensasController::createAction();
		recompensasController::updateAction();

		$elements = recompensasController::getItemAction($id);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form id="formData" role="form" name="formData" method="post" action="" enctype="multipart/form-data">
					<input type="hidden" id="id_recompensa" name="id_recompensa" value="<?php echo $id;?>" />
					<input type="hidden" id="nombre_imagen" name="nombre_imagen" value="<?php echo $elements['recompensa_image'];?>" />
					<div class="row">
						<div class="col-md-6 form-group">
							<label for="recompensa_nombre"><small><?php e_strTranslate("Name");?>:</small></label>
							<input type="text" class="form-control TextDisabled" id="recompensa_nombre" name="recompensa_nombre" value="<?php echo $elements['recompensa_name'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
						</div>

						<div class="col-md-3 form-group">
							<label for="recompensa_image"><small><?php e_strTranslate("Image");?>:</small></label>
							<input type="file" name="recompensa_image" id="recompensa_image" class="btn btn-primary btn-block" title="seleccionar imágen" data-alert="<?php e_strTranslate("Required_field");?>" />
						</div>
						<div class="col-md-3 form-group text-center">
							<?php
								if ($elements['recompensa_image'] != ""){
									echo '<img src="'.PATH_REWARDS.$elements['recompensa_image'].'" style="width: 50%" class="responsive" />';
								}
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-group">
							<button type="submit" id="SubmitData" name="SubmitData" class="btn btn-primary"><?php e_strTranslate("Save_data");?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>