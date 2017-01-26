<?php
templateload("searchproducts","shop");

$id = ((isset($_REQUEST['id']) and $_REQUEST['id'] > 0) ? intval($_REQUEST['id']) : 0);
$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND canal_product LIKE '%".$_SESSION['user_canal']."%' " : "");
$filtro = $filtro_canal." AND active_product=1 AND id_product=".$id." ";

if (isset($_REQUEST['ref_search'])) $filtro .= " AND ref_product LIKE '%".sanitizeInput($_REQUEST['ref_search'])."%' ";
if (isset($_REQUEST['name_search'])) $filtro .= " AND name_product LIKE '%".sanitizeInput($_REQUEST['name_search'])."%' ";
if (isset($_REQUEST['manufacturer_search'])) $filtro .= " AND name_manufacturer LIKE '%".sanitizeInput($_REQUEST['manufacturer_search'])."%' ";
if (isset($_REQUEST['category_search'])) $filtro .= " AND category_product LIKE '%".sanitizeInput($_REQUEST['category_search'])."%' ";
if (isset($_REQUEST['subcategory_search'])) $filtro .= " AND subcategory_product LIKE '%".sanitizeInput($_REQUEST['subcategory_search'])."%' ";

session::getFlashMessage( 'actions_message' );
$elements = shopProductsController::getListAction(1, $filtro);
$element = $elements['items'][0];

//obtener datos del usuario
$user_detail = usersController::getPerfilAction($_SESSION['user_name']);

$module_config = getModuleConfig("shop");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("APP_Shop"), "ItemUrl"=>"shopproducts"),
			array("ItemLabel"=> strTranslate("Shop_products_list"), "ItemClass"=>"active"),
		));

		$card_text = "Canjear premio";
		$card_text = ($element['price_product'] > $user_detail['creditos'] ? "No canjeable" : $card_text);
		$card_text = ($element['stock_product'] <=0 ? "No canjeable" : $card_text);
		$card_disabled = ($element['price_product'] > $user_detail['creditos'] ? "disabled" : "");
		$card_disabled = ($element['stock_product'] <=0 ? "disabled" : $card_disabled);
		$foto = ($element['image_product'] == '' ? 'images/nofile.jpg' : "images/shop/".$element['image_product']);
		?>

		<div class="col-md-10 col-md-offset-1 panel inset">
			<div class="panel panel-default">
				<div class="col-md-4">
					<img src="<?php echo $foto;?>" class="img-responsive" width="100%" />
				</div>
				<div class="col-md-8">
					<div class="row">
						<h1><?php echo $element['name_product'];?></h1>
						<?php if($element['important_product'] == 1):?>
							<div class="label label-danger">Producto destacado</div>
						<?php endif;?>
						
						<?php if($module_config['options']['show_stock']):?>
							<?php if($element['stock_product'] <= 0):?>
							<div class="stock label label-danger">Quedan <?php echo $element['stock_product'];?> und.</div>
							<?php else:?>
							<div class="stock label label-warning">Quedan <?php echo $element['stock_product'];?> und.</div>
							<?php endif;?>
						<?php endif;?>

						<?php if($module_config['options']['show_price']):?>
							<?php if($element['price_product'] > $user_detail['creditos']):?>
							<div class="price label label-danger"><?php echo $element['price_product'];?> <?php e_strTranslate("APP_Credits");?></div>
							<?php else:?>
							<div class="price label label-info"><?php echo $element['price_product'];?> <?php e_strTranslate("APP_Credits");?></div>
							<?php endif;?>
						<?php endif;?>
						
						<p class="description"><?php echo $element['description_product'];?></p>
						<small><ul class="list-unstyled list-inline">
							<?php if($element['name_manufacturer'] != ""):?>
								<li><label><?php e_strTranslate("Shop_manufacturer");?>:</label> <span class="text-muted"><?php echo $element['name_manufacturer'];?></span></li>
							<?php endif;?>
							<?php if($element['category_product'] != ""):?>
								<li><label><?php e_strTranslate("Category");?>:</label> <span class="text-muted"><?php echo $element['category_product'];?></span></li>
							<?php endif;?>
							<?php if($element['subcategory_product'] != ""):?>
								<li><label>Subcategoría:</label> <span class="text-muted"><?php echo $element['subcategory_product'];?></span></li>
							<?php endif;?>
							<?php if($element['ref_product'] != ""):?>
								<li><label>REF:</label> <span class="text-muted"><?php echo $element['ref_product'];?></span></li>
							<?php endif;?>
						</ul>
						</small>
						
						<?php if($module_config['options']['show_buybutton']):?> 
							<?php if(date("Y-m-d") >= $element['date_ini_product'] && date("Y-m-d") <= $element['date_fin_product']):?>
								<a href="shopproductorder?id=<?php echo $element['id_product'];?>" class="btn btn-primary pull-right <?php echo $card_disabled;?>"><?php echo $card_text;?></a>
							<?php else:?>
								<button class="btn btn-primary pull-right disabled" ><?php e_strTranslate("Comming_soon");?></button>
							<?php endif;?>
						<?php endif;?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<?php searchProducts();?>
		</div>
	</div>
</div>