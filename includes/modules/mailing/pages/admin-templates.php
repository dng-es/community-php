<?php
//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

session::getFlashMessage( 'actions_message' ); 
mailingTemplatesController::deleteAction();
mailingTemplatesController::updateEstadoAction();
$elements = mailingTemplatesController::getListAction(20);

	?>
	<div class="row row-top">
	  	<div class="col-md-9"> 
	  		<h1>Plantillas de comunicaciones</h1>
  			<nav class="navbar navbar-default" role="navigation">
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		            <ul class="nav navbar-nav">       
		              <li><a href="?page=admin-template&act=new">Nueva plantilla</a></li>
		            </ul>
  				</div>
        	</nav>
        	<p>Total <b><?php echo $elements['total_reg'];?></b> registros</p>
			<table class="table">
				<tr>
					<th width="40px">&nbsp;</th>
					<th>Nombre de la plantilla</th>
					<th>Tipo</th>
					<th>Campaña</th>
					<th>Activo</th>
				</tr>
				<?php foreach($elements['items'] as $element): 
					$new_act = ($element['activo']==1 ? 0 : 1);
				?>
					<tr>
					<td nowrap="nowrap">
						<a class="fa fa-edit icon-table" title="Ver/editar"
							onClick="location.href='?page=admin-template&id=<?php echo $element['id_template'];?>'; return false;">
						</a>

						<a class="fa fa-ban icon-table" title="Eliminar"
							onClick="Confirma('¿Seguro que deseas eliminar la plantilla?', '?page=admin-templates&pag=<?php echo $elements['pag'];?>&act=del&id=<?php echo $element['id_template'];?>'); return false;">
						</a>
					</td>			
					<td><?php echo $element['template_name'];?></td>
					<td><?php echo $element['tipo'];?></td>
					<td><?php echo $element['campana'];?></td>
					<td>
						<a href="#" onClick="Confirma('¿Seguro que deseas cambiar el estado de la plantilla?', '?page=admin-templates&pag=<?php echo $elements['pag'];?>&act=dela&a=<?php echo $new_act;?>&id=<?php echo $element['id_template'];?>'); return false;" >
							<span class="label<?php echo ($element['activo']==0 ? " label-danger" : " label-success");?>"><?php echo $element['activo'];?></span>
						</a>
					</td>
					</tr>
				<?php endforeach;?>
			</table>
			<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
		</div>
		<?php menu::adminMenu();?>
	</div>