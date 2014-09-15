<?php
//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);

$fotos = new fotos(); 
$users = new users();

	//VALIDAR COMENTARIOS
if (isset($_REQUEST['act'])) { 	 
	if ($_REQUEST['act']=='foto_ko'){
		$fotos->cambiarEstadoComentario($_REQUEST['id'],2);
	}
	header("Location: ?page=admin-fotos-comentarios&id=".$_REQUEST['idt']."&ida=".$_REQUEST['ida']); 
}

$id_file = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$pendientes = $fotos->getComentariosFoto(" AND c.estado=1 AND c.id_file=".$id_file." ORDER BY id_comentario DESC"); ?>

<div class="row row-top">
	<div class="col-md-9">
		<h1>Comentarios en la foto</h1>
		<?php if (count($pendientes)==0){
			echo '<div class="alert alert-warning">No hay comentarios en la foto</div>';
		}
		else{
		echo '<a href="?page=admin-albumes-new&act=edit&id='.$_REQUEST['ida'].'">Volver al album</a>';
		  echo '<table class="table table-striped">';
		  echo '<tr>';
		  echo '<th width="40px">&nbsp;</th>';
		  echo '<th>ID</th>';
		  echo '<th>Comentario</th>';
		  echo '<th>Autor</th>';
		  echo '<th>Fecha</th>';
		  echo '</tr>';


		  foreach($pendientes as $element):
				echo '<tr>';
				echo '<td nowrap="nowrap">					
						<span class="fa fa-ban icon-table" title="Eliminar"
						    onClick="Confirma(\'¿Seguro que deseas eliminar el comentario '.$element['id_comentario'].'?\',
							\'?page=admin-fotos-comentarios&act=foto_ko&id='.$element['id_comentario'].'&ida='.$_REQUEST['ida'].'&idt='.$id_file.'&u='.$element['user_comentario'].'\')">
						</span>			
					 </td>';					
				echo '<td>'.$element['id_comentario'].'</td>';
				echo '<td><em class="legend">'.$element['comentario'].'</em></td>';
				echo '<td>'.$element['user_comentario'].'</td>';
				echo '<td>'.strftime(DATE_FORMAT_SHORT,strtotime($element['date_comentario'])).'</td>';		
				echo '</tr>';   
		  endforeach;
		  echo '</table><br />';	
		}?>
	</div>
	<?php menu::adminMenu();?>
</div>