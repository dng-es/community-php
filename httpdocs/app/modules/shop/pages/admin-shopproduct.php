<?php
addJavascripts(array("js/libs/ckeditor/ckeditor.js", 
					 "js/libs/ckfinder/ckfinder.js", 
					 "js/bootstrap.file-input.js",
					 "js/bootstrap-datepicker.js",
					 "js/bootstrap-datepicker.es.js",
					 "js/jquery.numeric.js", 
					 "js/bootstrap3-typeahead.min.js",
					 getAsset("shop")."js/admin-shopproduct.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("APP_Shop"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Shop_products_list"), "ItemUrl"=>"admin-shopproducts"),
			array("ItemLabel"=>strTranslate("Edit")." ".strTranslate("Shop_product"), "ItemClass"=>"active"),
		));
		session::getFlashMessage( 'actions_message' ); 
		shopProductsController::createAction();
		shopProductsController::updateAction();
		
		$id_product = ((isset($_REQUEST['id']) && $_REQUEST['id'] > 0) ? $_REQUEST['id'] : 0);
		$element = shopProductsController::getItemAction($id_product);
		$manufacturers = shopManufacturersController::getListAction(9999999, " AND active_manufacturer=1 ORDER BY name_manufacturer");
		$foto_product = (is_file("images/shop/".$element['image_product']) ? "images/shop/".$element['image_product'] : "images/nofile.jpg");
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form id="formData" name="formData" enctype="multipart/form-data" method="post" action="" role="form">
					<input type="hidden" name="id_product" id="id_product" value="<?php echo $id_product;?>" />
					<input type="hidden" name="image_product_old" id="image_product_old" value="<?php echo $element['image_product'];?>" />

					<div class="row">
						<div class="col-md-8">

							<div class="row">
								<div class="form-group col-md-3">
									<label for="ref_product">REF.</label>
									<input type="text" name="ref_product" id ="ref_product" class="form-control" value="<?php echo $element['ref_product'];?>" />
								</div>

								<div class="form-group col-md-9">
									<label for="name_product"><?php e_strTranslate("Name");?></label>
									<input type="text" name="name_product" id ="name_product" class="form-control" value="<?php echo $element['name_product'];?>" />
								</div>
							</div>

							<div class="row">
								<div class="form-group col-md-4">
									<label class=" control-label" for="date_ini_product"><?php e_strTranslate("Date_start");?></label>
									<div id="datetimepicker1" class="input-group date">
										<input data-format="yyyy/MM/dd" readonly type="text" id="date_ini_product" class="form-control" name="date_ini_product" data-alert="<?php e_strTranslate("Required_date");?>"></input>
										<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
									</div>

									<script type="text/javascript">
										jQuery(document).ready(function(){
											<?php 
											if ($element['date_ini_product'] != null){
												echo "var fecha_ini = '".date('D M d Y H:i:s O',strtotime($element['date_ini_product']))."';";
												echo '$("#datetimepicker1").data("datetimepicker").setLocalDate(new Date (fecha_ini));';
											}
											?>
										});
									</script>
								</div>

								<div class="form-group col-md-4">
									<label class=" control-label" for="date_fin_product"><?php e_strTranslate("Date_end");?></label>
									<div id="datetimepicker2" class="input-group date">
										<input data-format="yyyy/MM/dd" readonly type="text" id="date_fin_product" class="form-control" name="date_fin_product" data-alert="<?php e_strTranslate("Required_date");?>"></input>
										<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
									</div>
									<script type="text/javascript">
										jQuery(document).ready(function(){
											<?php 
											if ($element['date_fin_product'] != null){
												echo "var fecha_fin = '".date('D M d Y H:i:s O',strtotime($element['date_fin_product']))."';";
												echo '$("#datetimepicker2").data("datetimepicker").setLocalDate(new Date (fecha_fin));';
											}
											?>
										});
									</script>
								</div>
								<div class="form-group col-md-4">
									<br />
									<div class="checkbox checkbox-primary">
										<input class="styled" type="checkbox" id="active_product"  name="active_product" <?php echo $element['active_product'] == 1 ? "checked" : "";?>> 
										<label for="active_product"><?php e_strTranslate("Active");?></label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-6">
									<label for="id_manufacturer"><?php e_strTranslate("Shop_manufacturer");?></label>
									<select title="---Selecciona el <?php e_strTranslate("Shop_manufacturer");?>---" name="id_manufacturer" id ="id_manufacturer" class="selectpicker show-menu-arrow show-tick" data-container="body" data-style="btn-default" data-width="100%">
										<?php foreach($manufacturers['items'] as $manufacturer):?>
											<option value="<?php echo $manufacturer['id_manufacturer'];?>" <?php echo ($element['id_manufacturer'] == $manufacturer['id_manufacturer'] ? ' selected="selected" ' : '');?>><?php echo $manufacturer['name_manufacturer'];?></option>
										<?php endforeach;?>
									</select>
								</div>

								<div class="form-group col-md-6">
									<label for="canal_product"><?php e_strTranslate("Channel");?>:</label>
									<select id="canal_product" name="canal_product[]" class="selectpicker show-menu-arrow show-tick" data-container="body" data-style="btn-default" data-width="100%" multiple data-actions-box="true" data-none-selected-text="<?php e_strTranslate("Choose_channel");?>" data-deselect-all-text="<?php e_strTranslate('deselect_all');?>"  data-select-all-text="<?php e_strTranslate('select_all');?>">
										<?php ComboCanales($element['canal_product']);?>
									</select>
								</div>
							</div>

							<div class="row">
								<div class="form-group col-md-6">
									<label for="category_product"><?php e_strTranslate("Category");?></label>
									<input type="text" name="category_product" id ="category_product" class="form-control" value="<?php echo $element['category_product'];?>" />
								</div>

								<div class="form-group col-md-6">
									<label for="subcategory_product">Subcategoría</label>
									<input type="text" name="subcategory_product" id ="subcategory_product" class="form-control" value="<?php echo $element['subcategory_product'];?>" />
								</div>

								<div class="form-group col-md-12">
									<label for="description_product"><?php e_strTranslate("Description");?></label>
									<textarea cols="40" rows="5" id="description_product" name="description_product"><?php echo $element['description_product'];?></textarea>
									<script type="text/javascript">
										var editor=CKEDITOR.replace('description_product',{customConfig : 'config-page.js'});
										CKFinder.setupCKEditor(editor, 'js/libs/ckfinder/') ;
									</script>
								</div>
							</div>
						</div>

						<div class="col-md-4">
							
							<div class="form-group col-md-12">
								<button class="btn btn-primary btn-block" id="SubmitData" name="SubmitData" type="submit"><?php e_strTranslate("Save_data");?></button>
							</div>

							<div class="form-group col-md-4">
								<label for="price_product"><?php echo ucfirst(strTranslate("APP_Credits"));?></label>
								<input type="text" name="price_product" id ="price_product" class="form-control numeric" value="<?php echo $element['price_product'];?>" />
							</div>

							<div class="form-group col-md-4">
								<label for="price_product">Stock</label>
								<input type="text" name="stock_product" id ="stock_product" class="form-control numeric" value="<?php echo $element['stock_product'];?>" />
							</div>
							<div class="form-group col-md-4">
								<br />
								<div class="checkbox checkbox-primary">
									<input class="styled" type="checkbox" id="important_product"  name="important_product" <?php echo $element['important_product'] == 1 ? "checked" : "";?>> 
									<label for="important_product">Destacado</label>
								</div>
							</div>

							<div class="form-group col-md-12">
								<label for="image_product" class="sr-only"><?php e_strTranslate("Image");?></label>

								<img src="<?php echo $foto_product;?>" style="width:100%" />
								<input name="image_product" id="image_product" type="file" class="btn btn-primary btn-block" title="<?php e_strTranslate("Change_picture");?>" /> 

							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>