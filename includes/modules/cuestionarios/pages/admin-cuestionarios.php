<?php
//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);
?>

<div class="row row-top">
	<div class="col-md-9">
		<h1><?php echo strTranslate("Forms_list");?></h1>
		<?php
		session::getFlashMessage( 'actions_message' ); 
		cuestionariosController::deleteAction();
		$elements = cuestionariosController::getListAction(5, " AND activo=1 ");
		?>
		<ul class="nav nav-pills navbar-default">      
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
			<li><a href="?page=admin-cuestionario"><?php echo strTranslate("New_form");?></a></li>
		</ul>
		
		<table class="table">
		<tr>
		<th width="40px">&nbsp;</th>
		<th><?php echo strTranslate("Name");?></th>
		<th><?php echo strTranslate("Description");?></th>
		</tr>		
		<?php foreach($elements['items'] as $element): ?>
			<tr>
			<td nowrap="nowrap">
				<span class="fa fa-edit icon-table" title="<?php echo strTranslate("Edit");?>"
					onClick="location.href='?page=admin-cuestionario&id=<?php echo $element['id_cuestionario'];?>'">
				</span>
				<span class="fa fa-check icon-table" title="<?php echo strTranslate("Reviews");?>"
					onClick="location.href='?page=admin-cuestionario-revs&id=<?php echo $element['id_cuestionario'];?>'">
				</span>

				<span class="fa fa-ban icon-table" title="<?php echo strTranslate("Delete");?>"
					onClick="Confirma('<?php echo strTranslate("Are_you_sure_to_delete");?>', '?page=admin-cuestionarios&act=del&id=<?php echo $element['id_cuestionario'];?>')">
				</span>
				<a title="<?php echo strTranslate("Show");?>" target="_blank" href="?page=cuestionario&id=<?php echo $element['id_cuestionario'];?>">
					<i class="fa fa-share icon-table"></i>
				</a>
			</td>						
			<td><?php echo $element['nombre'];?></td>
			<td><?php echo $element['descripcion'];?></td>
			</tr>
		<?php endforeach; ?>
		</table>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>