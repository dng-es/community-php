<?php
incentivosController::exportAction(" AND username_venta='".$_SESSION['user_name']."' ");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"incentives-ventas"),
			array("ItemLabel"=>strTranslate("Incentives_my_sales"), "ItemClass"=>"active"),
		));

		session::getFlashMessage('actions_message' ); 
		$elements = incentivosController::getListAction(35, " AND username_venta='".$_SESSION['user_name']."' ");
		$incentivos = new incentivos();
		$total_puntos = connection::sumReg("incentives_ventas_puntos", "puntuacion_venta", " AND username_puntuacion='".$_SESSION['user_name']."' ");
		?>
		<ul class="nav nav-pills navbar-default">
			<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
			<li><a href="<?php echo $_REQUEST['page'].'?export=true';?>"><?php e_strTranslate("Export");?></a></li>
		</ul>
		<br />
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th><?php e_strTranslate("Incentives_product");?></th>
							<th><?php e_strTranslate("Date");?></th>
							<th><center><?php e_strTranslate("Incentives_sales");?></center></th>
							<th><center><?php e_strTranslate("Incentives_points");?></center></th>
						</tr>	
						<?php foreach($elements['items'] as $element):?>
						<?php
							$puntos_conseguidos = $incentivos->getVentasPuntuaciones(" AND username_puntuacion='".$_SESSION['user_name']."' AND id_producto_venta=".$element['id_producto']." AND date_venta='".$element['fecha_venta']."' ");
							$puntuacion = (count($puntos_conseguidos) > 0 ? $puntos_conseguidos[0]['puntuacion_venta'] : 0);
						?>
						<tr>
							<td>
								<?php echo $element['referencia_producto'];?>
								<br /><small class="text-muted"><?php echo $element['nombre_producto'];?> - <?php echo $element['nombre_fabricante'];?><em></em></small>
							</td>
							<td><?php echo getDateFormat( $element['fecha_venta'], "SHORT");?></td>
							<td><center><?php echo $element['cantidad_venta'];?></center></td>
							<td><center><?php echo $puntuacion;?></center></td>
						</tr>
						<?php endforeach; ?>
					</table>
				</div>
				<div class="pull-right text-muted"><em>Total puntos conseguidos: <?php echo $total_puntos;?></em></div>
			</div>
		</div>
		<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<h4><?php e_strTranslate("Incentives");?></h4>
			<p>Estas son tus ventas y los puntos conseguidos por ellas.</p>
			<p class="text-center"><i class="fa fa-gift fa-big"></i></p>
		</div>
	</div>
</div>