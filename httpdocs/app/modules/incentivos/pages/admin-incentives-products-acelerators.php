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
	<div class="app-main">
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
			<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
		</ul>
		<br />
		<div class="row">
			<div class="col-md-7">
				<div class="table-responsive">
					<table class="table">
						<tr>
						<th width="40px"></th>
						<th><?php e_strTranslate("Date_start");?></th>
						<th><?php e_strTranslate("Date_end");?></th>
						<th><center><?php e_strTranslate("Incentives_acelerators_value");?></center></th>
						</tr>	
						<?php foreach($elements['items'] as $element):?>
							<tr>
							<td nowrap="nowrap">
								<span class="fa fa-ban icon-table" title="Eliminar"
									onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-incentives-products-acelerators?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['id_acelerador'];?>&ref=<?php echo $element['id_producto'];?>', '<?php e_strTranslate("Are_you_sure");?>', '<?php e_strTranslate("Cancel_text");?>', '<?php e_strTranslate("Confirm_text");?>')">
								</span>
							</td>
							<td><?php echo getDateFormat( $element['date_ini'], 'SHORT');?></td>
							<td><?php echo getDateFormat( $element['date_fin'], 'SHORT');?></td>
							<td><center><?php echo $element['valor_acelerador'];?></center></td>
							</tr>
						<?php endforeach;?>
					</table>
				</div>
			</div>
			<div class="col-md-5">
				<div class="section inset">
					<h4><?php e_strTranslate("Incentives_acelerators_new");?></h4>
					<form role="form" action="" method="post" name="formData" id="formData">
						<input type="hidden" name="id_producto" value="<?php echo $id_producto;?>" />
						<div class="form-group">
							<label for="valor_acelerador"><?php e_strTranslate("Incentives_acelerators_value");?></label>
							<input type="text" class="form-control" name="valor_acelerador" id="valor_acelerador" data-alert="<?php e_strTranslate("Required_field");?>" />
						</div>

						<div class="form-group">
							<label class=" control-label" for="date_ini"><?php e_strTranslate("Date_start");?></label>
							<div id="datetimepicker1" class="input-group date">
								<input data-format="yyyy/MM/dd" readonly type="text" id="date_ini" class="form-control" name="date_ini" data-alert="<?php e_strTranslate("Required_date");?>"></input>
								<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>
						</div>

						<div class="form-group">
							<label class=" control-label" for="date_fin"><?php e_strTranslate("Date_end");?></label>
							<div id="datetimepicker2" class="input-group date">
								<input data-format="yyyy/MM/dd" readonly type="text" id="date_fin" class="form-control" name="date_fin" data-alert="<?php e_strTranslate("Required_date");?>"></input>
								<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>
						</div>
						<button type="submit" class="btn btn-primary"><?php e_strTranslate("Save_data");?></button>
					</form>
				</div>
			</div>
		</div>
		<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>