<?php
set_time_limit(0);
ini_set('memory_limit', '-1');
$filter = " AND username_incidencia='".$_SESSION['user_name']."' ";

//EXPORT INCIDENCIAS
incidenciasController::exportListAction($filter);
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("My_incidences"), "ItemClass"=>"active"),
		));

		session::getFlashMessage('actions_message');
		$elements = incidenciasController::getListAction(35, $filter);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">       
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="incidence"><?php e_strTranslate("New_incidence");?></a></li>
					<li><a href="<?php echo $_REQUEST['page'].'?export=true';?>"><?php e_strTranslate("Export");?></a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'],"admin-incidences","searchForm",strTranslate("Search"), strTranslate("Search"),"","navbar-form navbar-left");?>	
					</div>
				</ul>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
						<th><?php e_strTranslate("Incidence_code");?></th>
						<th width="100%"><?php e_strTranslate("Incidence");?></th>
						<th></th>
						</tr>	
						<?php foreach($elements['items'] as $element):?>
							<tr>
							<td><a href="incidence?id=<?php echo $element['id_incidencia'];?>"><?php echo sprintf("%04d", $element['id_incidencia']);?></a></td>
							<td>
								<small class="text-muted"><b class="text-danger">Fecha apertura:</b> <?php echo getDateFormat($element['date_incidencia'], 'DATE_TIME');?></small><br />
								<?php echo nl2br($element['texto_incidencia']);?>
							</td>
							<td class="<?php echo ($element['estado_incidencia'] == 0 ? "info" : ($element['estado_incidencia'] == 1 ? "success" : "danger"));?>">
								<span><?php echo ($element['estado_incidencia'] == 0 ? 'Pendiente' : ($element['estado_incidencia'] == 1 ? "Finalizada" : "Cancelada"));?></span>
							</td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior hidden-xs hidden-sm">
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-life-ring fa-stack-1x fa-inverse"></i>
				</span>
				<?php e_strTranslate("My_incidences");?>
			</h4>
			<p class="text-center"><i class="fa fa-life-ring fa-big"></i></p>
		</div>
	</div>
</div>