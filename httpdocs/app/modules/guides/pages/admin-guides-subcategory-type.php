<?php
addJavascripts(array("js/jquery.numeric.js", getAsset("guides")."js/admin-guides-subcategory-type.js"));
addCss(array("css/libs/bootstrap-select/bootstrap-select.css"));

templateload("cmbIcons", "core");
?>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Guides_subcategories_types"), "ItemUrl"=>"admin-guides-subcategory-types"),
			array("ItemLabel"=>strTranslate("Guides_subcategory_type_new")."/".strTranslate("Edit"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		guidesController::createSubCategoryTypeAction();
		guidesController::updateSubCategoryTypeAction();

		$id = ((isset($_REQUEST['id']) and $_REQUEST['id'] > 0) ? $_REQUEST['id'] : 0);
		$element = guidesController::getItemSubCategoryTypeAction($id);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form id="formData" name="formData" method="post" enctype="multipart/form-data" action="" role="form">
					<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
					<div class="form-group col-md-6">
						<label for="name_guide_subcategory_type"><?php e_strTranslate("Name");?>:</label>
						<input type="text" class="form-control form-big" name="name_guide_subcategory_type" id="name_guide_subcategory_type" value="<?php echo $element['name_guide_subcategory_type'];?>" placeholder="<?php e_strTranslate("Name");?>" />
					</div>

					<div class="form-group col-md-4">
						<label for="tipo"><?php e_strTranslate("Icon");?>:</label>
						<select class="form-control selectpicker" data-container="body" name="icon_guide_subcategory_type" id="icon_guide_subcategory_type">
							<?php ComboIcons($element['icon_guide_subcategory_type']);?>
						</select>
					</div>

					<div class="form-group col-md-2">
						<label for="order_guide_subcategory_type"><?php e_strTranslate("Order");?>:</label>
						<input type="text" class="form-control numeric text-right" name="order_guide_subcategory_type" id="order_guide_subcategory_type" value="<?php echo $element['order_guide_subcategory_type'];?>" />
					</div>

					<div class="form-group col-md-10 hidden">
						<div class="checkbox checkbox-primary">
							<input class="styled" type="checkbox" id="active_guide_subcategory_type"  name="active_guide_subcategory_type" <?php echo $element['active_guide_subcategory_type'] == 1 ? "checked" : "";?>>
							<label for="active_guide_subcategory_type"><?php e_strTranslate("Active");?></label>
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