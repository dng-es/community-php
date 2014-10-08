<?php
//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);

session::getFlashMessage( 'actions_message' ); 
infoController::deleteAction();
$elements = infoController::getListAction(20);
?>
<div class="row row-top">
	<div class="col-md-9">
		<h1>Gestión de documentos</h1>
		<ul class="nav nav-pills navbar-default">
			<li class="disabled"><a href="#">Total <b><?php echo $elements['total_reg'];?></b> registros</a></li>       
			<li><a href="?page=admin-info-doc&act=new">Nuevo documento</a></li>
		</ul>
		<div class="table-responsive">
			<table class="table">
				<tr>
					<th width="50px">&nbsp;</th>
					<th>Documento</th>
					<th>Tipo</th>
					<th>Campaña</th>
				</tr>
				<?php foreach($elements['items'] as $element): ?>
				<tr>
					<td nowrap="nowrap">
						  <a href="?page=admin-info-doc&act=edit&id=<?php echo $element['id_info'];?>" title="Editar documento">
						  <span class="fa fa-edit icon-table"></span></a>
						  <a href="#" onClick="Confirma('¿Seguro que desea eliminar el documento?', '?page=admin-info&pag=<?php echo $elements['pag'];?>&act=del&d=<?php echo $element['file_info'];?>&id=<?php echo $element['id_info'];?>')" 
						  title="Eliminar documento" /><span class="fa fa-ban icon-table"></span></a>
					   </td>     
					<td><a target="_blank" href="docs/showfile.php?file=<?php echo $element['file_info'];?>"><?php echo $element['titulo_info'];?></a></td>
					<td><?php echo $element['tipo'];?></td>
					<td><?php echo $element['campana'];?></td>
				</tr>   
				<?php endforeach;  ?>
			</table>
		</div>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>