<?php 
templateload("orders", "prestashop");
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
		usersController::updateAddressAction($_SERVER['REQUEST_URI'], $_SESSION['user_name']);
		if($id_product > 0):
		 	 printPreOrder($id_product);
		else:
			echo '<a class="btn btn-primary" href="javascript:history.go(-2)">'.strTranslate("Go_back").'</a>';
		endif;
		?>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			
		</div>
	</div>
</div>