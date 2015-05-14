<?php
incentivosObjetivosController::exportDetailAction();

addJavascripts(	array("js/bootstrap-datepicker.js", 
			"js/bootstrap-datepicker.es.js", 
			"js/jquery.numeric.js", 
			getAsset("incentivos")."js/admin-incentives-targets-detail.js"));


$id_objetivo = (isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
session::getFlashMessage( 'actions_message' ); 
incentivosObjetivosController::createDetalleAction();
incentivosObjetivosController::deleteDetalleAction();
$objetivo = incentivosObjetivosController::getItemAction($id_objetivo);
$elements = incentivosObjetivosController::getListDetalleAction(35, " AND id_objetivo=".$id_objetivo." ");
$users = new users();
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
		?>
		<ul class="nav nav-pills navbar-default">       
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
			<li><a href="<?php echo $_REQUEST['page'].'?export=true&id='.$id_objetivo;?>"><?php echo strTranslate("Export");?></a></li>
			<li><a href="admin-incentives-targets-cargas?id=<?php echo $id_objetivo;?>">Cargar fichero</a></li>
		</ul>
		<br />

		<div class="row">
			<div class="col-md-7">
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
						<th width="40px"></th>
						<th><?php echo strTranslate("Incentives_product");?></th>
						<th>Destinatario</th>
						<th><center><?php echo strTranslate("Incentives_targets_value");?></center></th>
						</tr>	
						<?php foreach($elements['items'] as $element):?>
							<tr>
							<td nowrap="nowrap">
								<span class="fa fa-ban icon-table" title="Eliminar"
									onClick="Confirma('<?php echo strTranslate("Are_you_sure_to_delete");?>', 'admin-incentives-targets-detail?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$id_objetivo;?>&det=<?php echo $element['id_detalle'];?>', '<?php echo strTranslate("Are_you_sure");?>', '<?php echo strTranslate("Cancel_text");?>', '<?php echo strTranslate("Confirm_text");?>')">
								</span>
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
									if (count($destinatario)>0){
										echo '<br /><small class="text-muted">'.$destinatario[0]['nombre_tienda'].'<em></em></small>';
									}
								}
								else{
									$destinatario = $users->getUsers(" AND username='".$element['destino_objetivo']."' ");
									if (count($destinatario)>0){
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
			</div>
			<div class="col-md-5">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo strTranslate("Incentives_targets_new");?></div>
					<div class="panel-body">
						<form role="form" action="" method="post" name="formData" id="formData">
							<input type="hidden" name="id_objetivo" value="<?php echo $id_objetivo;?>" />
							<div class="form-group">
								<label for="valor_objetivo"><?php echo strTranslate("Incentives_targets_value");?></label>
								<input type="text" class="form-control" name="valor_objetivo" id="valor_objetivo" data-alert="<?php echo strTranslate("Required_field");?>" />
							</div>

							<div class="form-group">
								<label for="id_producto"><?php echo strTranslate("Incentives_product");?></label>
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