<?php
templateload("cmbIcons", "core");

addJavascripts(array("js/bootstrap-colorpicker.min.js", getAsset("alerts")."js/admin-alerts-type.js"));

addCss(array("css/bootstrap-colorpicker.min.css"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("MOD_Alerts"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("MOD_Alert_types"), "ItemUrl"=>"admin-alerts-types"),
			array("ItemLabel"=>strTranslate("Category"), "ItemClass"=>"active"),
		));
		session::getFlashMessage( 'actions_message' );
		$id = (isset($_REQUEST['id']) ? sanitizeInput($_REQUEST['id']) : 0);
		alertsTypesController::updateAction();
		alertsTypesController::createAction();
		$elements = alertsTypesController::getItemAction($id);
		?>
		<div class="panel panel-default">
			<div class="panel-body">		
				<form id="formData" role="form" name="formData" method="post" action="">
					<input type="hidden" name="id" value="<?php echo $id;?>" />
					<div class="row">
						<div class="col-md-6 form-group">
							<label for="name_type"><?php e_strTranslate("Name");?></label>
							<input class="form-control" type="text" id="name_type" name="name_type" value="<?php echo $elements['name_type'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
						</div>
						<div class="col-md-6 form-group">
							<label for="perfiles_type"><?php e_strTranslate("Profile");?></label>
							<select name="perfiles_type[]" id="perfiles_type" class="selectpicker show-menu-arrow show-tick" data-container="body" data-style="btn-default" data-width="100%" multiple data-actions-box="true" data-none-selected-text="<?php e_strTranslate("Choose_profile");?>" data-deselect-all-text="<?php e_strTranslate('deselect_all');?>" data-select-all-text="<?php e_strTranslate('select_all');?>">
								<?php ComboPerfiles($elements['perfiles_type']);?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 form-group">
							<label for="color_type"><?php e_strTranslate("Color");?></label>

							<div id="cp2" class="input-group colorpicker-component">
								<input data-alert="<?php e_strTranslate("Required_field");?>" type="text" value="<?php echo $elements['color_type'];?>" class="form-control" id="color_type" name="color_type" />
								<span class="input-group-addon"><i></i></span>
							</div>
						</div>
						<div class="col-md-3 form-group">
							<label for="icon_type"><?php e_strTranslate("Icon");?></label>
							<select class="form-control selectpicker" data-container="body" name="icon_type" id="icon_type">
							<?php ComboIcons($elements['icon_type']);?>
							</select>
						</div>
						<div class="col-md-6 form-group">
							<br />
							<div class="checkbox checkbox-primary">
								<input type="checkbox" class="styled" id="aprobacion" name="aprobacion" <?php echo $elements['aprobacion'] == 1 ? "checked" : "";?>>
								<label for="aprobacion"><?php e_strTranslate("Requiere aprobación del responsable");?></label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5 form-group">
							<input type="submit" class="btn btn-primary" value="<?php e_strTranslate("Send_data");?>" />
						</div>

					</div>


				</form>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>