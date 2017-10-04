<?php
addJavascripts(array("js/libs/ckeditor/ckeditor.js", 
					 "js/libs/ckfinder/ckfinder.js", 
					 "js/jquery.numeric.js",
					 getAsset("guides")."js/admin-guides-subcategory.js"));

templateload("cmbTypes", "guides");
?>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Guides_subcategories"), "ItemUrl"=>"admin-guides-subcategories"),
			array("ItemLabel"=>strTranslate("Guides_subcategory_new")."/".strTranslate("Edit"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		guidesController::createSubCategoryAction();
		guidesController::updateSubCategoryAction();

		$id = ((isset($_REQUEST['id']) && $_REQUEST['id'] > 0) ? $_REQUEST['id'] : 0);
		$element = guidesController::getItemSubCategoryAction($id);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form id="formData" name="formData" method="post" enctype="multipart/form-data" action="" role="form">
					<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
					<input type="hidden" name="id_guide_selected" id="id_guide_selected" value="<?php echo $element['id_guide'];?>" />
					<input type="hidden" name="id_guide_category_selected" id="id_guide_category_selected" value="<?php echo $element['id_guide_category'];?>" />

					<div class="form-group col-md-3">
						<label for="type_guide"><?php e_strTranslate("Guide_type");?>:</label>
						<select name="type_guide" id="type_guide" class="form-control">
							<?php ComboTypes($element['type_guide']);?>
						</select>
					</div>

					<div class="form-group col-md-3">
						<label for="id_guide"><?php e_strTranslate("Guide");?>:</label>
						<select name="id_guide" id="id_guide" class="form-control"></select>
					</div>

					<div class="form-group col-md-3">
						<label for="id_guide_category"><?php e_strTranslate("Category");?>:</label>
						<select name="id_guide_category" id="id_guide_category" class="form-control"></select>
					</div>

					<div class="form-group col-md-3">
						<label for="id_guide_subcategory_type"><?php e_strTranslate("Type");?>:</label>
						<select name="id_guide_subcategory_type" id="id_guide_subcategory_type" class="form-control">
							<?php ComboCategoriesTypes($element['id_guide_subcategory_type']);?>
						</select>
					</div>

					<div class="form-group col-md-2">
						<label for="order_guide_subcategory"><?php e_strTranslate("Order");?>:</label>
						<input type="text" class="form-control numeric text-right" name="order_guide_subcategory" id="order_guide_subcategory" value="<?php echo $element['order_guide_subcategory'];?>" />
					</div>

					<div class="form-group col-md-10 hidden">
						<div class="checkbox checkbox-primary">
							<input class="styled" type="checkbox" id="active_guide_subcategory"  name="active_guide_subcategory" <?php echo $element['active_guide_subcategory'] == 1 ? "checked" : "";?>>
							<label for="active_guide_subcategory"><?php e_strTranslate("Active");?></label>
						</div>
					</div>
					
					<div class="form-group col-md-12">
						<label for="desc_guide_subcategory" class="sr-only"><?php e_strTranslate("Description");?></label>
						<textarea cols="40" rows="5" id="desc_guide_subcategory" name="desc_guide_subcategory"><?php echo $element['desc_guide_subcategory'];?></textarea>
						<script type="text/javascript">
							var editor=CKEDITOR.replace('desc_guide_subcategory',{customConfig : 'config-page.js'});
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