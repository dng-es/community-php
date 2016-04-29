<?php 
addCss(array(getAsset("shop")."css/styles.css"));
templateload("searchproducts","shop");

session::getFlashMessage( 'actions_message' );
$filtro = " AND active_product=1 ";

if (isset($_REQUEST['ref_search'])) $filtro .= " AND ref_product LIKE '%".$_REQUEST['ref_search']."%' ";
if (isset($_REQUEST['name_search'])) $filtro .= " AND name_product LIKE '%".$_REQUEST['name_search']."%' ";
if (isset($_REQUEST['manufacturer_search'])) $filtro .= " AND name_manufacturer LIKE '%".$_REQUEST['manufacturer_search']."%' ";
if (isset($_REQUEST['category_search'])) $filtro .= " AND category_product LIKE '%".$_REQUEST['category_search']."%' ";
if (isset($_REQUEST['subcategory_search'])) $filtro .= " AND subcategory_product LIKE '%".$_REQUEST['subcategory_search']."%' ";

$filtro .= " ORDER BY important_product DESC, price_product ASC, name_product ASC";

session::getFlashMessage( 'actions_message' );
$elements = shopProductsController::getListAction(15, $filtro);

//obtener datos del usuario
$user_detail = usersController::getPerfilAction($_SESSION['user_name']);
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("APP_Shop"), "ItemUrl"=>"shopproducts"),
			array("ItemLabel"=> strTranslate("Shop_products_list"), "ItemClass"=>"active"),
		));
		//var_dump($elements['items']);
		?>

		<div class="row">
			<div class="col-md-12">
		<?php foreach($elements['items'] as $element): 
				$card_text = "Canjear";
				$card_text = ($element['price_product'] > $user_detail['creditos'] ? "No canjeable" : $card_text);
				$card_text = ($element['stock_product'] <=0 ? "No canjeable" : $card_text);
				$card_disabled = ($element['price_product'] > $user_detail['creditos'] ? "disabled" : "");
				$card_disabled = ($element['stock_product'] <=0 ? "disabled" : $card_disabled);
				?>
				<div class="card-section">
					<h3 class="ellipsis"><?php echo $element['name_product'];?></h3>
					<a href="shopproduct?id=<?php echo $element['id_product'];?>">
						<img src="images/shop/<?php echo $element['image_product'];?>" />
					</a>
					<div class="description"><?php echo shortText(html_entity_decode(strip_tags($element['description_product'])), 50);?></div>
					<div class="ver-mas"><a href="shopproduct?id=<?php echo $element['id_product'];?>">ver más</a></div>
					<div <?php echo ($element['important_product'] == 0 ? 'style="visibility:hidden"' : "");?>>
					<div class="label label-danger" >Producto destacado</div>
					</div>
					
					<?php if($element['stock_product'] <= 0):?>
					<div class="stock label label-danger">Quedan <?php echo $element['stock_product'];?> und.</div>
					<?php else:?>
					<div class="stock label label-warning">Quedan <?php echo $element['stock_product'];?> und.</div>
					<?php endif;?>
					<br />
					<?php if($element['price_product'] > $user_detail['creditos']):?>
					<div class="price label label-danger"><?php echo $element['price_product'];?> <?php e_strTranslate("APP_Credits");?></div>
					<?php else:?>
					<div class="price label label-info"><?php echo $element['price_product'];?> <?php e_strTranslate("APP_Credits");?></div>
					<?php endif;?>
					<a href="shopproductorder?id=<?php echo $element['id_product'];?>" class="btn-order btn btn-primary btn-block <?php echo $card_disabled;?>"><?php echo $card_text;?></a>
				</div>
		<?php endforeach; ?>

		<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], 'shopproducts','Pedidos', $elements['find_reg']);?>
		</div>
		</div>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<?php searchProducts();?>
		</div>
	</div>
</div>