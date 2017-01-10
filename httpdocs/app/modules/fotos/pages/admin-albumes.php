<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Photos"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Photo_albums"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		fotosAlbumController::deleteAction();
		fotosAlbumController::downloadAction();
		$elements = fotosAlbumController::getListAction(20, " AND activo=1 ORDER BY nombre_album ");
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-albumes-new?act=new"><?php e_strTranslate("New_album");?></a></li>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="40px"></th>
							<th><?php e_strTranslate("Name");?></th>
							<th><?php e_strTranslate("User");?></th>
							<th><?php e_strTranslate("Channel");?></th>
							<th><center><?php e_strTranslate("Photos");?></center></th>
						</tr>
						<?php foreach($elements['items'] as $element):
						$num_fotos = connection::countReg("galeria_fotos", "AND estado=1 AND id_album=".$element['id_album']." ");?>
						<tr>
						<td nowrap="nowrap">
							<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Delete");?>" onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>','admin-albumes?pag=<?php echo $elements['pag'];?>&act=del&id=<?php echo $element['id_album'];?>'); return false"><i class="fa fa-trash icon-table"></i>
							</button>

							<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Edit");?>"
								onClick="location.href='admin-albumes-new?act=edit&id=<?php echo $element['id_album'];?>'"><i class="fa fa-edit icon-table"></i>
							</button>

							<button type="button" class="btn btn-default btn-xs"><a href="admin-albumes?export=true&id=<?php echo $element['id_album'];?>" class="fa fa-download icon-table" title="<?php e_strTranslate("Download");?>"></a></button>
								
						</td>
						<td>
							<?php echo $element['nombre_album'];?>
							<br /><em class="text-muted"><small><?php echo getDateFormat($element['date_album'], "LONG");?></small></em>';
						</td>
						<td><?php echo $element['username_album'];?></td>';
						<td><?php echo $element['canal_album'];?></td>';
						<td><center><?php echo $num_fotos;?></center></td>';
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