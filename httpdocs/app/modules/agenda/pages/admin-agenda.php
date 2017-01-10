<?php
session::getFlashMessage( 'actions_message' );
agendaController::exportAction();
agendaController::deleteAgendaAction();
$elements = agendaController::getListAction(10, " ORDER BY id_agenda DESC");?>
<div class="row row-top">
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Diary_and_offers"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Posts_list"), "ItemClass"=>"active"),
		));?>


		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-agenda-new"><?php e_strTranslate("New_diary_and_offers");?></a></li>
					<li><a href="<?php echo $_REQUEST['page'];?>?export=true"><?php e_strTranslate("Export");?></a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'], "admin-agenda", "searchForm", strTranslate("Search"), strTranslate("Search"), "", "navbar-form navbar-left");?>
					</div>
				</ul>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
					<tr>
					<th width="40px"></th>
					<th><?php e_strTranslate("Title");?></th>
					<th>Sección</th>
					<th>Fecha inicio</th>
					<th>Fecha fin</th>
					<th><?php e_strTranslate("Channel");?></th>
					<th class="text-center"><?php e_strTranslate("Active");?></th>
					</tr>
					<?php foreach($elements['items'] as $element):?>
						<tr>
							<td nowrap="nowrap">
								<button type="button" class="btn btn-default btn-xs" title="Eliminar"
									onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-agenda?pag=<?php echo $elements['pag'];?>&act=del&id=<?php echo $element['id_agenda'];?>'); return false;"><i class="fa fa-trash icon-table"></i>
								</button>

								<button type="button" class="btn btn-default btn-xs" title="Ver/editar entrada" onClick="location.href='admin-agenda-new?id=<?php echo $element['id_agenda'];?>'; return false"><i class="fa fa-edit icon-table"></i>
								</button>
							</td>
						<?php
						echo '<td>'.$element['titulo'].'<br />';
						echo '<em class="legend">'.getDateFormat($element['date_add'], "LONG").'</em><br />';
						echo $element['user_add'].'</td>';
						echo '<td>'.$element['tipo_name'].'</td>';
						if (!(is_null($element['date_ini']))){$date_ini = date('d/m/Y',strtotime($element['date_ini']));}else{$date_ini ='';}
						if (!(is_null($element['date_fin']))){$date_fin = date('d/m/Y',strtotime($element['date_fin']));}else{$date_fin ='';}
						echo '<td>'.ucfirst($date_ini).'</td>';
						echo '<td>'.ucfirst($date_fin ).'</td>';
						echo '<td>'.ucfirst($element['canal']).'</td>';?>
						<td class="text-center"><span class="label<?php echo ($element['activo'] == 0 ? " label-danger" : " label-success");?>"><?php echo ($element['activo'] == 1 ? strTranslate("App_Yes") : strTranslate("App_No"));?></span></td>
						</tr>
					<?php endforeach;?>
					</table>
				</div>
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], 'admin-agenda', 'Entradas', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>