<?php
addJavascripts(	array("js/bootstrap-datepicker.js", 
			"js/bootstrap-datepicker.es.js", 
			"js/jquery.numeric.js", 
			getAsset("incentivos")."js/admin-incentives-products-points.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"admin-incentives-products"),
			array("ItemLabel"=>strTranslate("Incentives_products"), "ItemUrl"=>"admin-incentives-products"),
			array("ItemLabel"=>strTranslate("Incentives_points"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		incentivosProductosController::createPuntosAction();
		incentivosProductosController::deletePuntosAction();
		$id_producto = intval(isset($_REQUEST['ref']) ? $_REQUEST['ref'] : 0);
		$elements = incentivosProductosController::getListPuntosAction(9999, " AND id_producto=".$id_producto." ");
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
				</ul>
				<div class="row">
					<div class="col-md-7">
						<div class="table-responsive">
							<table class="table table-hover table-striped">
								<tr>
								<th width="40px"></th>
								<th><?php e_strTranslate("Date_start");?></th>
								<th><?php e_strTranslate("Date_end");?></th>
								<th><?php e_strTranslate("Channel");?></th>
								<th><center><?php e_strTranslate("Incentives_points");?></center></th>
								</tr>
								<?php foreach($elements['items'] as $element):?>
									<tr>
									<td nowrap="nowrap">
										<span class="fa fa-ban icon-table" title="Eliminar"
											onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-incentives-products-points?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['id_puntos'];?>&ref=<?php echo $element['id_producto'];?>', '<?php e_strTranslate("Are_you_sure");?>', '<?php e_strTranslate("Cancel_text");?>', '<?php e_strTranslate("Confirm_text");?>')">
										</span>
									</td>
									<td><?php echo getDateFormat( $element['date_ini'], 'SHORT');?></td>
									<td><?php echo getDateFormat( $element['date_fin'], 'SHORT');?></td>
									<td><?php echo $element['canal_puntos'];?></td>
									<td><center><?php echo $element['puntos'];?></center></td>
									</tr>
								<?php endforeach;?>
							</table>
						</div>
					</div>
					<div class="col-md-5">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4>Nueva puntuación</h4>
							</div>
							<div class="panel-body">
								<form role="form" action="" method="post" name="formData" id="formData">
									<input type="hidden" name="id_producto" value="<?php echo $id_producto;?>" />
									<div class="form-group col-md-12">
										<label for="puntos"><?php e_strTranslate("Incentives_points");?></label>
										<input type="text" class="form-control" name="puntos" id="puntos" data-alert="<?php e_strTranslate("Required_field");?>" />
									</div>

									<div class="form-group col-md-12">
										<label class="control-label" for="canal_puntos"><?php e_strTranslate("Channel");?></label>
										<select name="canal_puntos[]" id="canal_puntos" class="selectpicker show-menu-arrow show-tick" data-container="body" data-style="btn-default" data-width="100%" multiple data-actions-box="true" data-none-selected-text="<?php e_strTranslate("Choose_channel");?>" data-deselect-all-text="<?php e_strTranslate('deselect_all');?>"  data-select-all-text="<?php e_strTranslate('select_all');?>">
											<?php ComboCanales("");?>
										</select>
									</div>

									<div class="form-group col-md-6">
										<label class=" control-label" for="date_ini"><?php e_strTranslate("Date_start");?></label>
										<div id="datetimepicker1" class="input-group date">
											<input data-format="yyyy/MM/dd" readonly type="text" id="date_ini" class="form-control" name="date_ini" data-alert="<?php e_strTranslate("Required_date");?>"></input>
											<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
										</div>
									</div>

									<div class="form-group col-md-6">
										<label class=" control-label" for="date_fin"><?php e_strTranslate("Date_end");?></label>
										<div id="datetimepicker2" class="input-group date">
											<input data-format="yyyy/MM/dd" readonly type="text" id="date_fin" class="form-control" name="date_fin" data-alert="<?php e_strTranslate("Required_date");?>"></input>
											<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
										</div>
									</div>

									<div class="form-group col-md-12">
										<button type="submit" class="btn btn-primary btn-block btn-lg"><?php e_strTranslate("Save_data");?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>