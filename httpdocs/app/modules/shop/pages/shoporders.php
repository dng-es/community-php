<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("APP_Shop"), "ItemUrl"=>"shopproducts"),
			array("ItemLabel"=> strTranslate("Shop_my_orders"), "ItemClass"=>"active"),
		));
		
		$filtro = " AND username_order='".$_SESSION['user_name']."' ";
		$find_reg = getFindReg();
		if ($find_reg != '') $filtro .= " AND d.id_order LIKE '%".intval($find_reg)."%' ";

		$filtro .= " ORDER BY d.id_order DESC";
		$elements = shopOrdersController::getListDetailAction(15, $filtro);
		$tot_credits = connection::sumReg("shop_orders_details", "(amount_product*price_product)", " AND id_order IN (SELECT id_order FROM shop_orders WHERE status_order<>'cancelado' AND username_order='".$_SESSION['user_name']."') ");
		?>
		<ul class="nav nav-pills navbar-default">
			<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
			<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <?php e_strTranslate("APP_Credits");?> <b><?php echo $tot_credits;?></b></a></li>
			<div class="pull-right">
				<?php echo SearchForm($elements['reg'], "shoporders", "searchForm", strTranslate("Search"), strTranslate("Search"), "", "navbar-form navbar-left", "get");?>
			</div>
		</ul>
		<div class="table-responsive">
			<table class="table">
				<tr>
					<th width="40px">&nbsp;</th>
					<th>ID</th>
					<th></th>
					<th><?php e_strTranslate("Shop_product");?></th>
					<th><?php e_strTranslate("Date");?></th>
					<th class="text-right"><?php echo ucfirst(strTranslate("APP_Credits"));?></th>
				</tr>
				<?php foreach($elements['items'] as $element):?>
				<?php $tot_order = connection::sumReg("shop_orders_details", "(amount_product*price_product)", " AND id_order=".$element['id_order']." ");?>
				<tr>
					<td nowrap="nowrap">
						<span class="fa fa-edit icon-table" title="ver pedido"
							onClick="location.href='shopproductorderdetail?id=<?php echo $element['id_order'];?>'">
						</span>
					</td>
					<td><?php echo $element['id_order'];?></td>
					<td>
						<?php if($element['status_order'] == 'cancelado'):?>
							<span class="label label-danger">Cancelado</span>
						<?php endif;?>

						<?php if($element['status_order'] == 'finalizado'):?>
							<span class="label label-success">Finalizado</span>
						<?php endif;?>

						<?php if($element['status_order'] == 'pendiente'):?>
							<span class="label label-warning">Pendiente</span>
						<?php endif;?>
					</td>
					<td><?php echo $element['name_product'];?></td>
					<td><?php echo getDateFormat($element['date_order'], 'SHORT');?></td>
					<td class="text-right"><?php echo $tot_order;?></td>
				</tr>
				<?php endforeach;?>
			</table>
		</div>
		<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], 'shoporders', strTranslate("Shop_orders"), $elements['find_reg']);?>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<h2><?php e_strTranslate("APP_Shop");?></h2>
			<p>Puedes canjear tus <?php e_strTranslate("APP_Credits");?> por fantasticos <?php strtolower(e_strTranslate("Shop_products"));?>!</p>
			<p class="text-center"><i class="fa fa-shopping-cart fa-big"></i></p>
		</div>
	</div>
</div>