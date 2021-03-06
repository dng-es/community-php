<?php 
/**
 * Print HTML form panel for products search
 * @param	String 		$dstination		Página de destino del buscador
 * @return	String						HTML form panel
 */
function searchProducts($destination = "shopproducts"){ 
	$ref_search = (isset($_REQUEST['ref_search']) ? $_REQUEST['ref_search'] : "");
	$name_search = (isset($_REQUEST['name_search']) ? $_REQUEST['name_search'] : "");
	$manufacturer_search = (isset($_REQUEST['manufacturer_search']) ? $_REQUEST['manufacturer_search'] : "");
	$category_search = (isset($_REQUEST['category_search']) ? $_REQUEST['category_search'] : "");
	$subcategory_search = (isset($_REQUEST['subcategory_search']) ? $_REQUEST['subcategory_search'] : "");

	$shop = new shop();
	$manufacturers = $shop->getManufacturers();
	$categories = shopProductsController::getCategoriesAction(" AND category_product<>'' AND active_product=1 ");
	$subcategories = shopProductsController::getSubCategoriesAction(" AND subcategory_product<>'' AND active_product=1 ");

	$collpase_search = "";
	if ($ref_search != "" || $manufacturer_search != "" || $category_search != "" || $subcategory_search != "") $collpase_search = "in";
	?>
	<div class="panel panel-info">
		<div class="panel-body">
			<form name="searchProducts" id="searchProducts" action="<?php echo $destination;?>" class="form-horizontal" method="get" role="form">
				<div class="input-group">
					<label class="sr-only" for="name_search"><?php e_strTranslate('Name');?></label>
					<input type="text" class="form-control" id="name_search" name="name_search" placeholder="<?php e_strTranslate("Search");?> <?php e_strTranslate("APP_Shop");?>" value="<?php echo $name_search;?>">
					<div class="input-group-btn">
						<button type="submit" class="btn btn-default" title="<?php e_strTranslate("Search");?>"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</div> 
				<br />
				<small><a class="" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><?php e_strTranslate('Advanced_search');?> <span class="fa fa-angle-double-right"></span></a></small>

				<div class="collapse <?php echo $collpase_search;?>" id="collapseExample">
					<hr />

					<div class="form-group">
						<label class="col-sm-4 control-label" for="manufacturer_search"><?php e_strTranslate("Shop_manufacturer");?></label>
						<div class="col-sm-8">
							<select class="selectpicker show-menu-arrow show-tick" data-container="body" data-style="btn-default" data-width="100%" data-live-search="true" name="manufacturer_search" id ="manufacturer_search" class="form-control">
								<option value="">Buscar por <?php e_strTranslate("Shop_manufacturer");?></option>
								<?php foreach($manufacturers as $manufacturer):?>
									<option value="<?php echo $manufacturer['name_manufacturer'];?>" <?php echo ($manufacturer['name_manufacturer'] == $manufacturer_search ? ' selected="selected" ' : '');?>><?php echo $manufacturer['name_manufacturer'];?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label" for="category_search"><?php e_strTranslate("Category");?></label>
						<div class="col-sm-8">
							<select class="selectpicker show-menu-arrow show-tick" data-container="body" data-style="btn-default" data-width="100%" data-live-search="true" name="category_search" id ="category_search" class="form-control">
								<option value="">Buscar por <?php e_strTranslate("Category");?></option>
								<?php foreach ($categories as $key => $category):?>
									<option value="<?php echo $category;?>" <?php echo ($category == $category_search ? ' selected="selected" ' : '');?>><?php echo $category;?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label" for="subcategory_search">Subcategoría</label>
						<div class="col-sm-8">
							<select class="selectpicker show-menu-arrow show-tick" data-container="body" data-style="btn-default" data-width="100%" data-live-search="true" name="subcategory_search" id ="subcategory_search" class="form-control">
								<option value="">Buscar por Subcategoría</option>
								<?php foreach ($subcategories as $key => $subcategory):?>
									<option value="<?php echo $subcategory;?>" <?php echo ($subcategory == $subcategory_search ? ' selected="selected" ' : '');?>><?php echo $subcategory;?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label" for="ref_search">REF</label>
						<div class="col-sm-8">
							<input type="text" name="ref_search" id="ref_search" class="form-control" value="<?php echo $ref_search;?>" />
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php } ?>