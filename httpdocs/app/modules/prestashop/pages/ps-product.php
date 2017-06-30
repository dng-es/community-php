<?php 
addCss(array(getAsset("prestashop")."css/styles.css"));
templateload("products", "prestashop");
templateload("searchproducts","prestashop");
templateload("credits","prestashop");
$id_product = (isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0);
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
		
		prestashopProductsController::showProducts($id_product, 'detail');
		?>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<?php searchProducts();?>
			<?php creditsShow($_SESSION['id_externo']);?>
		</div>
	</div>
</div>