<?php
/**
* Print HTML tema comment. Used in foros, blog, áreas de trabajo
*
* @param 	array 		$comentario_foro	comentario data
* @param 	string		$destino 			Links destination (foros, blog, áreas de trabajo) used for "likes"
*/
templateload("tipuser","users");

function commentForo($comentario_foro,$destino="foro-comentarios"){
	
	$foro = new foro ();
	$page_num = isset($_GET['pag']) ? $_GET['pag'] : "";

	?>
	<div class="media media-comment">
		<?php userFicha($comentario_foro); ?>
		<div class="media-body">
		<p><b><?php echo $comentario_foro['nick']; ?></b> dice: (<?php echo strftime(DATE_FORMAT_SHORT,strtotime($comentario_foro['date_comentario'])); ?>)</p>
		<p><?php echo $comentario_foro['comentario'];?></p>				
		<div class="comment-info">
			<span class="comment-reply-trigger label label-info" title="responder el comentario"><i class="fa fa-mail-reply"></i> Responder</span> 
			<span class="label label-info" title="votar el comentario"><a class="fa fa-heart tooltip-top" href="?page=<?php echo $destino.'&id='.$comentario_foro['id_tema'].'&idvf='.$comentario_foro['id_comentario'].'&pag='.$page_num;?>">
			</a> <?php echo $comentario_foro['votaciones'];?></span>
			<?php if ($_SESSION['user_perfil'] == 'admin') echo ' <span class="label label-info">id:'.$comentario_foro['id_comentario'].'</span>'; ?>	
		</div>
		
		<div class="comment-reply">
			<form role="form" method="post" action="" class="comment-reply-form">
				<input type="hidden" name="comment-reply-id" value="<?php echo $comentario_foro['id_comentario'];?>" />
				<input type="hidden" name="id_tema" value="<?php echo $comentario_foro['id_tema'];?>" />
				<textarea class="form-control" name="comment-reply-txt"  class="comment-reply-txt"></textarea>
				<div class="alert-message alert alert-danger">Introduce tu respuesta</div>
				<button type="submit" class="btn btn-primary">Responder</button>
			</form>
		</div>
		<?php 
			$respuestas = $foro->getComentarios(" AND estado=1 AND id_comentario_id=".$comentario_foro['id_comentario']." ORDER BY id_comentario DESC"); 
			foreach($respuestas as $respuesta):
				commentForo($respuesta, $destino);
			endforeach;
		?>
		</div>
	</div>
	<?php
}

function commentForoRespuestas($id_comentario){

}
?>