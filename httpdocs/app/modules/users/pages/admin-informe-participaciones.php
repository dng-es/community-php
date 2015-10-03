<?php
//EXPORT CSV
usersParticipacionesController::exportListAction();

$elements = usersParticipacionesController::getListAction(100);
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Reports"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Report")." <b>".strTranslate("APP_shares")."</b>", "ItemClass"=>"active"),
		));
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">     
					<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>  
					<li><a href="admin-informe-puntuaciones"><?php echo strTranslate("Report");?> <?php echo strTranslate("APP_points");?></a></li>
					<li><a href="admin-informe-accesos"><?php echo strTranslate("Report");?> <?php echo strtolower(strTranslate("Visits"));?></a></li>
					<li><a href="<?php echo $_REQUEST['page'].'?export=true';?>"><?php echo strTranslate("Export");?></a></li>
				</ul>
				<div class="table-responsive">
					<table class="table">
						<tr>
						<th>Usuario</th>
						<th>Nick</th>
						<th>Participacion</th>
						<th>Fecha</th>
						</tr>	
						<?php foreach($elements['items'] as $element): ?>
							<tr>
							<td>&nbsp;<?php echo $element['participacion_username'];?></td>
							<td><?php echo $element['nick'];?></td>
							<td><?php echo $element['participacion_motivo'];?></td>
							<td><?php echo getDateFormat($element['participacion_date'], "DATE_TIME");?></td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>