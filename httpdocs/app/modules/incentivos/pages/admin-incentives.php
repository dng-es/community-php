<?php
addJavascripts(	array("js/bootstrap-datepicker.js", 
			"js/bootstrap-datepicker.es.js", 
			"js/jquery.numeric.js", 
			getAsset("incentivos")."js/admin-incentives.js"));

$referencia_acelerador = (isset($_REQUEST['ref']) ? $_REQUEST['ref'] : 0);

session::getFlashMessage( 'actions_message' ); 
incentivosController::createAction();
incentivosController::deleteAction();
$elements = incentivosController::getListAction(35, "");
?>

<div class="row row-top">
	<div class="col-md-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Incentives_list"), "ItemClass"=>"active"),
		));
		?>
		<div class="row">
			<div class="col-md-7">
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
						<th width="40px"></th>
						<th>Producto</th>
						<th>Puntos</th>
						<th>Fecha inicio</th>
						<th>Fecha fin</th>
						</tr>	
						<?php foreach($elements['items'] as $element):?>
							<tr>
							<td nowrap="nowrap">
								<span class="fa fa-ban icon-table" title="Eliminar"
									onClick="Confirma('¿Seguro que desea eliminar el incentivo?', 'admin-incentives?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['id_incentivo'];?>')">
								</span>
							</td>					
							<td>
								<?php echo $element['referencia_incentivo'];?><br />
								<em class="text-muted"><small><?php echo $element['nombre_producto'];?> - <?php echo $element['nombre_fabricante'];?></small></em>
							</td>
							<td><?php echo $element['puntos_incentivo'];?></td>
							<td><?php echo getDateFormat( $element['date_ini'], 'SHORT');?></td>
							<td><?php echo getDateFormat( $element['date_fin'], 'SHORT');?></td>
							</tr>  
						<?php endforeach; ?>
					</table>
				</div>
			</div>
			<div class="col-md-5">
				<div class="panel panel-default">
					<div class="panel-heading">Nuevo incentivo</div>
					<div class="panel-body">
						<form role="form" action="" method="post" name="formData" id="formData">
							<label for="referencia_incentivo">Producto</label>
							<select name="referencia_incentivo" id="referencia_incentivo" class="form-control">
							<?php 
							$incentivos = new incentivos();
							$productos = $incentivos->getIncentivesProductos(" AND activo_producto=1 ORDER BY nombre_fabricante, nombre_producto ");
							foreach($productos as $producto):
								echo '<option value="'.$producto['referencia_producto'].'">'.$producto['nombre_fabricante'].' - '.$producto['nombre_producto'].'</option>';
							endforeach;
							?>
							</select>
							<label for="puntos_incentivo">Puntos</label>
							<input type="text" class="form-control" name="puntos_incentivo" id="puntos_incentivo" data-alert="<?php echo strTranslate("Required_field");?>" />
							<label class=" control-label" for="date_ini">Fecha inicio</label>
							<div id="datetimepicker1" class="input-group date">
								<input data-format="yyyy/MM/dd" readonly type="text" id="date_ini" class="form-control" name="date_ini" data-alert="<?php echo strTranslate("Required_date");?>"></input>
								<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>
							<label class=" control-label" for="date_fin">Fecha fin</label>
							<div id="datetimepicker2" class="input-group date">
								<input data-format="yyyy/MM/dd" readonly type="text" id="date_fin" class="form-control" name="date_fin" data-alert="<?php echo strTranslate("Required_date");?>"></input>
								<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>							
							<br />
							<button type="submit" class="btn btn-primary">Crear incentivo</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>