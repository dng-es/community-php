<?php
//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);

//EXPORT EXCEL - SHOW AND GENERATE
usersPuntuacionesController::exportListAction();

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

$elements = usersPuntuacionesController::getListAction(100);

?>
<div class="row row-top">
	<div class="col-md-9">	
		<h1>Informe de puntuaciones</h1>
		<nav class="navbar navbar-default" role="navigation">
		  	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">       
					<li><a href="?page=informe-participaciones">Informe de participaciones</a></li>
					<li><a href="?page=informe-accesos">Informe de accesos</a></li>
					<li><a href="?page=<?php echo $_REQUEST['page'].'&export=true';?>">Exportar CSV</a></li>
				</ul>
		  	</div>
		</nav>

		<p>Total <b><?php echo $elements['total_reg'];?></b> registros</p>
		<table class="table">
			<tr>
			<th>Usuario</th>
			<th>Nick</th>
			<th>Puntos</th>
			<th>Puntos motivo</th>
			<th>Fecha</th>
			</tr>
			<?php foreach($elements['items'] as $element): ?>
				<tr>
				<td>&nbsp;<?php echo $element['puntuacion_username'];?></td>
				<td><?php echo $element['nick'];?></td>
				<td><?php echo $element['puntuacion_puntos'];?></td>
				<td><?php echo $element['puntuacion_motivo'];?></td>
				<td><?php echo strftime(DATE_TIME_FORMAT,strtotime($element['puntuacion_date']));?></td>
				</tr>
			<?php endforeach; ?>
		</table>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>