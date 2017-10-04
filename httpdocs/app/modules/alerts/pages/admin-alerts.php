<?php
alertsController::exportRegistroAction();

templateload("paginator", "alerts");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("MOD_Alerts"), "ItemUrl"=>"admin-alerts"),
			array("ItemLabel"=>strTranslate("MOD_Alert_list"), "ItemClass"=>"active"),
		));
		session::getFlashMessage( 'actions_message' );
		alertsController::deleteAction();
		$elements = alertsController::getListAction(15, " AND activa=1 ");
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<ul class="nav nav-pills navbar-default">
							<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
							<li><a href="admin-alert"><?php e_strTranslate("MOD_Alert_new");?></a></li>
							<div class="pull-right">
								<?php echo SearchForm($elements['reg'], "admin-alerts", "searchForm", strTranslate("Search"), strTranslate("Search"), "", "navbar-form navbar-left");?>
							</div>
						</ul>

						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<tr>
								<th width="40px"></th>
								<th><?php e_strTranslate("MOD_Alert");?></th>
								<th><?php e_strTranslate("Date_start");?></th>
								<th><?php e_strTranslate("Date_end");?></th>
								<th><?php e_strTranslate("Category");?></th>
								</tr>	
								<?php foreach($elements['items'] as $element):?>
									<tr>
									<td nowrap="nowrap">
										<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Delete");?>"
											onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-alerts?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=dela&id='.$element['id_alert'];?>'); return false"><i class="fa fa-trash icon-table"></i>
										</button>

										<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Edit");?>" onClick="location.href='admin-alert?ida=<?php echo $element['id_alert'];?>'; return false;"><i class="fa fa-edit icon-table"></i>
										</button>
										<?php if($element['registro'] == 1):?>
										<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Download");?>" onClick="location.href='admin-alerts?export_r=true&ida=<?php echo $element['id_alert'];?>'; return false;"><i class="fa fa-download icon-table"></i>
										</button>
										<?php endif;?>
									</td>
									<td>
										<?php echo $element['title_alert'];?>
										<p class="text-muted"><small><?php e_strTranslate("Destinatario");?>: <?php echo str_replace(",", ", ", $element['destination_alert']);?></small></p>
									</td>
									<td><?php echo getDateFormat($element['date_ini'], 'SHORT');?> <?php echo $element['time_ini'];?></td>
									<td><?php echo getDateFormat($element['date_fin'], 'SHORT');?> <?php echo $element['time_fin'];?></td>
									<td><?php echo $element['name_type'];?></td>
									</tr>
								<?php endforeach; ?>
							</table>
						</div>
						<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg'], 15, "", "pag_a");?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>