<?php
incentivosProductosController::exportAction();
addJavascripts(array(getAsset("incentivos")."js/admin-incentives-products.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"admin-incentives-targets"),
			array("ItemLabel"=>strTranslate("Incentives_products"), "ItemClass"=>"active"),
		));
		session::getFlashMessage('actions_message');
		incentivosProductosController::createAction();
		incentivosProductosController::deleteAction();
		$filtro_productos = ((isset($_REQUEST['m']) and $_REQUEST['m'] > 0) ? " AND p.id_fabricante=".intval($_REQUEST['m'])." " : "");
		$elements = incentivosProductosController::getListAction(35, $filtro_productos);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="<?php echo $_REQUEST['page'].'?export=true';?>"><?php e_strTranslate("Export");?></a></li>
				</ul>
				<div class="row">
					<div class="col-md-7">
						<div class="table-responsive">
							<table class="table table-hover table-striped">
								<tr>
								<th width="40px"></th>
								<th><?php e_strTranslate("Incentives_products");?></th>
								<th><center><?php e_strTranslate("Incentives_acelerators");?></center></th>
								<th><center><?php e_strTranslate("Incentives_points");?></center></th>
								</tr>
								<?php foreach($elements['items'] as $element):?>
									<tr>
										<td nowrap="nowrap">
											<span class="fa fa-ban icon-table" title="<?php e_strTranslate("Delete");?>"
												onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-incentives-products?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['id_producto'];?>', '<?php e_strTranslate("Are_you_sure");?>', '<?php e_strTranslate("Cancel_text");?>', '<?php e_strTranslate("Confirm_text");?>')">
											</span>
										</td>
										<td>
											<?php echo $element['referencia_producto'];?><br />
											<small class="text-muted"><?php echo $element['nombre_producto'];?> - <?php echo $element['nombre_fabricante'];?></small>
										</td>
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
											<center><a class="btn btn-default btn-xs" href="admin-incentives-products-points?ref=<?php echo $element['id_producto'];?>"><?php e_strTranslate("Incentives_points");?></a></center>
										</td>
									</tr>
								<?php endforeach; ?>
							</table>
						</div>
						<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
					</div>
					<div class="col-md-5">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4><?php e_strTranslate("Incentives_products_new");?></h4>
							</div>
							<div class="panel-body">
								<form role="form" action="" method="post" name="formData" id="formData">
									<div class="form-group col-md-6">
										<label for="producto-referencia">Ref.</label>
										<input type="text" class="form-control" name="producto-referencia" id="producto-referencia" data-alert="<?php e_strTranslate("Required_field");?>" />
									</div>

									<div class="form-group col-md-6">
										<label for="id_fabricante"><?php e_strTranslate("Incentives_manufacturer");?></label>
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

									<div class="form-group col-md-12">
										<label for="producto-nombre"><?php e_strTranslate("Incentives_product");?></label>
										<input type="text" class="form-control" name="producto-nombre" id="producto-nombre" data-alert="<?php e_strTranslate("Required_field");?>" />
									</div>

									<div class="form-group col-md-12">
										<button type="submit" class="btn btn-primary btn-block btn-lg"><?php e_strTranslate("Save_data");?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>