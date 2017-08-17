<?php
addJavascripts(array("js/jquery.numeric.js", getAsset("shop")."js/shopproductorder.js"));
addCss(array(getAsset("shop")."css/styles.css"));
templateload("credits","shop");

$id = ((isset($_REQUEST['id']) && $_REQUEST['id'] > 0) ? sanitizeInput($_REQUEST['id']) : 0);
$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND canal_product LIKE '%".$_SESSION['user_canal']."%' " : "");
$filtro = $filtro_canal." AND active_product=1 AND id_product=".$id." ";

session::getFlashMessage( 'actions_message' );
$elements = shopProductsController::getListAction(1, $filtro);

//obtener datos del usuario praa rellenar cuestionario
$user_detail = usersController::getPerfilAction($_SESSION['user_name']);

//obtener datos del usuario para rellenar cuestionario:
//- si el usuario ha realizado alguna vez un pedido, se toman los datos del último
//- si nunca ha hecho un pedido, se toman los del perfil
//$last_order = shopOrdersController::getListAction(1, " AND username_order='".$_SESSION['user_name']."' order BY id_order DESC");

//obtener datos de la tienda para rellenar cuestionario
$last_order = usersTiendasController::getListAction(1, " AND cod_tienda='".$_SESSION['user_empresa']."' ");
if (isset($last_order['items'][0])){
	$name_order = $user_detail['name'];
	$surname_order = $user_detail['surname'];
	$telephone_order = $user_detail['telefono'];
	$address_order = $last_order['items'][0]['nombre_tienda'];
	$address2_order = $last_order['items'][0]['direccion_tienda'];
	$city_order = $last_order['items'][0]['ciudad_tienda'];
	$state_order = $last_order['items'][0]['provincia_tienda'];
	$postal_order = $last_order['items'][0]['cpostal_tienda'];
	$notes_order = "";
}
else{
	//obtener datos del usuario
	$user_detail = usersController::getPerfilAction($_SESSION['user_name']);
	$name_order = $user_detail['name'];
	$surname_order = $user_detail['surname'];
	$telephone_order = $user_detail['telefono'];
	$address_order = $user_detail['direccion_user'];
	$address2_order = "";
	$city_order = $user_detail['ciudad_user'];
	$state_order = $user_detail['provincia_user'];
	$postal_order = $user_detail['cpostal_user'];
	$notes_order = "";
}

$module_config = getModuleConfig("shop");

