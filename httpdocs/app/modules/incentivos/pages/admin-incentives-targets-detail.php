<?php
incentivosObjetivosController::exportDetailAction();

addJavascripts(	array("js/bootstrap-datepicker.js", 
			"js/bootstrap-datepicker.es.js", 
			"js/jquery.numeric.js", 
			getAsset("incentivos")."js/admin-incentives-targets-detail.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"admin-incentives-targets"),
			array("ItemLabel"=>strTranslate("Incentives_targets"), "ItemUrl"=>"admin-incentives-targets"),
			array("ItemLabel"=>strTranslate("Incentives_targets"). " detalle", "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' ); 
		incentivosObjetivosController::createDetalleAction();
		incentivosObjetivosController::deleteDetalleAction();
		$id_objetivo = intval(isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
		$objetivo = incentivosObjetivosController::getItemAction($id_objetivo);
		$elements = incentivosObjetivosController::getListDetalleAction(35, " AND id_objetivo=".$id_objetivo." ");
		$users = new users();
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="<?php echo $_REQUEST['page'].'?export=true&id='.$id_objetivo;?>"><?php e_strTranslate("Export");?></a></li>
					<li><a href="admin-incentives-targets-cargas?id=<?php echo $id_objetivo;?>">Cargar fichero</a></li>
				</ul>
				<br />

				<div class="row">
					<div class="col-md-7">
						<div class="table-responsive">
							<table class="table table-hover table-striped">
								<tr>
								<th width="40px"></th>
								<th><?php e_strTranslate("Incentives_product");?></th>
								<th>Destinatario</th>
								<th><center><?php e_strTranslate("Incentives_targets_value");?></center></th>
								</tr>
								<?php foreach($elements['items'] as $element):?>
									<tr>
									<td nowrap="nowrap">
										<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Delete");?>"
											onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-incentives-targets-detail?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$id_objetivo;?>&det=<?php echo $element['id_detalle'];?>', '<?php e_strTranslate("Are_you_sure");?>', '<?php e_strTranslate("Cancel_text");?>', '<?php e_strTranslate("Confirm_text");?>'); return false"><i class="fa fa-trash icon-table"></i>
										</button>
									</td>
									<td>
										<?php echo $element['referencia_producto'];?><br />
										<small><em class="text-muted"><?php echo $element['nombre_producto'];?> - <?php echo $element['nombre_fabricante'];?></em></small>
									</td>
									<td>
										<?php 
										echo $element['destino_objetivo'];
										//obtener datos del destinatario dependiendo si es usuario o tienda
										if ($objetivo['tipo_objetivo'] == 'Tienda'){
											$destinatario = $users->getTiendas(" AND cod_tienda='".$element['destino_objetivo']."' ");
											if (count($destinatario) > 0){
												echo '<br /><small class="text-muted">'.$destinatario[0]['nombre_tienda'].'<em></em></small>';
											}
										}
										else{
											$destinatario = $users->getUsers(" AND username='".$element['destino_objetivo']."' ");
											if (count($destinatario) > 0){
												echo '<br /><small class="text-muted">'.$destinatario[0]['surname'].' - '.$destinatario[0]['name'].'<em></em></small>';
											}
										}
										?>
									</td>
									<td><center><?php echo $element['valor_objetivo'];?></center></td>
									</tr>
								<?php endforeach; ?>
							</table>
						</div>
						<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
					</div>
					<div class="col-md-5">
						<div class="panel panel-default">
							<div class="panel-heading"><h4><?php e_strTranslate("Incentives_targets_new");?></h4></div>
							<div class="panel-body">
								<form role="form" action="" method="post" name="formData" id="formData">
									<input type="hidden" name="id_objetivo" value="<?php echo $id_objetivo;?>" />
									<div class="form-group">
										<label for="valor_objetivo"><?php e_strTranslate("Incentives_targets_value");?></label>
										<input type="text" class="form-control" name="valor_objetivo" id="valor_objetivo" data-alert="<?php e_strTranslate("Required_field");?>" />
									</div>

									<div class="form-group">
										<label for="id_producto"><?php e_strTranslate("Incentives_product");?></label>
										<select name="id_producto" id="id_producto" class="form-control">
										<?php 
										$incentivos = new incentivos();
										$productos = $incentivos->getIncentivesProductos(" AND activo_producto=1 ORDER BY nombre_fabricante, nombre_producto ");
										foreach($productos as $producto):
											echo '<option value="'.$producto['id_producto'].'">'.$producto['nombre_fabricante'].' - '.$producto['nombre_producto'].'</option>';
										endforeach;
										?>
										</select>
									</div>

									<div class="form-group">
										<label>Destinatario del objetivo</label>
										<select name="destino_objetivo" id="destino_objetivo" class="form-control">
											<option value="">---Todos los usuarios---</option>
										<?php
											if ($objetivo['tipo_objetivo']=='Tienda'){
												$tiendas = $users->getTiendas(" AND activa=1 ");
												foreach($tiendas as $tienda):
													echo '<option value="'.$tienda['cod_tienda'].'">'.$tienda['nombre_tienda'].'</option>';
												endforeach;
											}
											else{
												$usuarios = $users->getUsers(" AND disabled=0 ");
												foreach($usuarios as $usuario):
													echo '<option value="'.$usuario['username'].'">'.$usuario['name'].', '.$usuario['surname'].'</option>';
												endforeach;
											}
										?>
										</select>
									</div>
									<button type="submit" class="btn btn-primary"><?php e_strTranslate("Save_data");?></button>
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