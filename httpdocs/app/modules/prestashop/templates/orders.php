<?php 
function printDetailOrder($order){ 
	//verificar acceso al pedido. Solo pueden verlo los administradores y el usuario que compra
	if ($_SESSION['user_perfil'] != 'admin' && intval($order->order->id_customer) != $_SESSION['id_externo']) e_strTranslate("Access_denied");
	else{
		$id_order = intval($order->order->id);
		$module_config = getModuleConfig("prestashop");
		$id_product = intval($order->order->associations->order_rows->order_row->product_id);
		$id_address = intval($order->order->id_address_delivery);
		$id_state = intval($order->order->current_state);
		$product = prestashopProductsController::showProducts($id_product, 'info');
		$address = prestashopCustomersController::getAddress($id_address);
		$state = prestashopOrdersController::getOrderState($id_state);
		// echo '<pre>';
		// var_dump($order);
		// echo '</pre>';
		?>
		<div class="panel">
			<div class="panel-body">
				<div class="row order-detail">
					<div class="col-md-2">
						<div class="img-shop-container inset">
							<img src="<?php echo $product['image'];?>" width="100%" />
						</div>
					</div>
					<div class="col-md-5">
						<div class="row">
							<div class="col-md-12 nopadding">
								<div class="product-shop-container">
									<div class="row">
										<div class="col-md-12">
											<h3><?php echo $product['name'];?></h3>
											<div class="text-muted"><?php echo $product['description'];?></div>
											<div class="row">
												<div class="col-md-12 nopadding">
													<small class="text-muted">
														<th class="text-center"><?php e_strTranslate("Price");?></th>
													</small>
													<hr class="m-t-2 m-b-5">
													<h4 class="text-right">
														<?php if($module_config['options']['show_price']) echo '<big><strong>'.intval($order->order->associations->order_rows->order_row->product_price)."</strong></big> <span class='text-muted'>".strTranslate("APP_Credits").'</span>';?>		
													</h4>
												</div>
											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-5">
						<div class="row">
							<div class="col-md-12 nopadding order-ref">
								<small class="text-muted">Referencia del pedido</small>
								<hr class="m-t-2 m-b-5">
								<p class="text-right">
									<?php echo $order->order->reference;?>
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 nopadding order-address">
								<small class="text-muted">Dirección de entrega</small>
								<hr class="m-t-2 m-b-5">
								<p>
									<span class="fa-stack">
									  <i class="fa fa-square fa-stack-2x text-muted"></i>
									  <i class="fa fa-user fa-stack-1x fa-inverse"></i>
									</span>
									<?php echo $address->address->firstname;?> <?php echo $address->address->lastname;?><br />
									<span class="fa-stack">
									  <i class="fa fa-square fa-stack-2x text-muted"></i>
									  <i class="fa fa-map-marker fa-stack-1x fa-inverse"></i>
									</span>
									<?php echo $address->address->address1;?> <?php echo $address->address->address2;?><br />
									<span class="fa-stack">
									  <i class="fa fa-square fa-stack-2x text-muted"></i>
									  <i class="fa fa-building fa-stack-1x fa-inverse"></i>
									</span>
									<?php echo $address->address->postcode;?>, <?php echo $address->address->city;?><br />
									<span class="fa-stack">
									  <i class="fa fa-square fa-stack-2x text-muted"></i>
									  <i class="fa fa-phone fa-stack-1x fa-inverse"></i>
									</span>
									<?php echo $address->address->phone;?>
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 nopadding order-date">
								<small class="text-muted">Fecha del pedido</small>
								<hr class="m-t-2 m-b-5">
								<p class="text-right"><?php echo getDateFormat($order->order->date_add, 'DATE_TIME');?></p>
								<small class="text-muted"><?php e_strTranslate("Estado");?></small>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 nopadding">
								<?php printHistoryOrder($id_order);?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php }
}

function printPreOrder($id_product){ 
	$module_config = getModuleConfig("prestashop");
	$addresses = prestashopCustomersController::getAddresses($_SESSION['id_externo']);
	$id_address = intval($addresses->address->attributes()->id);
	$product = prestashopProductsController::showProducts($id_product, 'info');
	$address = prestashopCustomersController::getAddress($id_address);
	// echo '<pre>';
	// var_dump($order);
	// echo '</pre>';
	templateload("addresses", "users");
	$usuario = usersController::getPerfilAction($_SESSION['user_name']);
	?>
	<div class="panel">
		<div class="panel-default">
			<div class="row">
				<div class="col-md-12">
					<h2>Datos del pedido</h2>
					<hr />
				</div>
			</div>
			<div class="row">
				<div class="col-md-5">
					<h3>Dirección de entrega</h3>
					<?php userAddress($usuario);?>
				</div>
				<div class="col-md-7">
					<div class="row">
						<div class="col-md-12 nopadding">
							<div class="product-shop-container">
								<div class="row">
									<div class="col-md-8">
										<h3><?php echo $product['name'];?></h3>
										<div class="text-muted"><?php echo $product['description'];?></div>
										<div class="row">
											<div class="col-md-6">
												<small class="text-muted">
													<?php if($module_config['options']['show_price']) echo '<th class="text-center">'.strTranslate("Price").'</th>';?>
												</small>
												<hr class="m-t-2 m-b-5">
												<h4 class="text-right">
													<?php if($module_config['options']['show_price']) echo '<big><strong>'.intval($product['price'])."</strong></big> <span class='text-muted'>".strTranslate("APP_Credits").'</span>';?>			
												</h4>
											</div>
											<div class="col-md-6">
												<small class="text-muted">
													<?php if($module_config['options']['show_price']) echo '<th class="text-center">'.strTranslate("Stock").'</th>';?>
												</small>
												<hr class="m-t-2 m-b-5">
												<h4 class="text-right">
													<?php if($module_config['options']['show_stock']) echo '<big><strong>'.intval($product['quantity'])."</strong></big> <span class='text-muted'>".strTranslate("Unids.").'</span>';?>				
												</h4>
											</div>
										</div>
									</div>
									<div class="col-md-4 nopadding">
										<div class="img-shop-container">
											<img src="<?php echo $product['image'];?>" width="100%" />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-md-offset-8 text-right">
					<?php if($module_config['options']['show_buybutton']):?> 
						<?php if($product['quantity'] > 0):?> 
							<button onClick="Confirma('¿Seguro que deseas realizar el pedido?', 'ps-order?id=<?php echo $product['id'];?>'); return false" class="btn btn-lg btn-primary">Realizar pedido</button>
						
						<?php else:?>
							<button class="btn btn-lg btn-default btn-block disabled">No disponible</button>
						<?php endif;?>
					<?php endif;?>			
				</div>
			</div>
			<br />
		</div>
	</div>
<?php } 

function printHistoryOrder($id_order){ 
	$histories = prestashopOrdersController::getOrderHistories($id_order);
	foreach($histories->order_histories->order_history as $history):
		$data = prestashopOrdersController::getOrderHistory($history->attributes()->id);
		$id_state = $data->order_history->id_order_state;
		$state = prestashopOrdersController::getOrderState($id_state);?>
		<p class="text-right inset" style="background-color:#f0f0f0">
			<i class="fa fa-info-circle fa-5x fa-inverse pull-left" aria-hidden="true"></i>
			<span class="text-uppercase text-primary"><strong><?php echo $state->order_state->name->language;?></strong></span><br />
			<small class="text-muted"><?php echo getDateFormat($data->order_history->date_add, 'DATE_TIME');?></small>
		</p>
	<?php endforeach;
}
?>