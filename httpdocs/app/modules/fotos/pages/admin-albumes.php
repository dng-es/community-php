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
					<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-albumes-new?act=new"><?php echo strTranslate("New_album");?></a></li>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="40px"></th>
							<th><?php echo strTranslate("Name");?></th>
							<th><?php echo strTranslate("User");?></th>
							<th><center><?php echo strTranslate("Photos");?></center></th>
						</tr>
						<?php foreach($elements['items'] as $element):
						$num_fotos = connection::countReg("galeria_fotos", "AND estado=1 AND id_album=".$element['id_album']." "); ?>
						<tr>
						<td nowrap="nowrap">
								<span class="fa fa-edit icon-table" title="<?php echo strTranslate("Edit");?>"
									onClick="location.href='admin-albumes-new?act=edit&id=<?php echo $element['id_album'];?>'">
								</span>

								<a href="admin-albumes?export=true&id=<?php echo $element['id_album'];?>" class="fa fa-download icon-table" title="<?php echo strTranslate("Download");?>"></a>
								
						<?php	
						echo '		<span class="fa fa-ban icon-table" title="'.strTranslate("Delete").'"
									onClick="Confirma(\''.strTranslate("Are_you_sure_to_delete").'\',
									\'admin-albumes?pag='.$elements['pag'].'&act=del&id='.$element['id_album'].'\')">
								</span>
							 </td>';
									
						echo '<td>'.$element['nombre_album'];
						echo '<br /><em class="text-muted"><small>'.getDateFormat($element['date_album'], "LONG").'</small></em>';
						echo '</td>';
						echo '<td>'.$element['username_album'].'</td>';
						echo '<td><center>'.$num_fotos.'</center></td>';
						echo '</tr>';
						endforeach;?>
					</table>
				</div>
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>