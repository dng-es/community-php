<?php
incentivosController::exportPuntuacionesAction();
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"admin-incentives-ventas"),
			array("ItemLabel"=>strTranslate("Incentives_sales"). " detalle", "ItemUrl"=>"admin-incentives-ventas"),
			array("ItemLabel"=>"Puntos asignados", "ItemClass"=>"active"),
		));
		session::getFlashMessage('actions_message'); 
		$elements = incentivosController::getListPuntosAction(35, " ");
		?>
		<ul class="nav nav-pills navbar-default">
			<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
			<li><a href="<?php echo $_REQUEST['page'].'?export=true';?>"><?php e_strTranslate("Export");?></a></li>
			<div class="pull-right">
				<?php echo SearchForm($elements['reg'],"admin-incentives-ventas-puntos","searchForm","buscar usuario","Buscar","","navbar-form navbar-left");?>	
			</div>
		</ul>
		<br />
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table">
						<tr>
						<th><?php e_strTranslate("Username");?></th>
						<th><?php e_strTranslate("Incentives_product");?></th>
						<th><?php e_strTranslate("Date");?></th>
						<th><center><?php e_strTranslate("Incentives_points");?></center></th>
						</tr>
						<?php foreach($elements['items'] as $element):?>
							<tr>
							<td>
								<?php echo $element['username_puntuacion'];?><br />
								<small><em class="text-muted"><?php echo $element['surname'];?>, <?php echo $element['name'];?></em></small>
							</td>
							<td>
								<?php echo $element['referencia_producto'];?>
								<br /><small class="text-muted"><?php echo $element['nombre_producto'];?> - <?php echo $element['nombre_fabricante'];?><em></em></small>
							</td>
							<td><?php echo getDateFormat( $element['date_venta'], "SHORT");?></td>
							<td><center><?php echo $element['puntuacion_venta'];?></center></td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
				<div class="pull-right text-muted"><em>Total puntos asignados: <?php echo $elements['total_sum'];?></em></div>
			</div>
		</div>
		<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>