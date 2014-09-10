<?php
//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

session::getFlashMessage( 'actions_message' ); 
campaignsController::deleteTypeAction();
$elements = campaignsController::getListTypesAction(20);
?>
<div class="row row-top">
  	<div class="col-md-9"> 
  		<h1>Campañas</h1>
			<nav class="navbar navbar-default" role="navigation">
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	            <ul class="nav navbar-nav">       
	              <li><a href="?page=admin-campaigns-type&act=new">Nuevo tipo</a></li>
	            </ul>
				</div>
    	</nav>
    	<p>Total <b><?php echo $elements['total_reg'];?></b> registros</p>
		<table class="table">
			<tr>
				<th width="40px">&nbsp;</th>
				<th>Nombre</th>
				<th>Descripcion</th>
			</tr>
			<?php foreach($elements['items'] as $element): ?>
				<tr>
				<td nowrap="nowrap">
					<a class="fa fa-edit icon-table" title="Ver/editar"
						onClick="location.href='?page=admin-campaigns-type&id=<?php echo $element['id_campaign_type'];?>'; return false;">
					</a>

					<a class="fa fa-ban icon-table" title="Eliminar"
						onClick="Confirma('¿Seguro que deseas eliminar el tipo?', '?page=admin-campaigns-types&pag=<?php echo $elements['pag'];?>&act=del&id=<?php echo $element['id_campaign_type'];?>'); return false;">
					</a>
				</td>			
				<td><?php echo $element['campaign_type_name'];?></td>
				<td><?php echo $element['campaign_type_desc'];?></td>
				</tr>
			<?php endforeach;?>
		</table>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>