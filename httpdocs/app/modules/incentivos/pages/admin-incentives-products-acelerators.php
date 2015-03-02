<?php
addJavascripts(	array("js/bootstrap-datepicker.js", 
			"js/bootstrap-datepicker.es.js", 
			"js/jquery.numeric.js", 
			getAsset("incentivos")."js/admin-incentives-products-acelerators.js"));

$referencia_acelerador = (isset($_REQUEST['ref']) ? $_REQUEST['ref'] : 0);

session::getFlashMessage( 'actions_message' ); 
incentivosProductosController::createAceleratorsAction();
incentivosProductosController::deleteAceleratorsAction();
$elements = incentivosProductosController::getListAceleratorsAction(35, " AND referencia_acelerador='".$referencia_acelerador."' ");
?>

<div class="row row-top">
	<div class="col-md-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"#"),
			array("ItemLabel"=>"Productos", "ItemUrl"=>"admin-incentives-products"),
			array("ItemLabel"=>"Aceleradores", "ItemClass"=>"active"),
		));
		?>
		<div class="row">
			<div class="col-md-7">
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
						<th width="40px"></th>
						<th>Valor</th>
						<th>Fecha inicio</th>
						<th>Fecha fin</th>
						</tr>	
						<?php foreach($elements['items'] as $element):?>
							<tr>
							<td nowrap="nowrap">
								<span class="fa fa-ban icon-table" title="Eliminar"
									onClick="Confirma('¿Seguro que desea eliminar el acelerador?', 'admin-incentives-products-acelerators?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['id_acelerador'];?>&ref=<?php echo $element['referencia_acelerador'];?>')">
								</span>
							</td>					
							<td><?php echo $element['valor_acelerador'];?></td>
							<td><?php echo getDateFormat( $element['date_ini'], 'SHORT');?></td>
							<td><?php echo getDateFormat( $element['date_fin'], 'SHORT');?></td>
							</tr>  
						<?php endforeach; ?>
					</table>
				</div>
			</div>
			<div class="col-md-5">
				<div class="panel panel-default">
					<div class="panel-heading">Nuevo acelerador</div>
					<div class="panel-body">
						<form role="form" action="" method="post" name="formData" id="formData">
							<input type="hidden" name="referencia_acelerador" value="<?php echo $referencia_acelerador;?>" />
							<label for="valor_acelerador">Valor del acelerador</label>
							<input type="text" class="form-control" name="valor_acelerador" id="valor_acelerador" data-alert="<?php echo strTranslate("Required_field");?>" />
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
							<button type="submit" class="btn btn-primary">Crear acelerador</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>