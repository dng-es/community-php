<?php
addJavascripts(	array("js/bootstrap-datepicker.js", 
			"js/bootstrap-datepicker.es.js", 
			"js/jquery.numeric.js", 
			getAsset("incentivos")."js/admin-incentives-products-acelerators.js"));

$id_producto = (isset($_REQUEST['ref']) ? $_REQUEST['ref'] : 0);

session::getFlashMessage( 'actions_message' ); 
incentivosProductosController::createAceleratorsAction();
incentivosProductosController::deleteAceleratorsAction();
$elements = incentivosProductosController::getListAceleratorsAction(9999, " AND a.id_producto=".$id_producto." ");

?>

<div class="row row-top">
	<div class="col-md-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"admin-incentives"),
			array("ItemLabel"=>strTranslate("Incentives_products"), "ItemUrl"=>"admin-incentives-products"),
			array("ItemLabel"=>strTranslate("Incentives_acelerators"), "ItemClass"=>"active"),
		));
		?>
		<ul class="nav nav-pills navbar-default">       
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
		</ul>
		<br />
		<div class="row">
			<div class="col-md-7">
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
						<th width="40px"></th>
						<th><?php echo strTranslate("Date_start");?></th>
						<th><?php echo strTranslate("Date_end");?></th>
						<th><center><?php echo strTranslate("Incentives_acelerators_value");?></center></th>
						</tr>	
						<?php foreach($elements['items'] as $element):?>
							<tr>
							<td nowrap="nowrap">
								<span class="fa fa-ban icon-table" title="Eliminar"
									onClick="Confirma('<?php echo strTranslate("Are_you_sure_to_delete");?>', 'admin-incentives-products-acelerators?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['id_acelerador'];?>&ref=<?php echo $element['id_producto'];?>', '<?php echo strTranslate("Are_you_sure");?>', '<?php echo strTranslate("Cancel_text");?>', '<?php echo strTranslate("Confirm_text");?>')">
								</span>
							</td>					
							<td><?php echo getDateFormat( $element['date_ini'], 'SHORT');?></td>
							<td><?php echo getDateFormat( $element['date_fin'], 'SHORT');?></td>
							<td><center><?php echo $element['valor_acelerador'];?></center></td>
							</tr>  
						<?php endforeach; ?>
					</table>
				</div>
			</div>
			<div class="col-md-5">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo strTranslate("Incentives_acelerators_new");?></div>
					<div class="panel-body">
						<form role="form" action="" method="post" name="formData" id="formData">
							<input type="hidden" name="id_producto" value="<?php echo $id_producto;?>" />
							<div class="form-group">
								<label for="valor_acelerador"><?php echo strTranslate("Incentives_acelerators_value");?></label>
								<input type="text" class="form-control" name="valor_acelerador" id="valor_acelerador" data-alert="<?php echo strTranslate("Required_field");?>" />
							</div>

							<div class="form-group">
								<label class=" control-label" for="date_ini"><?php echo strTranslate("Date_start");?></label>
								<div id="datetimepicker1" class="input-group date">
									<input data-format="yyyy/MM/dd" readonly type="text" id="date_ini" class="form-control" name="date_ini" data-alert="<?php echo strTranslate("Required_date");?>"></input>
									<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>
							</div>

							<div class="form-group">
								<label class=" control-label" for="date_fin"><?php echo strTranslate("Date_end");?></label>
								<div id="datetimepicker2" class="input-group date">
									<input data-format="yyyy/MM/dd" readonly type="text" id="date_fin" class="form-control" name="date_fin" data-alert="<?php echo strTranslate("Required_date");?>"></input>
									<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>							
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