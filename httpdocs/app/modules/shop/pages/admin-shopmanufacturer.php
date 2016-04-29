<?php

addJavascripts(array(getAsset("shop")."js/admin-shopmanufacturer.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Shop_manufacturers_list"), "ItemUrl"=>"admin-shopmanufacturers"),
			array("ItemLabel"=>strTranslate("Shop_manufacturer"), "ItemClass"=>"active"),
		));
		session::getFlashMessage( 'actions_message' ); 
		shopManufacturersController::createAction();
		shopManufacturersController::updateAction();
		
		$id_manufacturer = ((isset($_REQUEST['id']) and $_REQUEST['id'] > 0) ? $_REQUEST['id'] : 0);
		$element = shopManufacturersController::getItemAction($id_manufacturer);
		?>

		<div class="panel panel-default">
			<div class="panel-heading"><?php e_strTranslate("Shop_manufacturer");?></div>
			<div class="panel-body">
				<form id="formData" name="formData" method="post" action="" role="form">
					<input type="hidden" name="id_manufacturer" id="id_manufacturer" value="<?php echo $id_manufacturer;?>" />
					<div class="form-group col-md-12">
						<label for="name_manufacturer"><?php e_strTranslate("Name");?></label>
						<input data-alert="<?php echo strTranslate("Required_field");?>" type="text" name="name_manufacturer" id ="name_manufacturer" class="form-control" value="<?php echo $element['name_manufacturer'];?>" />
					</div>
					<div class="form-group col-md-12">
						<label for="notes_manufacturer"><?php e_strTranslate("Notes");?></label>
						<textarea name="notes_manufacturer" id ="notes_manufacturer" class="form-control"><?php echo $element['notes_manufacturer'];?></textarea>
					</div>
					<button class="btn btn-primary pull-right" id="SubmitData" name="SubmitData" type="submit"><?php e_strTranslate("Save_data");?></button>
				</form>

			</div>
		</div>

	</div>
	<?php menu::adminMenu();?>
</div>