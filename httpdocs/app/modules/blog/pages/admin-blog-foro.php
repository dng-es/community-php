<?php
blogController::exportCommentsAction();
blogController::validateCommentsAction();
$pendientes = blogController::getCommentsAction();
?>
<div class="row row-top">
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Blog"), "ItemUrl"=>"admin-blog"),
			array("ItemLabel"=>"Comentarios en ".strTranslate("Blog"), "ItemClass"=>"active"),
		));?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo count($pendientes);?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-blog-new?id=<?php echo $_REQUEST['id'];?>"><?php e_strTranslate("Edit");?></a></li>
					<li><a href="admin-blog-foro?id=<?php echo $_REQUEST['id'];?>&export=true">Exportar</a></li>
					<li><a href="blog?id=<?php echo $_REQUEST['id'];?>">Ver entrada</a></li>
				</ul>
				<?php if (count($pendientes) == 0):?>
				<div class="alert alert-danger">No hay mensajes en la entrada</div>
				<?php else: ?>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="40px">&nbsp;</th>
							<th>ID</th>
							<th>Comentario</th>
						</tr>
						<?php foreach($pendientes as $element):?>
						<tr>
							<td nowrap="nowrap">
								<span class="fa fa-ban icon-table" title="Eliminar" 
									onClick="Confirma('¿Seguro que desea eliminar el comentario <?php echo $element['id_comentario'];?>?', 
									'admin-blog-foro?act=foro_ko&id=<?php echo $element['id_comentario'];?>&idt=<?php echo $element['id_tema'];?>&u=<?php echo $element['user_comentario'];?>')">
								</span>
							</td>
							<td><?php echo $element['id_comentario'];?></td>
							<td>
								<?php echo $element['comentario'];?><br />
								<em class="legend"><?php echo getDateFormat($element['date_comentario'], "LONG");?></em><br />
								<?php echo $element['user_comentario'];?>
							</td>
						</tr>
						<?php endforeach;?>
					</table>
				</div>
			</div>
		</div>
	<?php endif;?>
	</div>
	<?php menu::adminMenu();?>
</div>