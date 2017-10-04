<?php 
addJavascripts(array("js/jcolumn.min.js", getAsset("shop")."js/shopproducts.js"));
addCss(array(getAsset("shop")."css/styles.css"));
templateload("searchproducts","shop");
templateload("credits","shop");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("APP_Shop"), "ItemUrl"=>"shopproducts"),
			array("ItemLabel"=> strTranslate("Shop_products_list"), "ItemClass"=>"active"),
		));
		
		$filtro = " AND active_product=1 ";
		if (isset($_REQUEST['ref_search'])) $filtro .= " AND ref_product LIKE '%".$_REQUEST['ref_search']."%' ";
		if (isset($_REQUEST['name_search'])) $filtro .= " AND name_product LIKE '%".$_REQUEST['name_search']."%' ";
		if (isset($_REQUEST['manufacturer_search'])) $filtro .= " AND name_manufacturer LIKE '%".$_REQUEST['manufacturer_search']."%' ";
		if (isset($_REQUEST['category_search'])) $filtro .= " AND category_product LIKE '%".$_REQUEST['category_search']."%' ";
		if (isset($_REQUEST['subcategory_search'])) $filtro .= " AND subcategory_product LIKE '%".$_REQUEST['subcategory_search']."%' ";
		$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND canal_product LIKE '%".$_SESSION['user_canal']."%' " : "");
		$filtro .= $filtro_canal." ORDER BY important_product DESC, price_product ASC, name_product ASC";

		session::getFlashMessage( 'actions_message' );
		$elements = shopProductsController::getListAction(15, $filtro);

		//obtener datos del usuario
		$user_detail = usersController::getPerfilAction($_SESSION['user_name']);

		$module_config = getModuleConfig("shop");
		?>

		<div class="row">
			<div class="col-md-12 dinamicRow">
			<?php foreach($elements['items'] as $element):
				$card_text = strTranslate("Buy_product");
				$card_text = ($element['price_product'] > $user_detail['creditos'] ? strTranslate("No_Buy_product") : $card_text);
				$card_text = ($element['stock_product'] <= 0 ? strTranslate("No_Buy_product") : $card_text);
				$card_disabled = ($element['price_product'] > $user_detail['creditos'] ? "disabled" : "");
				$card_disabled = ($element['stock_product'] <= 0 ? "disabled" : $card_disabled);
				$foto = ($element['image_product'] == '' ? 'images/nofile.jpg' : "images/shop/".$element['image_product']);
				?>
				<div class="card-section">
					<h3 class="ellipsis"><a href="shopproduct?id=<?php echo $element['id_product'];?>"><?php echo $element['name_product'];?></a></h3>
					<a href="shopproduct?id=<?php echo $element['id_product'];?>">
						<img src="<?php echo $foto;?>" title="<?php echo $element['name_product'];?>" />
					</a>
					<div <?php echo ($element['important_product'] == 0 ? 'style="visibility:hidden"' : "");?>>
					<div class="label label-danger" >Producto destacado</div>
					</div>
					
					<?php if($module_config['options']['show_stock']):?>
						<?php if($element['stock_product'] <= 0):?>
						<div class="stock label label-danger">Quedan <?php echo $element['stock_product'];?> und.</div>
						<?php else:?>
						<div class="stock label label-warning">Quedan <?php echo $element['stock_product'];?> und.</div>
						<?php endif;?>
						<br />
					<?php endif;?>

					<?php if($module_config['options']['show_price']):?>
						<?php if($element['price_product'] > $user_detail['creditos']):?>
						<div class="price label label-danger"><?php echo $element['price_product'];?> <?php e_strTranslate("APP_Credits");?></div>
						<?php else:?>
						<div class="price label label-info"><?php echo $element['price_product'];?> <?php e_strTranslate("APP_Credits");?></div>
						<?php endif;?>
					<?php endif;?>

					<?php if($module_config['options']['show_buybutton']):?>
						<?php if(date("Y-m-d") >= $element['date_ini_product'] && date("Y-m-d") <= $element['date_fin_product']):?>
							<a href="shopproductorder?id=<?php echo $element['id_product'];?>" class="btn-order btn btn-primary btn-block <?php echo $card_disabled;?>"><?php echo $card_text;?></a>
						<?php else:?>
							<button class="btn-order btn btn-primary btn-block disabled" ><?php e_strTranslate("Comming_soon");?></button>
						<?php endif;?>
					<?php endif;?>
				</div>
			<?php endforeach; ?>

			<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], 'shopproducts', 'Pedidos', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<?php searchProducts();?>
			<?php creditsShow($_SESSION['user_name']);?>
		</div>
	</div>
</div>