?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("APP_Shop"), "ItemUrl"=>"shopproducts"),
			array("ItemLabel"=> "Realizar pedido", "ItemClass"=>"active"),
		));
		if (isset($elements['items'][0])):
			$element = $elements['items'][0];?>

		<div class="col-md-10 col-md-offset-1 panel inset">
			<div class="panel panel-default">
				<div class="row">
					<div class="col-md-12">
						<h1><?php e_strTranslate("Shop_order_details");?></h1>
						<hr />
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<img src="images/shop/<?php echo $element['image_product'];?>" width="100%" />
					</div>
					<div class="col-md-10">
						<h4 class="product-title"><?php echo $element['name_product'];?></h4>
						<?php if($element['important_product'] == 1):?>
							<div class="label label-danger"><small>Producto destacado</small></div> 
						<?php endif;?>

						<?php if($module_config['options']['show_stock']):?>
							<div class="label label-warning stock"><small>Quedan <?php echo $element['stock_product'];?> unidades</small></div>
						<?php endif;?>
						<?php if($module_config['options']['show_price']):?>
							<div class="label label-info price"><small><?php echo $element['price_product'];?> <?php e_strTranslate("APP_Credits");?></small></div>
						<?php endif;?>
						<h6 class="description"><?php echo shortText(html_entity_decode(strip_tags($element['description_product'])), 50);?></h6>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<hr />
					</div>
				</div>

				<?php if($element['stock_product'] <= 0):?>
					<div class="row">
						<div class="col-md-12">
							Lo sentimos, no queda stock del producto seleccionado
						</div>
					</div>
				<?php elseif($element['price_product'] > $user_detail['creditos']):?>
					<div class="row">
						<div class="col-md-12">
							Lo sentimos, no dispones de <?php e_strTranslate("APP_Credits");?> suficientes
						</div>
					</div>
				<?php elseif(!(date("Y-m-d") >= $element['date_ini_product'] && date("Y-m-d") <= $element['date_fin_product'])):?>
					<div class="row">
						<div class="col-md-12">
							<?php e_strTranslate("Comming_soon");?>
						</div>
					</div>
				<?php else:?>
					<form action="shopproductorderdetail" method="post" id="form-order" name="form-order">
						<input type="hidden" name="id_product" id="id_product" value="<?php echo $id;?>" />
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label" for="name_order"><small><?php e_strTranslate("Name");?></small></label>
									<input value="<?php echo $name_order;?>" tabindex=1 type="text" name="name_order" id="name_order" class="form-control" data-alert="<?php e_strTranslate("Required_field");?>" />
								</div>
								<div class="form-group">
									<label class="control-label" for="address_order"><small><?php e_strTranslate("Group_user");?></small></label>
									<input readonly="readonly" value="<?php echo $address_order;?>" tabindex=4 type="text" name="address_order" id="address_order" class="form-control" data-alert="<?php e_strTranslate("Required_field");?>" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label" for="surname_order"><small><?php e_strTranslate("Surname");?></small></label>
									<input value="<?php echo $surname_order;?>" tabindex=2 type="text" name="surname_order" id="surname_order" class="form-control" data-alert="<?php e_strTranslate("Required_field");?>" />
								</div>
								<div class="form-group">
									<label class="control-label" for="city_order"><small><?php e_strTranslate("Localidad");?></small></label>
									<input readonly="readonly" value="<?php echo $city_order;?>" tabindex=5 type="text" name="city_order" id="city_order" class="form-control" data-alert="<?php e_strTranslate("Required_field");?>" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label" for="telephone_order"><small><?php e_strTranslate("Telephone");?></small></label>
									<input value="<?php echo $telephone_order;?>" tabindex=3 type="text" name="telephone_order" id="telephone_order" class="form-control numeric" data-alert="<?php e_strTranslate("Required_field");?>" />
								</div>
								<div class="form-group">
									<label class="control-label" for="state_order"><small><?php e_strTranslate("Provincia");?></small></label>
									<input readonly="readonly" value="<?php echo $state_order;?>" tabindex=6 type="text" name="state_order" id="state_order" class="form-control" data-alert="<?php e_strTranslate("Required_field");?>" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label class="control-label" for="address2_order"><small><?php e_strTranslate("Address");?></small></label>
									<input readonly="readonly" value="<?php echo $address2_order;?>" tabindex=7 type="text" name="address2_order" id="address2_order" class="form-control" data-alert="<?php e_strTranslate("Required_field");?>" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label" for="postal_order"><small><?php e_strTranslate("Postal_code");?></small></label>
									<input readonly="readonly" value="<?php echo $postal_order;?>" tabindex=8 type="text" name="postal_order" id="postal_order" class="form-control numeric" data-alert="<?php e_strTranslate("Required_field");?>" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label" for="notes_order"><small><?php e_strTranslate("Order_notes");?></small></label>
									<textarea tabindex=9 type="text" name="notes_order" id="notes_order" class="form-control" data-alert="<?php e_strTranslate("Required_field");?>"><?php echo $notes_order;?></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<input tabindex=10 type="submit" name="submit-order" id="submit-order" class="btn btn-primary" value="<?php e_strTranslate("Order_product");?>" />
							</div>
						</div>
					</form>
				<?php endif;?>
			</div>
		</div>
		<?php else:?>
		<div class="row">
			<div class="col-md-12">
				<?php e_strTranslate("Error_procesing");?>
			</div>
		</div>
		<?php endif;?>
	</div>


	<div class="app-sidebar">
		<div class="panel-interior">
			<h2><?php e_strTranslate("APP_Shop");?></h2>
			<p>Puedes canjear tus <?php e_strTranslate("APP_Credits");?> por fantasticos <?php strtolower(e_strTranslate("Shop_products"));?>!</p>
			<?php creditsShow($_SESSION['user_name']);?>
			<p class="text-center"><i class="fa fa-shopping-cart fa-big"></i></p>
		</div>
	</div>
</div>