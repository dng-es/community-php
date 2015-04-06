<?php
incentivosProductosController::exportAction();

addJavascripts(array(getAsset("incentivos")."js/admin-incentives-products.js"));

$filtro_productos = ((isset($_REQUEST['m']) and $_REQUEST['m'] > 0) ? " AND p.id_fabricante=".$_REQUEST['m']." " : "");

session::getFlashMessage( 'actions_message' ); 
incentivosProductosController::createAction();
incentivosProductosController::deleteAction();
$elements = incentivosProductosController::getListAction(35, $filtro_productos);
?>

<div class="row row-top">
	<div class="col-md-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"admin-incentives"),
			array("ItemLabel"=>strTranslate("Incentives_products"), "ItemClass"=>"active"),
		));
		?>
		<ul class="nav nav-pills navbar-default">       
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
			<li><a href="<?php echo $_REQUEST['page'].'?export=true';?>"><?php echo strTranslate("Export");?></a></li>
		</ul>
		<br />
		<div class="row">
			<div class="col-md-7">
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
						<th width="40px"></th>
						<th>Ref.</th>
						<th><?php echo strTranslate("Incentives_products");?></th>
						<th><?php echo strTranslate("Incentives_manufacturers");?></th>
						<th><center><?php echo strTranslate("Incentives_acelerators");?></center></th>
						<th><center><?php echo strTranslate("Incentives_points");?></center></th>
						</tr>	
						<?php foreach($elements['items'] as $element):?>
							<tr>
							<td nowrap="nowrap">
								<span class="fa fa-ban icon-table" title="<?php echo strTranslate("Delete");?>"
									onClick="Confirma('<?php echo strTranslate("Are_you_sure_to_delete");?>', 'admin-incentives-products?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['id_producto'];?>', '<?php echo strTranslate("Are_you_sure");?>', '<?php echo strTranslate("Cancel_text");?>', '<?php echo strTranslate("Confirm_text");?>')">
								</span>
							</td>					
							<td><?php echo $element['referencia_producto'];?></td>
							<td><?php echo $element['nombre_producto'];?></td>
							<td><?php echo $element['nombre_fabricante'];?></td>
							<td>
								<center><a href="admin-incentives-products-acelerators?ref=<?php echo $element['id_producto'];?>">
								<?php 
								//obtener numero de aceleradores creados
								$contador = connection::countReg("incentives_productos_aceleradores"," AND id_producto=".$element['id_producto']." ");
								echo $contador;
								?>
								</a></center>
							</td>
							<td>
								<center><a class="btn btn-default btn-xs" href="admin-incentives-products-points?ref=<?php echo $element['id_producto'];?>"><?php echo strTranslate("Incentives_points");?></a>
							</a>
							</tr>  
						<?php endforeach; ?>
					</table>
				</div>
			</div>
			<div class="col-md-5">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo strTranslate("Incentives_products_new");?></div>
					<div class="panel-body">
						<form role="form" action="" method="post" name="formData" id="formData">
							<div class="form-group">
								<label for="producto-referencia">Ref.</label>
								<input type="text" class="form-control" name="producto-referencia" id="producto-referencia" data-alert="<?php echo strTranslate("Required_field");?>" />
							</div>

							<div class="form-group">
								<label for="producto-nombre"><?php echo strTranslate("Incentives_product");?></label>
								<input type="text" class="form-control" name="producto-nombre" id="producto-nombre" data-alert="<?php echo strTranslate("Required_field");?>" />
							</div>

							<div class="form-group">
								<label for="id_fabricante"><?php echo strTranslate("Incentives_manufacturer");?></label>
								<select name="id_fabricante" id="id_fabricante" class="form-control">
								<?php 
								$incentivos = new incentivos();
								$fabricantes = $incentivos->getIncentivesFabricantes(" AND activo_fabricante=1 ORDER BY nombre_fabricante ");
								foreach($fabricantes as $fabricante):
									echo '<option value="'.$fabricante['id_fabricante'].'" '.((isset($_REQUEST['m']) and $_REQUEST['m'] > 0 and $_REQUEST['m']==$fabricante['id_fabricante']) ? ' selected="selected" ' : '').'>'.$fabricante['nombre_fabricante'].'</option>';
								endforeach;
								?>
								</select>
							</div>
							<button type="submit" class="btn btn-primary"><?php echo strTranslate("Save_data");?></button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>