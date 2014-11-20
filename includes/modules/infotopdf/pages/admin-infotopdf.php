<?php
session::getFlashMessage( 'actions_message' ); 
infotopdfController::deleteAction();
$elements = infotopdfController::getListAction(20);
?>
<div class="row row-top">
	<div class="col-md-9 inset">
		<ol class="breadcrumb">
			<li><a href="?page=home"><?php echo strTranslate("Home");?></a></li>
			<li><a href="?page=admin"><?php echo strTranslate("Administration");?></a></li>
			<li class="active"><?php echo strTranslate("Infotopdf_Documents");?></li>
		</ol>
		<h1>Gestión de documentos PDF</h1>
		<ul class="nav nav-pills navbar-default"> 
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>      
			<li><a href="?page=admin-infotopdf-doc&act=new">Nuevo documento</a></li>
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
						  <a href="?page=admin-infotopdf-doc&act=edit&id=<?php echo $element['id_info'];?>" title="Editar documento">
						  <span class="fa fa-edit icon-table"></span></a>
						  <a href="#" onClick="Confirma('¿Seguro que desea eliminar el documento?', '?page=admin-infotopdf&pag=<?php echo $elements['pag'];?>&act=del&d=<?php echo $element['file_info'];?>&id=<?php echo $element['id_info'];?>')" 
						  title="Eliminar documento" /><span class="fa fa-ban icon-table"></span></a>
					   </td>     
					<td><a target="_blank" href="<?php echo PATH_INFO.$element['file_info'];?>"><?php echo $element['titulo_info'];?></a></td>
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