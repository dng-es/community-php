<?php
//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);

session::getFlashMessage( 'actions_message' );
videosController::validateCommentAction();	  
?>
<div id="page-info"><?php echo strTranslate("Video_comments");?></div>
<div class="row inset row-top">
	<div class="col-md-9">
	<?php getComentariosVideo();?>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo strTranslate("Videos");?></div>
			<div class="panel-body">
				<a href="?page=admin-videos"><?php echo strTranslate("Video_list");?></a>
			</div>
		</div>		
	</div>
</div>
<?php


///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////


function getComentariosVideo()
{
	$videos = new videos();
	$id_file= $_REQUEST['id'];
	$pendientes = $videos->getComentariosVideo(" AND c.estado=1 AND c.id_file=".$id_file." ORDER BY id_comentario DESC");
	if (count($pendientes)==0){
		echo '<div class="alert alert-danger">No hay comentarios en el video</div>';
	}
	else{
	  echo '<table class="table">';
	  echo '<tr>';
	  echo '<th width="40px">&nbsp;</th>';
	  echo '<th>ID</th>';
	  echo '<th>'.strTranslate("Comment").'</th>';
	  echo '<th>'.strTranslate("Author").'</th>';
	  echo '<th>'.strTranslate("Date").'</th>';
	  echo '</tr>';

	  foreach($pendientes as $element):
			echo '<tr>';
			echo '<td nowrap="nowrap">					
					<span class="fa fa-ban icon-table" title="'.strTranslate("Delete").'"
					    onClick="Confirma(\''.strTranslate("Are_you_sure_to_delete").'\',
						\'?page=admin-videos-comentarios&act=elem_ko&idc='.$element['id_comentario'].'&id='.$id_file.'&u='.$element['user_comentario'].'\')">
					</span>			
				 </td>';					
			echo '<td>'.$element['id_comentario'].'</td>';
			echo '<td><em class="legend">'.$element['comentario'].'</em></td>';
			echo '<td>'.$element['user_comentario'].'</td>';
			echo '<td>'.strftime(DATE_FORMAT_SHORT,strtotime($element['date_comentario'])).'</td>';		
			echo '</tr>';   
	  endforeach;
	  echo '</table><br />';	
	}
}
?>