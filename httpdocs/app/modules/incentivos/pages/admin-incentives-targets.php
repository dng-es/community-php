<?php
incentivosObjetivosController::exportAction();

templateload("cmbCanales", "users");

addJavascripts(	array("js/bootstrap-datepicker.js", 
			"js/bootstrap-datepicker.es.js", 
			"js/jquery.numeric.js", 
			getAsset("incentivos")."js/admin-incentives-targets.js"));

$referencia_acelerador = (isset($_REQUEST['ref']) ? $_REQUEST['ref'] : 0);

session::getFlashMessage( 'actions_message' ); 
incentivosObjetivosController::createAction();
incentivosObjetivosController::deleteAction();
$elements = incentivosObjetivosController::getListAction(35, "");
$users = new users();
?>

<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"admin-incentives-targets"),
			array("ItemLabel"=>strTranslate("Incentives_targets"), "ItemClass"=>"active"),
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
						<th><?php echo strTranslate("Name");?></th>
						<th><?php echo strTranslate("Type");?></th>
						<th><?php echo strTranslate("Channel");?></th>
						<th width="40px"></th>
						</tr>	
						<?php foreach($elements['items'] as $element):?>
							<tr>
							<td nowrap="nowrap">
								<span class="fa fa-ban icon-table" title="Eliminar"
									onClick="Confirma('<?php echo strTranslate("Are_you_sure_to_delete");?>', 'admin-incentives-targets?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['id_objetivo'];?>&ref=<?php echo $element['referencia_acelerador'];?>', '<?php echo strTranslate("Are_you_sure");?>', '<?php echo strTranslate("Cancel_text");?>', '<?php echo strTranslate("Confirm_text");?>')">
								</span>
							</td>					
							<td>
								<small>
									<?php echo $element['nombre_objetivo'];?><br />
									<?php echo getDateFormat( $element['date_ini_objetivo'], 'SHORT');?> - <?php echo getDateFormat( $element['date_fin_objetivo'], 'SHORT');?>
								</small>
							</td>
							<td><small><?php echo $element['tipo_objetivo'];?></small></td>
							<td><small><?php echo $element['canal_objetivo'];?></small></td>
							<td><small><a href="admin-incentives-targets-detail?id=<?php echo $element['id_objetivo'];?>" class="btn btn-default btn-xs">detalle</a></small></td>
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
							<input type="hidden" name="referencia_acelerador" value="<?php echo $referencia_acelerador;?>" />
							<div class="form-group">
								<label for="nombre_objetivo"><?php echo strTranslate("Name");?></label>
								<input type="text" class="form-control" name="nombre_objetivo" id="nombre_objetivo" data-alert="<?php echo strTranslate("Required_field");?>" />
							</div>

							<div class="form-group">
								<div class="radio">
									<label>
									<input type="radio" name="tipo_objetivo" id="optionTienda" value="Tienda" checked>
									Objetivo de tienda
									</label>
								</div>
								<div class="radio">
									<label>
									<input type="radio" name="tipo_objetivo" id="optionUsuario" value="Usuario">
									Objetivo de usuario
									</label>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label" for="date_ini"><?php echo strTranslate("Date_start");?></label>
								<div id="datetimepicker1" class="input-group date">
									<input data-format="yyyy/MM/dd" readonly type="text" id="date_ini" class="form-control" name="date_ini" data-alert="<?php echo strTranslate("Required_date");?>"></input>
									<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label" for="date_fin"><?php echo strTranslate("Date_end");?></label>
								<div id="datetimepicker2" class="input-group date">
									<input data-format="yyyy/MM/dd" readonly type="text" id="date_fin" class="form-control" name="date_fin" data-alert="<?php echo strTranslate("Required_date");?>"></input>
									<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>							
							</div>

							<div class="form-group">
								<label class="control-label" for="canal_objetivo"><?php echo strTranslate("Channel");?></label>
								<select class="form-control" name="canal_objetivo" id="canal_objetivo">
									<?php ComboCanales("");?>
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