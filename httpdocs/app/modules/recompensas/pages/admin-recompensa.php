<?php
addJavascripts(array("js/bootstrap.file-input.js",
					getAsset("recompensas")."js/admin-recompensa.js"));

$id = (isset($_REQUEST['id']) ? $_REQUEST['id'] : "");
?>
	
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Users"), "ItemUrl"=>"admin-users"),
			array("ItemLabel"=>strTranslate("User_info"), "ItemClass"=>"active"),
		));
		
		session::getFlashMessage('actions_message');
		//recompensasController::insertAction();
		//recompensasController::updateAction();


		//$elements = recompensasController::getItemAction();

		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form id="formData" role="form" name="formData" method="post" action="">
					<input type="hidden" name="level_user" value="3"/>
					<input type="hidden" id="id_username" name="id_username" value="<?php echo $elements[0]['username'];?>" />
					<div class="row">
						<div class="col-md-6">
							<label for="recompensa_nombre"><small><?php e_strTranslate("Name");?>:</small></label>
							<input type="text" class="form-control TextDisabled" id="recompensa_nombre" name="recompensa_nombre" value="<?php echo $elements[0]['recompensa_nombre'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
						</div>

						<div class="col-md-4">
							<label for="recompensa_image"><small><?php e_strTranslate("Image");?>:</small></label>
							<input type="file" name="recompensa_image" id="recompensa_image" class="btn btn-primary btn-block" title="seleccionar imágen" data-alert="<?php e_strTranslate("Required_field");?>" />
						</div>
						<div class="col-md-2">
							<?php
								if (isset($elements[0]['recompensa_image']) and $elements[0]['recompensa_image'] != ""){
									echo '<img src="images/'.$elements[0]['recompensa_image'].'" style="width: 100%" class="responsive" />';
								}
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<button type="submit" id="SubmitData" name="SubmitData" class="btn btn-primary"><?php e_strTranslate("Save_data");?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>