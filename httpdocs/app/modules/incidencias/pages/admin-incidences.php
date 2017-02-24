<?php
//EXPORT INCIDENCIAS
set_time_limit(0);
ini_set('memory_limit', '-1');
incidenciasController::exportListAction("");

templateload("paginator", "incidencias");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Incidences"), "ItemUrl"=>"admin-incidences"),
			array("ItemLabel"=>strTranslate("Incidences_list"), "ItemClass"=>"active"),
		));
		session::getFlashMessage( 'actions_message' );
		$elements = incidenciasController::getListAction(20);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">       
					<li><a href="admin-incidences" class="text-muted"><small>Todas <span class="badge"><?php echo $elements['totales'];?></span></small></a></li>
					<li><a href="admin-incidences?f2=0" class="text-info"><small><?php echo (isset($_REQUEST['f2']) && $_REQUEST['f2'] == 0 ? '<b>' : '');?>Pendientes<?php echo (isset($_REQUEST['f2']) && $_REQUEST['f2'] == 0 ? '</b>' : '');?> <span class="badge"><?php echo $elements['pendientes'];?></span></small></a></li>
					<li><a href="admin-incidences?f2=1" class="text-success"><small><?php echo (isset($_REQUEST['f2']) && $_REQUEST['f2'] == 1 ? '<b>' : '');?>Finalizadas<?php echo (isset($_REQUEST['f2']) && $_REQUEST['f2'] == 1 ? '</b>' : '');?> <span class="badge"><?php echo $elements['finalizadas'];?></span></small></a></li>
					<li><a href="admin-incidences?f2=2" class="text-danger"><small><?php echo (isset($_REQUEST['f2']) && $_REQUEST['f2'] == 2 ? '<b>' : '');?>Canceladas<?php echo (isset($_REQUEST['f2']) && $_REQUEST['f2'] == 2 ? '</b>' : '');?> <span class="badge"><?php echo $elements['canceladas'];?></span></small></a></li>
					<li><a href="<?php echo $_REQUEST['page'].'?export=true';?>"><?php e_strTranslate("Export");?></a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'],"admin-incidences","searchForm",strTranslate("Search"), strTranslate("Search"),"","navbar-form navbar-left");?>	
					</div>
					<li class="disabled pull-right"><a href="#"><small><?php e_strTranslate("Total");?> coincidencias <span class="badge"><?php echo $elements['total_reg'];?></span></small></a></li>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th><?php e_strTranslate("Incidence_code");?></th>
							<th><?php e_strTranslate("Incidence");?></th>
							<th class="text-center"><?php e_strTranslate("Type");?></th>
							<th width="40px"></th>
						</tr>	
						<?php foreach($elements['items'] as $element):?>
						<tr>
							<td><a href="admin-incidence?id=<?php echo $element['id_incidencia'];?>"><?php echo sprintf("%04d", $element['id_incidencia']);?></a>
							</td>
							<td>
								<a href="admin-users?f=<?php echo $element['username_incidencia'];?>"><?php echo $element['username_incidencia'];?></a> - <small><?php echo $element['name'];?> <?php echo $element['surname'];?> - <b class="text-danger">Fecha apertura:</b> <?php echo getDateFormat($element['date_incidencia'], 'DATE_TIME');?></small><br />
								<?php echo nl2br($element['texto_incidencia']);?>
							</td>
							<td class="text-nowrap warning text-center"><?php echo $element['categoria_incidencia'];?></td>
							<td class="<?php echo ($element['estado_incidencia'] == 0 ? "info" : ($element['estado_incidencia'] == 1 ? "success" : "danger"));?>">
								&nbsp;
							</td>
						</tr>
						<?php endforeach; ?>
						<?php if ($elements['total_reg'] == 0): ?>
							<tr><td colspan="5"><p class="text-center text-danger"><em>No hay registros.</em></p></td></tr>
						<?php endif; ?>
					</table>
				</div>
				<?php PaginatorIncidences($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg'], $elements['find_reg2']);?>
				<table class="table table-condensed">
					<tr>
						<td class="info">&nbsp;</td><td><small class="text-muted">Incidencia Pendiente</small></td>
						<td class="danger">&nbsp;</td><td><small class="text-muted">Incidencia Cancelada</small></td>
						<td class="success">&nbsp;</td><td><small class="text-muted">Incidencia Finalizada</small></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>