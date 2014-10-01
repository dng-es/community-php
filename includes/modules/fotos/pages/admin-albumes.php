<?php
//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);
?>
<div class="row row-top">
	<div class="col-md-9">
		<h1>Albumes de fotos</h1>
		<?php
		session::getFlashMessage( 'actions_message' );
		fotosAlbumController::deleteAction();
		$elements = fotosAlbumController::getListAction(20, " AND activo=1 ORDER BY nombre_album ");
		?>
		<div class="btn-group"> 
			<a href="?page=admin-albumes-new&act=new" title="<?php echo strTranslate("New_album");?>" class="btn btn-default"><?php echo strTranslate("New_album");?></a>  
		</div>
		<br /><br /> 
		<table class="table">
			<tr>
				<th width="40px"></th>
				<th>Álbum</th>
				<th><?php echo strTranslate("Date");?></th>
				<th><?php echo strTranslate("User");?></th>
				<th><?php echo strTranslate("Photos");?></th>
			</tr>
			<?php foreach($elements['items'] as $element):
			$num_fotos = connection::countReg("galeria_fotos", "AND estado=1 AND id_album=".$element['id_album']." ");
			echo '<tr>';
			echo '<td nowrap="nowrap">
					<span class="fa fa-edit icon-table" title="Ver/editar album"
						onClick="location.href=\'?page=admin-albumes-new&act=edit&id='.$element['id_album'].'\'">
					</span>
					
					<span class="fa fa-ban icon-table" title="'.strTranslate("Delete").'"
						onClick="Confirma(\''.strTranslate("Are_you_sure_to_delete").'\',
						\'?page=admin-albumes&pag='.$elements['pag'].'&act=del&id='.$element['id_album'].'\')">
					</span>
				 </td>';
						
			echo '<td>'.$element['nombre_album'].'</td>';
			echo '<td>'.strftime(DATE_FORMAT_SHORT, strtotime($element['date_album'])).'</td>';
			echo '<td>'.$element['username_album'].'</td>';
			echo '<td>'.$num_fotos.'</td>';
			echo '</tr>';   
			endforeach;?>
		</table>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>