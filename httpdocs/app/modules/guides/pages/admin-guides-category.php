<?php
addJavascripts(array("js/jquery.numeric.js", getAsset("guides")."js/admin-guides-category.js"));

templateload("cmbTypes", "guides");
?>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Guides_categories"), "ItemUrl"=>"admin-guides-categories"),
			array("ItemLabel"=>strTranslate("Guides_category_new")."/".strTranslate("Edit"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		guidesController::createCategoryAction();
		guidesController::updateCategoryAction();

		$id = ((isset($_REQUEST['id']) && $_REQUEST['id'] > 0) ? $_REQUEST['id'] : 0);
		$element = guidesController::getItemCategoryAction($id);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form id="formData" name="formData" method="post" enctype="multipart/form-data" action="" role="form">
					<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
					<input type="hidden" name="id_guide_selected" id="id_guide_selected" value="<?php echo $element['id_guide'];?>" />
					<div class="form-group col-md-4">
						<label for="name_guide_category"><?php e_strTranslate("Name");?>:</label>
						<input type="text" class="form-control" name="name_guide_category" id="name_guide_category" value="<?php echo $element['name_guide_category'];?>" placeholder="<?php e_strTranslate("Name");?>" />
					</div>

					<div class="form-group col-md-4">
						<label for="type_guide"><?php e_strTranslate("Type");?>:</label>
						<select name="type_guide" id="type_guide" class="form-control">
							<?php ComboTypes($element['type_guide']);?>
						</select>
					</div>

					<div class="form-group col-md-4">
						<label for="id_guide"><?php e_strTranslate("Guide");?>:</label>
						<select name="id_guide" id="id_guide" class="form-control"></select>
					</div>

					<div class="form-group col-md-2">
						<label for="order_guide_category"><?php e_strTranslate("Order");?>:</label>
						<input type="text" class="form-control numeric text-right" name="order_guide_category" id="order_guide_category" value="<?php echo $element['order_guide_category'];?>" />
					</div>

					<div class="form-group col-md-10 hidden">
						<div class="checkbox checkbox-primary">
							<input class="styled" type="checkbox" id="active_guide_category"  name="active_guide_category" <?php echo $element['active_guide_category'] == 1 ? "checked" : "";?>>
							<label for="active_guide_category"><?php e_strTranslate("Active");?></label>
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