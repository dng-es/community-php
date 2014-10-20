<?php
//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);

//EXPORT CSV
usersParticipacionesController::exportListAction();

$elements = usersParticipacionesController::getListAction(100);
?>
<div class="row row-top">
	<div class="col-md-9">
		<h1>Informe de participaciones</h1>
		<ul class="nav nav-pills navbar-default">     
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>  
			<li><a href="?page=informe-puntuaciones">Informe de puntuaciones</a></li>
			<li><a href="?page=informe-accesos">Informe de accesos</a></li>
			<li><a href="?page=<?php echo $_REQUEST['page'].'&export=true';?>">Exportar CSV</a></li>
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
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>