<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Photos"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Comments_in_photos"), "ItemClass"=>"active"),
		)); 

		session::getFlashMessage('actions_message');
		fotosController::validateCommentAction();
		$id_file = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
		$elements = fotosController::getListCommentsAction(20, " AND c.estado=1 AND c.id_file=".$id_file." ORDER BY id_comentario DESC");?>

		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-albumes-new?act=edit&id=<?php echo $_REQUEST['ida'];?>">Volver al album</a></li>
				</ul>		
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="40px">&nbsp;</th>
							<th>ID</th>
							<th><?php e_strTranslate("Comment");?></th>
							<th><?php e_strTranslate("Author");?></th>
							<th><?php e_strTranslate("Date");?></th>
						</tr>
						<?php foreach($elements['items'] as $element):?>
						<tr>
							<td nowrap="nowrap">
								<span class="fa fa-ban icon-table" title="Eliminar" onClick="Confirma('¿Seguro que deseas eliminar el comentario <?php echo $element['id_comentario'];?>?', 'admin-fotos-comentarios?act=foto_ko&id=<?php echo $element['id_comentario'];?>&ida=<?php echo $_REQUEST['ida'];?>&idt=<?php echo $id_file;?>&u=<?php echo $element['user_comentario'];?>')">
								</span>
							</td>
							<td><?php echo $element['id_comentario'];?></td>
							<td><em class="legend"><?php echo $element['comentario'];?></em></td>
							<td><?php echo $element['user_comentario'];?></td>
							<td><?php echo getDateFormat($element['date_comentario'], "SHORT");?></td>
						</tr>
						<?php endforeach;?>
					</table>
				</div>
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>