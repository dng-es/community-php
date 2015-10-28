<?php
$fotos = new fotos(); 
$users = new users();

	//VALIDAR COMENTARIOS
if (isset($_REQUEST['act'])){
	if ($_REQUEST['act'] == 'foto_ko'){
		$fotos->cambiarEstadoComentario($_REQUEST['id'], 2);
	}
	header("Location: admin-fotos-comentarios?id=".$_REQUEST['idt']."&ida=".$_REQUEST['ida']);
}

$id_file = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$pendientes = $fotos->getComentariosFoto(" AND c.estado=1 AND c.id_file=".$id_file." ORDER BY id_comentario DESC"); ?>

<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Photos"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Comments_in_photos"), "ItemClass"=>"active"),
		)); ?>

		<?php if (count($pendientes) == 0):?>
			<div class="alert alert-warning">No hay comentarios en la foto</div>
		<?php else: ?>
		<a href="admin-albumes-new?act=edit&id='.$_REQUEST['ida'].'">Volver al album</a>
		
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
					<th width="40px">&nbsp;</th>
					<th>ID</th>
					<th><?php e_strTranslate("Comment");?></th>
					<th><?php e_strTranslate("Author");?></th>
					<th><?php e_strTranslate("Date");?></th>
				</tr>

				<?php foreach($pendientes as $element):
					echo '<tr>';
					echo '<td nowrap="nowrap">					
							<span class="fa fa-ban icon-table" title="Eliminar"
							    onClick="Confirma(\'¿Seguro que deseas eliminar el comentario '.$element['id_comentario'].'?\',
								\'admin-fotos-comentarios?act=foto_ko&id='.$element['id_comentario'].'&ida='.$_REQUEST['ida'].'&idt='.$id_file.'&u='.$element['user_comentario'].'\')">
							</span>			
						 </td>'; ?>					
					<td><?php echo $element['id_comentario'];?></td>
					<td><em class="legend"><?php echo $element['comentario'];?></em></td>
					<td><?php echo $element['user_comentario'];?></td>
					<td><?php echo getDateFormat($element['date_comentario'], "SHORT");?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
		<?php endif;?>
	</div>
	<?php menu::adminMenu();?>
</div>