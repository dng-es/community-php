<?php 
addCss(array(getAsset("prestashop")."css/styles.css"));
templateload("products", "prestashop");
templateload("searchproducts","prestashop");
templateload("credits","prestashop");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("APP_Prestashop"), "ItemUrl"=>"ps-products"),
			array("ItemLabel"=> strTranslate("Shop_products_list"), "ItemClass"=>"active"),
		));
		session::getFlashMessage('actions_message');
		
		$find_reg = "";
		if (isset($_REQUEST['name'])) $find_reg = trim(sanitizeInput($_REQUEST['name']));
		if (isset($_REQUEST['f'])) $find_reg = trim(sanitizeInput($_REQUEST['f']));

		$total_products = prestashopProductsController::getProducts('', $find_reg);
		$reg = 12;
		$paginator_items = PaginatorPages($reg);
		prestashopProductsController::showProducts(null, 'list', $paginator_items['inicio'].','.$reg, $find_reg);
		
		Paginator($paginator_items['pag'], $reg, $total_products, 'ps-products', '', $find_reg);?>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<?php searchProducts();?>
			<?php creditsShow($_SESSION['id_externo']);?>
		</div>
	</div>
</div>