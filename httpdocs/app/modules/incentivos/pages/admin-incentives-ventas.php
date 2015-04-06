<?php
incentivosController::exportAction();

session::getFlashMessage( 'actions_message' ); 
$elements = incentivosController::getListAction(35, " ");
$users = new users();
?>

<div class="row row-top">
	<div class="col-md-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"admin-incentives-ventas"),
			array("ItemLabel"=>strTranslate("Incentives_sales"). " detalle", "ItemClass"=>"active"),
		));
		?>
		<ul class="nav nav-pills navbar-default">       
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
			<li><a href="<?php echo $_REQUEST['page'].'?export=true';?>"><?php echo strTranslate("Export");?></a></li>
			<li><a href="admin-incentives-ventas-cargas">Cargar fichero</a></li>
			<li><a href="admin-incentives-ventas-puntos">Puntos asignados</a></li>
		</ul>
		<br />

		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th><?php echo strTranslate("Username");?></th>
							<th><?php echo strTranslate("Incentives_product");?></th>
							<th><?php echo strTranslate("Date");?></th>
							<th><center>Cantidad</center></th>
						</tr>	
						<?php foreach($elements['items'] as $element):?>
						<tr>					
							<td>
								<?php echo $element['username_venta'];?><br />
								<small><em class="text-muted"><?php echo $element['surname'];?>, <?php echo $element['name'];?></em></small>
							</td>
							<td>
								<?php echo $element['referencia_producto'];?>
								<br /><small class="text-muted"><?php echo $element['nombre_producto'];?> - <?php echo $element['nombre_fabricante'];?><em></em></small>
							</td>
							<td><?php echo getDateFormat( $element['fecha_venta'], "SHORT");?></td>
							<td><center><?php echo $element['cantidad_venta'];?></center></td>
						</tr>  
						<?php endforeach; ?>
					</table>
				</div>
			</div>
		</div>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>