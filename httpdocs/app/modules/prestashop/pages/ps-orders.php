<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("APP_Prestashop"), "ItemUrl"=>"shopproducts"),
			array("ItemLabel"=> strTranslate("Shop_my_orders"), "ItemClass"=>"active"),
		));

		$find_reg = "";
		$total_orders = prestashopOrdersController::getTotalOrders( $_SESSION['id_externo']);
		$reg = 8;
		$paginator_items = PaginatorPages($reg);
		$elements = prestashopOrdersController::getOrders($paginator_items['inicio'].','.$reg, $_SESSION['id_externo']);
		// echo '<pre>';
		// var_dump($elements);
		// echo '</pre>';
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $total_orders;?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="40px">&nbsp;</th>
							<th>REF.</th>
							<th>Estado</th>
							<th><?php e_strTranslate("Date");?></th>
							<th class="text-right">Total</th>
						</tr>
						<?php foreach($elements->order as $element): 
						$id_order = $element->attributes()->id;
						$order = prestashopOrdersController::getOrder($id_order);
						$id_state = intval($order->order->current_state);
						$state = prestashopOrdersController::getOrderState($id_state);
						?>
						<tr>
							<td nowrap="nowrap">
								<span class="fa fa-edit icon-table" title="ver pedido"
									onClick="location.href='ps-order-view?id=<?php echo $id_order;?>'">
								</span>
							</td>
							<td><?php echo $order->order->reference;?></td>
							<td><?php echo $state->order_state->name->language;?></td>
							<td><?php echo getDateFormat($order->order->date_add, 'DATE_TIME');?></td>
							<td class="text-right"><?php echo ceil(floatval($order->order->total_paid_real));?> <em class="text-muted"><?php e_strTranslate("APP_Credits");?></em></td>
						</tr>
						<?php endforeach;?>
					</table>
				</div>
				<?php Paginator($paginator_items['pag'], $reg, $total_orders, 'ps-orders', '', $find_reg);?>
			</div>
		</div>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<h2><?php e_strTranslate("APP_Prestashop");?></h2>
			<p>Puedes canjear tus <?php e_strTranslate("APP_Credits");?> por fantasticos <?php strtolower(e_strTranslate("Shop_products"));?>!</p>
			<p class="text-center"><i class="fa fa-shopping-cart fa-big"></i></p>
		</div>
	</div>
</div>