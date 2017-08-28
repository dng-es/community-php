<?php 
addCss(array(getAsset("prestashop")."css/styles.css"));
templateload("orders", "prestashop");
$id_order = (isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0);
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("APP_Prestashop"), "ItemUrl"=>"ps-products"),
			array("ItemLabel"=>strTranslate("Shop_my_orders"), "ItemUrl"=>"ps-orders"),
			array("ItemLabel"=> strTranslate("Shop_order"), "ItemClass"=>"active"),
		));
		
		session::getFlashMessage('actions_message');	

		if($id_order > 0):
			$order = prestashopOrdersController::getOrder($id_order);
		 	printDetailOrder($order);
		else:
			echo '<a class="btn btn-primary" href="javascript:history.go(-2)">'.strTranslate("Go_back").'</a>';
		endif;
		?>
	</div>
	<div class="app-sidebar hidden-xs hidden-sm">
		<div class="panel-interior">
			<h2><?php e_strTranslate("APP_Prestashop");?></h2>
			<p>Puedes canjear tus <?php e_strTranslate("APP_Credits");?> por fantasticos <?php strtolower(e_strTranslate("Shop_products"));?>!</p>
			<p class="text-center"><i class="fa fa-shopping-cart fa-big"></i></p>
		</div>
	</div>
</div>