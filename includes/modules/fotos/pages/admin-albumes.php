<?php
//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);
?>
<div class="row row-top">
	<div class="col-md-9">
		<h1><?php echo strTranslate("Photo_albums");?></h1>
		<?php
		session::getFlashMessage( 'actions_message' );
		fotosAlbumController::deleteAction();
		fotosAlbumController::downloadAction();
		$elements = fotosAlbumController::getListAction(20, " AND activo=1 ORDER BY nombre_album ");
		?>
		<ul class="nav nav-pills navbar-default"> 
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>      
			<li><a href="?page=admin-albumes-new&act=new"><?php echo strTranslate("New_album");?></a></li>
		</ul>
		<table class="table">
			<tr>
				<th width="40px"></th>
				<th><?php echo strTranslate("Name");?></th>
				<th><?php echo strTranslate("Date");?></th>
				<th><?php echo strTranslate("User");?></th>
				<th><?php echo strTranslate("Photos");?></th>
			</tr>
			<?php foreach($elements['items'] as $element):
			$num_fotos = connection::countReg("galeria_fotos", "AND estado=1 AND id_album=".$element['id_album']." "); ?>
			<tr>
			<td nowrap="nowrap">
					<span class="fa fa-edit icon-table" title="<?php echo strTranslate("Edit");?>"
						onClick="location.href='?page=admin-albumes-new&act=edit&id=<?php echo $element['id_album'];?>'">
					</span>
			
					<a href="?page=admin-albumes&export=true&id=<?php echo $element['id_album'];?>" class="fa fa-download icon-table" title="<?php echo strTranslate("Download");?>"></a>
					
			<?php	
			echo '		<span class="fa fa-ban icon-table" title="'.strTranslate("Delete").'"
						onClick="Confirma(\''.strTranslate("Are_you_sure_to_delete").'\',
						\'?page=admin-albumes&pag='.$elements['pag'].'&act=del&id='.$element['id_album'].'\')">
					</span>
				 </td>';
						
			echo '<td>'.$element['nombre_album'].'</td>';
			echo '<td>'.getDateFormat($element['date_album'], "SHORT").'</td>';
			echo '<td>'.$element['username_album'].'</td>';
			echo '<td>'.$num_fotos.'</td>';
			echo '</tr>';   
			endforeach;?>
		</table>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>