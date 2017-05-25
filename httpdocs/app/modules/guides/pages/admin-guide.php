<?php
addJavascripts(array("js/jquery.numeric.js", getAsset("guides")."js/admin-guide.js"));

templateload("cmbTypes", "guides");
?>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Guides_list"), "ItemUrl"=>"admin-guides"),
			array("ItemLabel"=>strTranslate("Guides_new")."/".strTranslate("Edit"), "ItemClass"=>"active"),
		));

		session::getFlashMessage('actions_message');
		guidesController::createAction();
		guidesController::updateAction();

		$id = ((isset($_REQUEST['id']) and $_REQUEST['id'] > 0) ? $_REQUEST['id'] : 0);
		$element = guidesController::getItemAction($id);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form id="formData" name="formData" method="post" enctype="multipart/form-data" action="" role="form">
					<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
					<div class="form-group col-md-8">
						<label for="name_guide"><?php e_strTranslate("Name");?>:</label>
						<input type="text" class="form-control form-big" name="name_guide" id="name_guide" value="<?php echo $element['name_guide'];?>" placeholder="<?php e_strTranslate("Name");?>" />
					</div>

					<div class="form-group col-md-4">
						<label for="type_guide"><?php e_strTranslate("Type");?>:</label>
						<select name="type_guide" id="type_guide" class="form-control">
							<?php ComboTypes($element['type_guide']);?>
						</select>
					</div>

					<div class="form-group col-md-2">
						<label for="order_guide"><?php e_strTranslate("Order");?>:</label>
						<input type="text" class="form-control numeric text-right" name="order_guide" id="order_guide" value="<?php echo $element['order_guide'];?>" />
					</div>

					<div class="form-group col-md-10 hidden">
						<br />
						<div class="checkbox checkbox-primary">
							<input class="styled" type="checkbox" id="active_guide"  name="active_guide" <?php echo $element['active_guide'] == 1 ? "checked" : "";?>>
							<label for="active_guide"><?php e_strTranslate("Active");?></label>
						</div>
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