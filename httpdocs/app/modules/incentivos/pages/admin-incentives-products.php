<?php
addJavascripts(array(getAsset("incentivos")."js/admin-incentives-products.js"));

session::getFlashMessage( 'actions_message' ); 
incentivosProductosController::createAction();
incentivosProductosController::deleteAction();
$elements = incentivosProductosController::getListAction(35);
?>

<div class="row row-top">
	<div class="col-md-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"#"),
			array("ItemLabel"=>"Productos", "ItemClass"=>"active"),
		));
		?>
		<div class="row">
			<div class="col-md-7">
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
						<th width="40px"></th>
						<th>Ref.</th>
						<th>Producto</th>
						<th>Fabricante</th>
						</tr>	
						<?php foreach($elements['items'] as $element):?>
							<tr>
							<td nowrap="nowrap">
								<span class="fa fa-gear icon-table" title="aceleradores" onClick="location.href='admin-incentives-products-acelerators?ref=<?php echo $element['referencia_producto'];?>'"></span>					
								<span class="fa fa-ban icon-table" title="Eliminar"
									onClick="Confirma('¿Seguro que desea eliminar el fabricante?', 'admin-incentives-products?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['referencia_producto'];?>')">
								</span>
							</td>					
							<td><?php echo $element['referencia_producto'];?></td>
							<td><?php echo $element['nombre_producto'];?></td>
							<td><?php echo $element['nombre_fabricante'];?></td>
							</tr>  
						<?php endforeach; ?>
					</table>
				</div>
			</div>
			<div class="col-md-5">
				<div class="panel panel-default">
					<div class="panel-heading">Nuevo producto</div>
					<div class="panel-body">
						<form role="form" action="" method="post" name="formData" id="formData">
							<label for="producto-referencia">Referencia del producto</label>
							<input type="text" class="form-control" name="producto-referencia" id="producto-referencia" data-alert="<?php echo strTranslate("Required_field");?>" />
							<label for="producto-nombre">Nombre del producto</label>
							<input type="text" class="form-control" name="producto-nombre" id="producto-nombre" data-alert="<?php echo strTranslate("Required_field");?>" />
							<label for="id_fabricante">Fabricante</label>
							<select name="id_fabricante" id="id_fabricante" class="form-control">
							<?php 
							$incentivos = new incentivos();
							$fabricantes = $incentivos->getIncentivesFabricantes(" AND activo_fabricante=1 ORDER BY nombre_fabricante ");
							foreach($fabricantes as $fabricante):
								echo '<option value="'.$fabricante['id_fabricante'].'">'.$fabricante['nombre_fabricante'].'</option>';
							endforeach;
							?>
							</select>
							<br />
							<button type="submit" class="btn btn-primary">Crear producto</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>