<?php
addJavascripts(array("js/bootstrap-datepicker.js", 
					"js/bootstrap-datepicker.es.js",
					getAsset("alerts")."js/addalert.js"));

templateload("addalert", "alerts");

session::getFlashMessage( 'actions_message' );
alertsController::deleteAction();
alertsController::createAction();
$elements = alertsController::getListAction(15, " AND activa=1 ");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("MOD_Alerts"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("MOD_Alerts_list"), "ItemClass"=>"active"),
		));
		?>
		<div class="row">
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-body">
						<ul class="nav nav-pills navbar-default">       
							<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
							<div class="pull-right">
								<?php echo SearchForm($elements['reg'],"admin-alerts","searchForm",strTranslate("Search"), strTranslate("Search"),"","navbar-form navbar-left");?>	
							</div>
						</ul>

						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<tr>
								<th width="40px"></th>
								<th><?php e_strTranslate("MOD_Alert");?></th>
								<th><?php e_strTranslate("Type");?></th>
								<th><?php e_strTranslate("Date_start");?></th>
								<th><?php e_strTranslate("Date_end");?></th>
								</tr>	
								<?php foreach($elements['items'] as $element):?>
									<tr>
									<td nowrap="nowrap">								
										<button type="button" class="btn btn-default btn-xs" title="Eliminar"
											onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-alerts?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['id_alert'];?>'); return false"><i class="fa fa-trash icon-table"></i>
										</button>
									</td>
									<td><?php echo $element['text_alert'];?></td>
									<td><?php echo $element['type_alert'];?></td>
									<td><?php echo getDateFormat($element['date_ini'], 'DATE_TIME');?></td>
									<td><?php echo getDateFormat($element['date_fin'], 'DATE_TIME');?></td>
									</tr>
								<?php endforeach; ?>
							</table>
						</div>
						<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
					</div>
				</div>			
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<h3 class="inset"><?php e_strTranslate("MOD_Alert_new");?></h3>
						<?php addAlert();?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php menu::adminMenu();?>
</div>