<?php
/**
* Print HTML tema comment. Used in foros, blog, áreas de trabajo
*
* @param 	array 		$comment	comentario data
* @param 	string		$destino 			Links destination (foros, blog, áreas de trabajo) used for "likes"
*/
templateload("tipuser","users");

function commentForo($comment,$destino="foro-comentarios"){
	
	$foro = new foro ();
	$page_num = isset($_GET['pag']) ? $_GET['pag'] : "";

	?>
	<div class="media media-comment">
		<?php userFicha($comment); ?>
		<div class="media-body">
			<p>
				<a href="?page=profile&n=<?php echo $comment['nick']; ?>"><small><?php echo $comment['nick']; ?></small></a><br />
				<span class="text-muted"><small><?php echo getDateFormat($comment['date_comentario'], "LONG")." ".getDateFormat($comment['date_comentario'], "TIME"); ?></small></span>
			</p>
			<p><?php echo $comment['comentario'];?></p>
			
			<div class="comment-info">
				<span class="comment-reply-trigger label" title="<?php echo strTranslate("Reply_comment");?> "><i class="fa fa-mail-reply"></i> <?php echo strTranslate("Reply");?></span> 
				<span class="label" title="<?php echo strTranslate("Vote_comment");?>"><a href="?page=<?php echo $destino.'&id='.$comment['id_tema'].'&idvf='.$comment['id_comentario'].'&pag='.$page_num;?>">
				<i class="fa fa-heart"></i> <?php echo $comment['votaciones'];?></a></span>
				<?php if ($_SESSION['user_perfil'] == 'admin') echo ' <span class="label" title="ID del comentario">id: '.$comment['id_comentario'].'</span>'; ?>	
			</div>
			<div class="comment-reply">
				<form role="form" method="post" action="" class="comment-reply-form">
					<input type="hidden" name="comment-reply-id" value="<?php echo $comment['id_comentario'];?>" />
					<input type="hidden" name="id_tema" value="<?php echo $comment['id_tema'];?>" />
					<textarea class="form-control" name="comment-reply-txt"  class="comment-reply-txt"></textarea>
					<div class="alert-message alert alert-danger">Introduce tu respuesta</div>
					<button type="submit" class="btn btn-primary"><?php echo strTranslate("Reply");?></button>
				</form>
			</div>
			<?php 
				$respuestas = $foro->getComentarios(" AND estado=1 AND id_comentario_id=".$comment['id_comentario']." ORDER BY id_comentario DESC"); 
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